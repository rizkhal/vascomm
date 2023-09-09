<template>
  <main>
    <div
      class="p-4 block sm:flex lg:mt-1.5 bg-white items-center justify-between border-b border-gray-200"
    >
      <div class="mb-1 w-full">
        <div class="sm:flex">
          <div class="flex items-center">
            <InputSelect v-model="params.perpage" class="w-[60px] mr-2 mt-1">
              <option v-for="(item, index) in perpages" :key="index" :value="item">
                {{ item }}
              </option>
            </InputSelect>
            <Search v-model="params.search" />
          </div>
          <div class="flex items-center space-x-2 sm:space-x-3 ml-auto">
            <slot name="attributes" />

            <template v-for="(action, index) in actions" :key="index">
              <button type="button" @click="action.action" class="btn-primary">
                <span class="mr-1.5">{{ action.text }}</span>
                <v-icon v-if="action.icon" :name="action.icon" class="w-5 h-5" type="outline" />
              </button>
            </template>

            <div class="ml-3 relative" v-if="Object.keys(data.fields).length">
              <v-dropdown width="32" align="right">
                <template #trigger>
                  <button class="btn-gray">
                    <FunnelIcon class="mr-2 h-4 w-4" />
                    <span>Filter</span>
                  </button>
                </template>
                <template #content>
                  <div class="flex flex-col space-y-2 p-2">
                    <template v-for="(field, key) in data.fields" :key="key">
                      <template v-if="field.type === 'select'">
                        <v-select
                          class="w-64"
                          :v-model="key"
                          :label="data.fields[key].name"
                          @change="handleOnSelectFilter($event, key, 'select')"
                        >
                          <option></option>
                          <option
                            v-for="(option, key) in field.attributes.options"
                            :key="key"
                            :value="option.value"
                          >
                            {{ option.label }}
                          </option>
                        </v-select>
                      </template>
                    </template>

                    <button
                      type="button"
                      class="btn-red w-full"
                      @click.prevent="handleOnClearFilter"
                    >
                      Bersihkan
                    </button>
                  </div>
                </template>
              </v-dropdown>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="flex flex-col">
      <div class="overflow-x-auto">
        <div class="align-middle inline-block min-w-full">
          <div class="shadow overflow-hidden">
            <table class="table-fixed min-w-full divide-y divide-gray-200">
              <thead class="bg-gray-100">
                <Column
                  :params="params"
                  :columns="data.columns"
                  :selectAll="selectAll"
                  @onSort="handleOnSort"
                  @onSelectAll="handleOnSelectAll"
                />
              </thead>
              <tbody class="bg-white divide-y divide-gray-200" v-if="data.data.data.length">
                <tr v-for="(item, index) in data.data.data" :key="index" class="hover:bg-gray-100">
                  <template v-for="(column, i) in data.columns" :key="i">
                    <td v-if="column.blank && column.checkbox" class="p-4 w-4">
                      <div class="flex items-center">
                        <input
                          :id="`checkbox-${id}`"
                          type="checkbox"
                          @change="handleOnSelect"
                          v-model="selected"
                          :value="item[checkboxKey]"
                          class="h-4 w-4 rounded bg-gray-50 border-gray-300 focus:ring-3 focus:ring-gray-200"
                        />
                        <label :for="`checkbox-${id}`" class="sr-only">checkbox</label>
                      </div>
                    </td>
                    <td
                      v-else-if="!column.blank"
                      class="p-4 whitespace-nowrap text-base font-medium text-gray-900"
                    >
                      <slot :name="column.column" :item="item" />
                      <div v-if="!$slots[column.column]">
                        <div v-if="!item[column.column] && column.na">
                          <InertableRowNullable :value="null" />
                        </div>
                        <div v-else>
                          {{ item[column.column] }}
                        </div>
                      </div>
                    </td>
                  </template>
                </tr>
              </tbody>
              <tbody class="bg-white divide-y divide-gray-200" v-else>
                <tr>
                  <td class="text-center p-4 text-gray-600" :colspan="data.columns.length">
                    Kosong
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>

    <Pagination
      :total="data.data.total"
      :last="data.data.last_page"
      :current="data.data.current_page"
      :from="data.data.from"
      :to="data.data.to"
      @loadPage="handleOnLoadPage"
    />
  </main>
</template>
<script>
import { v4 as uuid } from "uuid";
import { pickBy, throttle } from "lodash";
import { FunnelIcon } from "@heroicons/vue/24/solid";

// filter
import Dropdown from "../filter/dropdown.vue";
import DropdownLink from "../filter/dropdown-link.vue";
import Search from "../filter/search.vue";
import InputSelect from "../filter/input-select.vue";

// table
import Nullable from "./nullable.vue";
import Column from "./column.vue";
import Pagination from "./pagination.vue";

export default {
  name: "Inertable",
  components: {
    Nullable,
    Column,
    Search,
    Pagination,
    FunnelIcon,
    InputSelect,
    Dropdown,
    DropdownLink,
  },
  props: {
    data: Object,
    actions: [Array, Object],
    checkboxKey: {
      type: String,
      default: "id",
    },
  },
  data() {
    return {
      selected: [],
      selectAll: false,

      id: uuid(),
      perpages: [15, 30, 50],
      params: {
        column: this.data.filters?.column,
        search: this.data.filters?.search,
        direction: this.data.filters?.direction,
        perpage: this.data.filters?.perpage ?? 15,
        page: this.data.current_page,
        filters: this.data.filters.filters
          ? Object.keys(this.data.filters.filters).reduce(
              (ac, a) => ({ ...ac, [a]: this.data.filters.filters[a] }),
              {},
            )
          : null,
      },
      filtersModels: this.data.fields
        ? Object.keys(this.data.fields).reduce((ac, a) => ({ ...ac, [a]: null }), {})
        : null,
    };
  },
  methods: {
    handleOnSort(column) {
      if (!this.data.filters) return;

      this.params.column = column;
      this.params.direction = this.params.direction === "asc" ? "desc" : "asc";
    },
    handleOnLoadPage(page) {
      this.params.page = page;
    },
    handleOnSelectFilter(event, key, type) {
      if (this.params.filters) {
        this.params.filters = Object.assign(this.params.filters, {
          [key]: event.target.value,
        });
      } else {
        this.params.filters = {
          [key]: event.target.value,
        };
      }
    },
    handleOnClearFilter() {
      if (this.params.filters) {
        Object.keys(this.params.filters).some((value) => {
          this.filtersModels[value] = null;
        });

        this.params.filters = null;
      }
    },
    handleOnSelect() {
      let selected = this.data.data.data.filter((value) =>
        Object.values(this.selected).includes(value[this.checkboxKey]),
      );

      this.$emit("on-select", selected);
    },
    handleOnSelectAll() {
      let all = [];
      this.selected = [];

      if (!this.selectAll) {
        for (let item in this.data.data.data) {
          all.push(this.data.data.data[item]);
          this.selected.push(this.data.data.data[item][this.checkboxKey]);
        }
      }

      this.$emit("on-select-all", all);
    },
  },
  watch: {
    params: {
      handler: throttle(function () {
        let params = pickBy(this.params);

        this.$inertia.get(`${window.location.pathname}`, params, {
          replace: true,
          preserveState: true,
        });
      }, 100),
      deep: true,
    },
    selected: {
      handler: function () {
        if (this.data.data.data.length != this.selected.length) {
          this.selectAll = false;
        } else {
          this.selectAll = true;
        }
      },
      deep: true,
    },
  },
};
</script>

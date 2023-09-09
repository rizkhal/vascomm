<script setup>
import Edit from "./edit.vue";
import Create from "./create.vue";

defineProps({
  inertable: Object,
});

const statusClasses = (subject) => {
  return {
    active: "bg-emerald-600 py-1 px-2 text-xs text-emerald-50 rounded-lg",
    inactive: "bg-red-600 py-1 px-2 text-xs text-red-50 rounded-lg",
  }[subject];
};
</script>
<template>
  <div>
    <Inertable
      :data="inertable"
      :actions="[
        {
          text: 'Tambah Produk',
          action: () => {
            $modal.open({
              maxWidth: '2xl',
              component: Create,
            });
          },
        },
      ]"
    >
      <template
        #picture="{
          item: {
            picture: { full_path },
          },
        }"
      >
        <img :src="full_path" :alt="full_path" class="rounded-md w-10 h-10" />
      </template>
      <template #status="{ item: { status } }">
        <span :class="statusClasses(status.value)">{{ status.label }}</span>
      </template>
      <template #action="{ item }">
        <div class="flex flex-row space-x-2">
          <button
            @click.prevent="
              $modal.open({
                item,
                isShow: true,
                maxWidth: '2xl',
                component: Edit,
              })
            "
            class="btn-green p-2 inline-flex items-center rounded-xl"
          >
            <v-icon name="EyeIcon" class="w-3 h-3" />
          </button>
          <button
            v-if="$page.props.auth.roles.filter((row) => ['admin'].includes(row.name)).length"
            @click.prevent="
              $modal.open({
                item,
                maxWidth: '2xl',
                component: Edit,
              })
            "
            class="btn-yellow p-2 inline-flex items-center rounded-xl"
          >
            <v-icon name="PencilSquareIcon" class="w-3 h-3" />
          </button>
          <button
            v-if="$page.props.auth.roles.filter((row) => ['admin'].includes(row.name)).length"
            @click.prevent="
              $modal.openDialog({
                message: `Apakah kamu yakin menghapus ${item.name}?`,
                toRoute: route('products.destroy', {
                  product: item.id,
                }),
              })
            "
            class="btn-red p-2 inline-flex items-center rounded-xl"
          >
            <v-icon name="TrashIcon" class="w-3 h-3" />
          </button>
        </div>
      </template>
    </Inertable>
  </div>
</template>

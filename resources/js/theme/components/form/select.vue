<template>
  <div :class="$attrs.class">
    <label v-if="label" class="text-sm font-medium text-gray-900 block mb-1" :for="id">
      {{ label }}
      <span v-show="required" class="text-red-500">*</span>
    </label>
    <select
      :id="id"
      ref="input"
      v-model="selected"
      v-bind="{ ...$attrs, class: null }"
      :class="{ 'border-red-500 border': error }"
      class="
        bg-gray-50
        border border-gray-300
        text-gray-900
        sm:text-sm
        rounded
        focus:ring-gray-600 focus:border-gray-600
        block
        w-full
        p-2.5
      "
    >
      <slot />
    </select>
    <div v-if="error" class="text-red-500 text-sm mt-1">{{ error }}</div>
  </div>
</template>

<script>
import { v4 as uuid } from "uuid";

export default {
  name: "VSelect",
  inheritAttrs: false,
  props: {
    id: {
      type: String,
      default() {
        return `select-input-${uuid()}`;
      },
    },
    error: String,
    label: String,
    required: Boolean,
    modelValue: [String, Number, Boolean],
  },
  emits: ["update:modelValue"],
  data() {
    return {
      selected: this.modelValue,
    };
  },
  watch: {
    selected(selected) {
      this.$emit("update:modelValue", selected);
    },
  },
  methods: {
    focus() {
      this.$refs.input.focus();
    },
    select() {
      this.$refs.input.select();
    },
  },
};
</script>
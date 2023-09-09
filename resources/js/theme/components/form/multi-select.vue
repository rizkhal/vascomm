<template>
 <div>
  <label v-if="label" class="text-sm font-medium text-slate-700 block mb-1">
   {{ label }}
   <span v-show="required" class="text-red-500">*</span>
  </label>

  <Multiselect
   ref="selectRef"
   :delay="300"
   v-bind="{ ...$attrs }"
   v-model="modelValueRef"
   :min-chars="1"
   :resolve-on-load="false"
   :options="options"
   :placeholder="placeholder"
   no-options-text="Tidak ada piilhan"
   :class="[error ? 'border-red-500' : 'border-gray-300']"
  >
   <!--
    :object="true"
    :searchable="true"
    :filter-results="false"
    :resolve-on-load="false"
  -->

   <slot />
   <!-- <template #singlelabel="{ value }">
        <slot name="singlelabel" :value="value" />
      </template> -->

   <!-- <template #option="{ option }">
        <slot name="option" :option="option" />
      </template> -->
  </Multiselect>
  <div v-if="error" class="form-error">
   {{ error }}
  </div>
 </div>
</template>
<style lang="css">
@import "../../../../css/multi-select.css";
</style>
<script setup name="VMultiSelect">
import { watch, ref } from "vue";
import Multiselect from "@vueform/multiselect";

const props = defineProps({
 error: {
  type: String,
  required: false,
  default: null,
 },
 label: {
  type: String,
  required: false,
  default: null,
 },
 required: {
  type: Boolean,
  default: () => false,
 },
 modelValue: {
  type: Object,
 },
 options: {
  type: [Array, Object, Function],
  required: true,
 },
 placeholder: {
  type: String,
  required: false,
 },
});

const modelValueRef = ref(props.modelValue);

const emit = defineEmits(["update:modelValue"]);

watch(
 () => modelValueRef.value,
 (value) => {
  emit("update:modelValue", value);
 },
);

watch(
 () => props.modelValue,
 (value) => {
  modelValueRef.value = value;
 },
);
</script>

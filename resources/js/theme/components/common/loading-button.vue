<script setup name="VLoadingButton">
defineProps({
  loading: {
    type: Boolean,
    default: false,
  },
  label: {
    type: String,
    required: false,
  },
  icon: {
    default: null,
  },
  iconType: {
    default: "outline",
  },
  disabled: {
    default: false,
    type: Boolean,
  },
});
</script>
<template>
  <div>
    <button
      :disabled="loading || disabled"
      class="flex items-center space-x-1 disabled:cursor-not-allowed rounded"
      :class="[
        disabled ? 'bg-opacity-75 focus:bg-opacity-75' : '',
        loading ? 'flex flex-row items-center bg-opacity-80 pointer-events-none' : '',
      ]"
    >
      <v-icon
        v-if="icon && !loading"
        :name="icon"
        :type="iconType"
        class="inline-flex h-4 w-4 text-gray-100"
      />

      <span v-if="loading" class="flex flex-row items-center h-4 w-4 mr-1">
        <v-loading-icon />
      </span>

      <div>
        <slot :loading="loading">
          <span v-if="!loading">{{ label }}</span>
          <span v-else>Loading ...</span>
        </slot>
      </div>
    </button>
  </div>
</template>

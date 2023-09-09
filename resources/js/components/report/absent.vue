<script setup lang="ts">
defineProps<{
 icon: string;
 text: string;
}>();
</script>
<template>
 <div
  class="p-1 border-2 rounded-lg border-slate-200 flex flex-row space-x-1 items-center justify-center"
 >
  <v-icon :name="icon" class="w-4 h-4" />
  <span class="text-xs">{{ text }}</span>
 </div>
</template>

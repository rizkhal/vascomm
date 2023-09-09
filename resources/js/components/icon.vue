<template>
 <span>
  <Icon :icon="icon" :width="size" />
 </span>
</template>
<script setup name="Icon">
import { Icon } from "@iconify/vue";

defineProps({
 icon: {
  type: String,
  default: "heroicons-outline:home",
 },
 size: {
  default: 20,
 },
});
</script>
<style lang=""></style>

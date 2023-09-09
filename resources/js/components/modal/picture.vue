<script setup>
defineProps({
  file: String,
});
</script>
<template>
  <div class="p-2 bg-white shadow rounded-md">
    <img :src="file" alt="Image" class="rounded-md" />
  </div>
</template>
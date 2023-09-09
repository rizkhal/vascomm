<script setup name="Card">
defineProps({
  label: null,
  value: null,
});
</script>
<template>
  <div class="w-auto relative bg-white p-4 rounded bg-gradient-to-r from-[#ADC9FF] to-[#C2D6FF]">
    <div class="flex flex-col">
      <strong class="font-thin text-sm text-slate-600">{{ label }}</strong>
      <span class="text-3xl text-slate-600 mt-2">{{ value }}</span>
    </div>
    <div class="e"></div>
    <div class="e2"></div>
  </div>
</template>
<style scoped>
.e {
  position: absolute;
  width: 70px;
  height: 70px;
  bottom: 0.5em;
  right: -2em;
  background: #fff;
  opacity: 0.2;
  border-radius: 100%;
}
.e2 {
  position: absolute;
  width: 70px;
  height: 70px;
  bottom: -2em;
  right: 0.1em;
  background: #fff;
  opacity: 0.2;
  border-radius: 100%;
}
</style>

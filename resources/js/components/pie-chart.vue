<template>
 <div>
  <v-apexchart type="pie" :series="chart.series" :options="chart.options" class="max-w-[30em]" />
 </div>
</template>
<script setup>
import { watch, reactive, onMounted } from "vue";

const props = defineProps({
 data: Object,
});

const { series, chartOptions } = props.data;

const chart = reactive({
 series: series,
 options: chartOptions,
});
</script>

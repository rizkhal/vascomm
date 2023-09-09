<script setup lang="ts">
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";

import leaflet from "leaflet";
import "leaflet/dist/leaflet.css";
import "leaflet-draw/dist/leaflet.draw.css";
import "leaflet-toolbar/dist/leaflet.toolbar.css";

import "@geoman-io/leaflet-geoman-free";
import "@geoman-io/leaflet-geoman-free/dist/leaflet-geoman.css";

const props = defineProps({
 cordinates: {
  type: Array,
 },
});

const emit = defineEmits(["pm:create"]);

const mapRef = ref();
const page = usePage();

onMounted(() => {
 const { cordinate } = page.props.auth;
 mapRef.value = leaflet.map("map").setView(cordinate, 7);

 leaflet
  .tileLayer("https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png", {
   tileSize: 512,
   zoomOffset: -1,
  })
  .addTo(mapRef.value);

 mapRef.value.pm.addControls({
  position: "topleft",
  drawCircle: false,
  drawRectangle: false,
  drawPolyline: false,
  drawCircleMarker: false,
  drawText: false,
  drawMarker: false,
  editControls: false,
 });

 mapRef.value.on("pm:create", ({ marker }: any) => {
  emit("pm:create", marker._latlngs);
 });

 if (props.cordinates) {
  leaflet.polygon(props.cordinates).addTo(mapRef.value);
 }

 mapRef.value.attributionControl.setPrefix(null); // remove ukraine flag
});
</script>
<template>
 <div class="relative">
  <div class="h-screen overflow-hidden" id="map"></div>
 </div>
</template>

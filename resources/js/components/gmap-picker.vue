<template>
 <GoogleMap
  api-key="AIzaSyAISwXwMy9RIBS6qnrxkC3fPRL3hfSrJSg"
  style="width: 100%; height: 500px"
  :center="center"
  :zoom="15"
 >
  <slot name="marker">
   <Marker :options="markerOptions" />
  </slot>
 </GoogleMap>
</template>

<script setup>
import { GoogleMap, Marker } from "vue3-google-map";

// center poin di watompone
const center = { lat: -4.5387719, lng: 120.324997 };
const markerOptions = {};
</script>

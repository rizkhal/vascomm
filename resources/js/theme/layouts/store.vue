<script setup name="VStoreLayout">
import { watch } from "vue";
import Toast from "~/packages/toast/toast";

const props = defineProps({
 auth: Object,
 title: String,
 flash: Object,
});

watch(
 () => props.flash,
 (payload) => {
  if (payload) {
   if (payload.success) {
    if (typeof payload.success == "object") {
     Toast.success(payload.success);
    } else {
     Toast.success({ title: payload.success });
    }
   }

   if (payload.error) {
    if (typeof payload.error == "object") {
     Toast.error(payload.error);
    } else {
     Toast.error({ title: payload.error });
    }
   }
  }
 },
 { deep: true },
);
</script>
<template>
 <v-app-head>
  <title>{{ title }}</title>
 </v-app-head>

 <!-- toast -->
 <v-toast-list />

 <div class="px-3 md:px-0">
  <div class="mx-auto max-w-6xl mb-6">
   <h1
    class="
     leading-relaxed
     font-primary font-extrabold
     text-4xl text-center text-palette-primary
     mt-4
     py-2
     sm:py-4
    "
   >
    Get your template!
   </h1>
   <p class="max-w-xl text-center px-2 mx-auto text-base text-gray-600">
    Tersedia template gratis dan premium, silahkan dipilih!
   </p>
  </div>

  <slot />
 </div>
</template>
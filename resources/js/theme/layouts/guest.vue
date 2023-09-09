<script setup name="VGuestLayout">
const props = defineProps({
 title: String,
 flash: Object,
});

// watch(
//   () => props.flash,
//   (payload) => {
//     if (payload) {
//       if (payload.success) {
//         if (typeof payload.success == "object") {
//           Toast.success(payload.success);
//         } else {
//           Toast.success({ title: payload.success });
//         }
//       }

//       if (payload.error) {
//         if (typeof payload.error == "object") {
//           Toast.error(payload.error);
//         } else {
//           Toast.error({ title: payload.error });
//         }
//       }
//     }
//   },
//   { deep: true }
// );
</script>
<template>
 <v-app-head :title="title" />
 <div>
  <slot />
 </div>
</template>
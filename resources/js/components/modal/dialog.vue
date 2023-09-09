<script setup lang="ts">
import { router } from "@inertiajs/vue3";

defineProps<{
 toRoute: string;
 message?: string;
}>();
</script>
<template>
 <v-modal-container class="p-6 text-center">
  <div class="w-20 p-1 h-20 mx-auto bg-red-200 rounded-md mb-2">
   <v-icon name="ExclamationTriangleIcon" class="mb-4 w-full h-full text-red-500" />
  </div>
  <div class="mb-5">
   <h3 class="mb-2 text-2xl font-bold text-slate-700">Apakah anda yakin?</h3>
   <div class="text-slate-500 leading-relaxed">
    <p v-if="message" v-html="message"></p>
    <p v-else>Tindakan ini akan menghapus data secara permanen!</p>
   </div>
  </div>
  <div class="flex flex-row justify-center items-center space-x-2">
   <button
    class="btn-red"
    @click.stop="
     router.delete(toRoute, {
      onSuccess: () => $modal.close(),
     })
    "
   >
    Ya, Hapus!
   </button>
   <button @click.stop="$modal.close()" type="button" class="btn-gray">Batal</button>
  </div>
 </v-modal-container>
</template>

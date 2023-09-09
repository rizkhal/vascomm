<script setup lang="ts">
import { router } from "@inertiajs/vue3";

defineProps<{
  toRoute: string;
  message?: string;
}>();
</script>
<template>
  <v-modal-container class="text-center">
    <div class="relative flex">
      <div class="c flex left-0 inset-0"></div>
    </div>
    <div class="-mt-10">
      <div
        class="w-16 h-16 mx-auto bg-red-600 rounded-full absolute inset-x-0 flex justify-center items-center"
      >
        <svg
          fill="white"
          height="800px"
          width="800px"
          viewBox="0 0 330 330"
          class="w-10 h-10 absolute"
        >
          <path
            d="M239.999,75H90c-49.626,0-90,40.374-90,90s40.374,90,90,90h149.999c49.626,0,90-40.374,90-90
	S289.625,75,239.999,75z M30,165c0-33.084,26.916-60,60-60s60,26.916,60,60s-26.916,60-60,60S30,198.084,30,165z M239.999,225
	h-82.98c14.281-15.935,22.98-36.969,22.98-60s-8.699-44.065-22.98-60h82.98c33.084,0,60,26.916,60,60S273.083,225,239.999,225z"
          />
        </svg>
      </div>
    </div>
    <div class="p-6 mt-20 mb-5">
      <h3 class="mb-2 text-lg font-bold text-slate-700">Konfirmasi Hapus</h3>
      <div class="text-slate-500 leading-relaxed">
        <p v-if="message" v-html="message"></p>
        <p v-else>Tindakan ini akan menghapus data secara permanen!</p>
      </div>
    </div>
    <div class="flex flex-row border-t border-slate-300 justify-end items-center space-x-4 p-4">
      <button @click.stop="$modal.close()" type="button" class="btn">Batal</button>
      <button
        class="btn-primary rounded"
        @click.stop="
          router.delete(toRoute, {
            onSuccess: () => $modal.close(),
          })
        "
      >
        Hapus
      </button>
    </div>
  </v-modal-container>
</template>
<style>
.c {
  width: 100em;
  height: 4em;
  background: #41a0e4;
  border-bottom-left-radius: 100%;
  border-bottom-right-radius: 100%;
}
</style>

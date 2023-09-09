<script setup>
import { useForm } from "@inertiajs/vue3";

const form = useForm({
  username: null,
  password: null,
});
</script>
<script>
import GuestLayout from "~/theme/layouts/guest.vue";

export default {
  layout: GuestLayout,
};
</script>
<template>
  <div class="inline-flex justify-between w-full h-screen">
    <div class="w-full h-screen bg-primary overflow-hidden relative">
      <div class="e1 rounded-full overflow-hidden"></div>
      <div class="e2 rounded-full overflow-hidden"></div>
      <div
        class="flex justify-center items-center h-screen absolute z-50 inset-0 flex-col space-y-4"
      >
        <h1 class="text-4xl uppercase font-medium text-black">Nama Aplikasi</h1>
        <p class="w-1/2 text-center font-light">
          Lorem, ipsum dolor sit amet consectetur adipisicing elit. Repellendus facere veritatis eos
          id numquam deserunt at iusto dolore animi nam.
        </p>
      </div>
    </div>
    <div class="w-full bg-white min-h-screen flex items-center justify-center">
      <form class="mt-8 space-y-6 w-1/2">
        <div class="space-y-4 rounded-md shadow-sm">
          <v-input
            v-model="form.username"
            :error="form.errors.username"
            label="Email / Nomor Telpon"
            :required="true"
            placeholder="Contoh: admin@gmail.com"
          />

          <v-input
            v-model="form.password"
            :error="form.errors.password"
            label="Password"
            type="password"
            :required="true"
            placeholder="Masukan password"
          />
        </div>

        <v-loading-button
          class="btn-primary w-full"
          @click.prevent="form.post(route('login'))"
          :loading="form.processing"
        >
          <template #default="{ loading }">
            <div class="flex flex-row items-center space-x-1">
              <span v-if="loading">Loading..</span>
              <div v-else class="flex flex-row items-center space-x-1">
                <span>Masuk</span>
              </div>
            </div>
          </template>
        </v-loading-button>
      </form>
    </div>
  </div>
</template>
<style scoped>
.e1 {
  position: absolute;
  width: 69em;
  height: 55em;
  left: -38em;
  top: -8em;
  background: rgba(255, 255, 255, 0.15);
}

.e2 {
  position: absolute;
  width: 66em;
  height: 200em;
  left: -100px;
  top: 25em;
  background: rgba(255, 255, 255, 0.15);
}
</style>

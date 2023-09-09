<script setup>
import { inject } from "vue";
import { useForm } from "@inertiajs/vue3";
import route from "ziggy-js";

const modal = inject("$modal");

const form = useForm({
  name: null,
  email: null,
  phone_number: null,
});

const save = () => {
  form.post(route("users.store"), {
    onSuccess: () => {
      modal.close();
    },
  });
};
</script>
<template>
  <v-modal-container>
    <div class="p-4 flex flex-row text-center w-full">
      <h1 class="font-bold w-full text-center text-slate-700">Tambah User</h1>
      <span @click="$modal.close()" class="cursor-pointer absolute right-4">
        <v-icon
          name="XMarkIcon"
          type="outline"
          class="w-5 h-5 duration-75 text-gray-500 transition-all group-hover:text-gray-900"
        />
      </span>
    </div>
    <div class="flex flex-col space-y-6 p-4">
      <v-input
        type="text"
        label="Nama"
        class="w-full"
        :required="true"
        v-model="form.name"
        :error="form.errors.name"
        placeholder="Masukan Nama"
      />
      <v-input
        type="number"
        label="Nomor Telepon"
        :required="true"
        class="w-full"
        v-model="form.phone_number"
        :error="form.errors.phone_number"
        placeholder="Masukan Nomor Telepon"
      />
      <v-input
        type="email"
        label="Email"
        :required="true"
        class="w-full"
        v-model="form.email"
        :error="form.errors.email"
        placeholder="Masukan Email"
      />
      <button class="btn-primary" @click.prevent="save">Simpan</button>
    </div>
  </v-modal-container>
</template>

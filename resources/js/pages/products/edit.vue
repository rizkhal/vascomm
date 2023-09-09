<script setup>
import { inject } from "vue";
import { useForm } from "@inertiajs/vue3";
import route from "ziggy-js";

const modal = inject("$modal");

const props = defineProps({
  item: Object,
  isShow: Boolean,
});

const form = useForm({
  name: props.item.name,
  price: props.item.price,
});

const save = () => {
  form.post(
    route("products.updated", {
      product: props.item.id,
    }),
    {
      onSuccess: () => {
        modal.close();
      },
    },
  );
};
</script>
<template>
  <v-modal-container>
    <div class="p-4 flex flex-row text-center w-full">
      <h1 class="font-bold w-full text-center text-slate-700">
        {{ isShow ? "Lihat" : "Ubah" }} Produk
      </h1>
      <span @click="$modal.close()" class="cursor-pointer absolute right-4">
        <v-icon
          name="XMarkIcon"
          type="outline"
          class="w-5 h-5 duration-75 text-gray-500 transition-all group-hover:text-gray-900"
        />
      </span>
    </div>
    <div class="flex flex-col space-y-6 p-4">
      <div v-if="isShow" class="flex justify-center">
        <img :src="item.picture.full_path" :alt="item.name" class="rounded-md w-1/2 h-1/2" />
      </div>

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
        label="Harga"
        :required="true"
        class="w-full"
        v-model="form.price"
        :error="form.errors.price"
        placeholder="Masukan Harga"
      />
      <button v-if="!isShow" class="btn-primary" @click.prevent="save">Simpan</button>
    </div>
  </v-modal-container>
</template>

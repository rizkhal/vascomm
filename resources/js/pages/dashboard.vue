<script setup>
import Card from "~/components/card.vue";
import { id } from "date-fns/locale";
import { format } from "date-fns";

defineProps({
  user: Number,
  user_active: Number,
  product: Number,
  product_active: Number,
  latest_products: Object,
});

function formatIDRCurrency(amount, locale = "id-ID") {
  try {
    const formatted = new Intl.NumberFormat(locale, {
      style: "currency",
      currency: "IDR",
      minimumFractionDigits: 0,
    }).format(amount);

    return formatted;
  } catch (error) {
    console.error(error);
    return `IDR ${amount}`;
  }
}

function formatDate(date, formatType = "dd MMMM yyyy") {
  return format(new Date(date), formatType, { locale: id });
}
</script>
<template>
  <div
    class="flex flex-col space-y-4"
    v-if="$page.props.auth.roles.filter((row) => ['admin'].includes(row.name)).length"
  >
    <div class="grid md:grid-cols-4 gap-3 mt-8 overflow-hidden">
      <Card label="Jumlah User" :value="user" />
      <Card label="Jumlah User Aktif" :value="user_active" />
      <Card label="Jumlah Produk" :value="product" />
      <Card label="Jumlah Produk Aktif" :value="product_active" />
    </div>
    <div class="w-full md:w-2/3">
      <div class="relative overflow-x-auto">
        <table class="w-full text-sm text-left text-gray-500">
          <thead class="text-xs text-white normal-case bg-primary rounded-md">
            <tr>
              <th scope="col" class="px-6 py-3 font-thin">Produk</th>
              <th scope="col" class="px-6 py-3 font-thin">Tanggal Dibuat</th>
              <th scope="col" class="px-6 py-3 font-thin">Harga (Rp)</th>
            </tr>
          </thead>
          <tbody>
            <tr
              class="bg-white border-b"
              v-for="(row, index) in latest_products"
              :key="index.toString()"
            >
              <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap">
                <div class="inline-flex space-x-2 items-center">
                  <img :src="row.picture.full_path" :alt="row.name" class="rounded-md w-10 h-10" />
                  <span>{{ row.name }}</span>
                </div>
              </th>
              <td class="px-6 py-4">{{ formatDate(row.created_at) }}</td>
              <td class="px-6 py-4">{{ formatIDRCurrency(row.price) }}</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>
<style scoped>
.c {
  position: absolute;
  width: 259.02px;
  height: 117px;
  left: 278px;
  top: 181px;
  background: linear-gradient(266.45deg, #c2d6ff 2.92%, #adc9ff 99.33%);
}
</style>

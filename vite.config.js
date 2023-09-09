import { defineConfig } from "vite";
import vue from "@vitejs/plugin-vue";
import laravel from "laravel-vite-plugin";
import viteExtend from "vite-plugin-vue-setup-extend";

export default defineConfig({
 plugins: [
  viteExtend(),
  laravel({
   input: "resources/js/app.ts",
  }),
  vue({
   template: {
    transformAssetUrls: {
     base: null,
     includeAbsolute: false,
    },
   },
  }),
 ],
 resolve: {
  alias: {
   "~": "/resources/js",
   "@": "/resources/assets",
  },
 },
});

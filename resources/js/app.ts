import "../css/app.css";
import "../css/fonts.css";

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { ZiggyVue } from "../../vendor/tightenco/ziggy/dist/vue.m";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";

// theme
import Theme from "./theme/index.js";
import AuthenticatedLayout from "./theme/layouts/authenticated.vue";

// common
import { createPinia } from "pinia";

// toast notification
import VueToast from "vue-toast-notification";
import "vue-toast-notification/dist/theme-sugar.css";

// package
import Modal from "~/packages/modal/index";
import VueTippy from "~/packages/tippy/index";
import Inertable from "./packages/datatable/index";

const appName = import.meta.env.VITE_APP_NAME;

createInertiaApp({
 title: (title) => `${title} - ${appName}`,
 resolve: async (name) => {
  const page = await resolvePageComponent(
   `./pages/${name}.vue`,
   import.meta.glob("./pages/**/*.vue"),
  );

  if (page.default.layout === undefined) {
   page.default.layout = AuthenticatedLayout;
  }

  return page;
 },
 setup({ el, App, props, plugin }) {
  return createApp({ render: () => h(App, props) })
   .use(plugin)
   .use(ZiggyVue, Ziggy)
   .use(Theme)
   .use(VueTippy)
   .use(Modal)
   .use(Inertable)
   .use(createPinia())
   .use(VueToast)
   .mount(el);
 },
});

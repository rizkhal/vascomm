// inertia
import { Link, Head } from "@inertiajs/vue3";

// packages
import Datepicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import Draggable from "zhyswan-vuedraggable";

import VueApexCharts from "vue3-apexcharts";

export default {
 install(app: any, config: any): void {
  app.component("v-app-link", Link);
  app.component("v-app-head", Head);
  app.component("v-date-picker", Datepicker);
  app.component("v-draggable", Draggable);
  app.component("v-apexchart", VueApexCharts);

  Object.entries(import.meta.globEager("./**/*.vue")).forEach(([path, m]) => {
   app.component(`${m.default.name}`, m.default);
  });
 },
};

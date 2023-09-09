import { reactive, markRaw } from "vue";
import ToastListItem from "./components/ToastListItem.vue";

export default reactive({
 items: [],
 add(toast, type = "default") {
  const newToast = {
   ...toast,
   type: type,
   component: toast.hasOwnProperty("component") ? markRaw(toast.component) : markRaw(ToastListItem),
  };

  this.items.unshift({
   key: Symbol(),
   ...newToast,
  });
 },
 success(toast) {
  this.add(toast, "success");
 },
 error(toast) {
  this.add(toast, "error");
 },
 remove(index) {
  this.items.splice(index, 1);
 },
});

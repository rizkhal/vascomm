// components
import ToastList from "./components/ToastList.vue";
import ToastListItem from "./components/ToastListItem.vue";

export default {
    install(app) {
        app.component("v-toast-list", ToastList);
        app.component("v-toast-list-item", ToastListItem);
    },
};

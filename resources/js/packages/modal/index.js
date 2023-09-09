import { h, render } from "vue";
import Dialog from "./components/dialog.vue";
import Default from "./components/default.vue";
import ModalContainer from "./components/modal-container.vue";

let currentModal = null;

export const useModal = (app, options) => {
 return {
  openDialog(props) {
   this.open({
    component: Dialog,
    ...props,
   });
  },
  open(props) {
   let filteredProps = Object.keys(props)
    .filter((key) => key !== "component")
    .reduce((obj, key) => {
     obj[key] = props[key];
     return obj;
    }, {});

   const child = () => h(props.component, filteredProps);

   const node = h(Default, filteredProps, () => [h(child)]);

   if (app?._context) {
    node.appContext = app._context;
   }

   render(node, document.body);

   node.component.exposed.openModal();

   currentModal = node.component;
  },
  close() {
   currentModal.exposed.closeModal();
  },
 };
};

export default {
 install: (app, options) => {
  const instance = useModal(app, options);

  app.component("v-modal-dialog", Dialog);
  app.component("v-modal-container", ModalContainer);

  app.config.globalProperties.$modal = instance;
  app.provide("$modal", instance);
 },
};

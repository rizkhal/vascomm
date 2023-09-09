<template>
 <TransitionRoot appear :show="isOpen" as="template">
  <Dialog as="div" :initialFocus="focusRef" @close="handleBackdropClose">
   <div
    ref="modalContainerRef"
    class="
     fixed
     z-50
     inset-0
     transition
     duration-100
     bg-white/30
     overflow-y-auto
     backdrop-blur-sm
    "
   >
    <div class="flex min-h-screen px-4" :class="[{ shake: animated }, positionClass]">
     <TransitionChild
      as="template"
      enter="duration-300 ease-out"
      enter-from="opacity-0"
      enter-to="opacity-100"
      leave="duration-200 ease-in"
      leave-from="opacity-100"
      leave-to="opacity-0"
     >
      <DialogOverlay class="fixed inset-0" />
     </TransitionChild>

     <!-- <span class="inline-block h-screen align-middle" aria-hidden="true"> &#8203; </span> -->

     <TransitionChild
      as="template"
      enter="duration-300 ease-out"
      enter-from="opacity-0 scale-95"
      enter-to="opacity-100 scale-100"
      leave="duration-200 ease-in"
      leave-from="opacity-100 scale-100"
      leave-to="opacity-0 scale-95"
     >
      <div class="fixed inline-block transform py-8 transition-all w-full" :class="maxWidthClass">
       <slot />
      </div>
     </TransitionChild>
    </div>
   </div>
  </Dialog>
 </TransitionRoot>
</template>

<script setup>
import { ref, computed, watch, onMounted, onUnmounted } from "vue";
import { router, usePage } from "@inertiajs/vue3";
import { TransitionRoot, TransitionChild, Dialog, DialogOverlay } from "@headlessui/vue";

const props = defineProps({
 title: String,
 position: {
  default: "top-center",
 },
 maxWidth: {
  default: "md",
 },
 backdropClose: {
  type: Boolean,
  default: true,
 },
});

const focusRef = ref(null);
const isOpen = ref(false);
const animated = ref(false);
const modalContainerRef = ref();

const positionClass = computed(() => {
 return {
  "top-center": "justify-center items-start",
  center: "justify-center items-center",
 }[props.position];
});

const maxWidthClass = computed(() => {
 return {
  sm: "sm:max-w-sm",
  md: "sm:max-w-md",
  lg: "sm:max-w-lg",
  xl: "sm:max-w-xl",
  "2xl": "sm:max-w-2xl",
  "4xl": "sm:max-w-4xl",
  "7xl": "sm:max-w-7xl",
 }[props.maxWidth];
});

const page = usePage();

const openModal = function (attr) {
 isOpen.value = true;
};

const closeModal = function () {
 isOpen.value = false;
};

const animate = (timeout = 1000) => {
 animated.value = true;
 modalContainerRef.value.classList.add("overflow-hidden");

 setTimeout(() => {
  animated.value = false;
  modalContainerRef.value.classList.remove("overflow-hidden");
 }, timeout);
};

const handleBackdropClose = () => {
 if (!props.backdropClose) {
  animate();
  return;
 }

 closeModal();
};

window.addEventListener("popstate", (event) => closeModal());

onUnmounted(() => window.removeEventListener("popstate", closeModal()));

defineExpose({
 openModal,
 closeModal,
});
</script>
<style lang="css">
.shake {
 animation: shake 0.82s cubic-bezier(0.36, 0.07, 0.19, 0.97) both;
 transform: translate3d(0, 0, 0);
}
@keyframes shake {
 10%,
 90% {
  transform: translate3d(-1px, 0, 0);
 }
 20%,
 80% {
  transform: translate3d(2px, 0, 0);
 }
 30%,
 50%,
 70% {
  transform: translate3d(-4px, 0, 0);
 }
 40%,
 60% {
  transform: translate3d(4px, 0, 0);
 }
}
</style>
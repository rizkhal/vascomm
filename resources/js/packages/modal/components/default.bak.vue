<template>
  <transition leave-active-class="duration-200">
    <div v-show="show" :class="positionClass" class="fixed overflow-y-auto px-4 py-6 sm:px-0 z-50">
      <transition
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0"
        enter-to-class="opacity-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100"
        leave-to-class="opacity-0"
      >
        <div v-show="show" class="fixed inset-0 transform transition-all" @click="closeModal">
          <div
            class="absolute inset-0 transition duration-100 bg-gray-300/50 backdrop-blur-sm"
          ></div>
        </div>
      </transition>

      <transition
        enter-active-class="ease-out duration-300"
        enter-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        enter-to-class="opacity-100 translate-y-0 sm:scale-100"
        leave-active-class="ease-in duration-200"
        leave-class="opacity-100 translate-y-0 sm:scale-100"
        leave-to-class="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
      >
        <div
          :dusk="dusk"
          v-show="show"
          class="
            mb-6
            bg-white
            rounded-md
            overflow-hidden
            shadow-xl
            transform
            transition-all
            sm:w-full sm:mx-auto
            max-w
          "
          :class="maxWidthClass"
        >
          <slot />
        </div>
      </transition>
    </div>
  </transition>
</template>

<script setup>
import { ref, computed } from "vue";

const props = defineProps({
  dusk: "",
  position: {
    default: "top",
  },
  maxWidth: {
    default: "md",
  },
});

const show = ref(false);

const positionClass = computed(() => {
  return {
    top: "inset-0",
    center: "inset-52",
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

const openModal = function () {
  show.value = true;
};

const closeModal = function () {
  show.value = false;
};

defineExpose({
  openModal,
  closeModal,
});
</script>
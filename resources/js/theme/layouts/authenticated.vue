<script setup name="VAuthenticated" lang="ts">
import { ref, PropType, onMounted, watch } from "vue";
import { AuthUserType } from "~/types/inertia";
import { router } from "@inertiajs/vue3";
import { useToast } from "vue-toast-notification";

const toast = useToast();

const sidebarState = ref(false);

const props = defineProps({
  auth: {
    required: true,
    type: Object as PropType<AuthUserType>,
  },
  title: String as PropType<String>,
  flash: Object as PropType<Object>,
  navigators: String as PropType<String>,
  breadcrumbs: Object as PropType<Object>,
});

router.on("success", (event) => {
  sidebarState.value = false;
});

watch(
  () => props.flash,
  (payload: { success: string; error: string; info: string; warning: string }) => {
    if (payload) {
      if (payload.success) {
        toast.success(payload.success, {
          position: "top-right",
        });
      }

      if (payload.error) {
        toast.error(payload.error, {
          position: "top-right",
        });
      }

      if (payload.info) {
        toast.info(payload.info, {
          position: "top-right",
        });
      }

      if (payload.warning) {
        toast.warning(payload.warning, {
          position: "top-right",
        });
      }
    }
  },
  { deep: true },
);
</script>
<template>
  <v-app-head :title="title" />

  <div>
    <v-header
      :user="auth.user"
      :state="sidebarState"
      @toggleSidebar="sidebarState = !sidebarState"
    />

    <div class="flex overflow-hidden bg-white pt-16">
      <v-sidebar :state="sidebarState" :user="auth.user" :navigators="navigators" />

      <div id="main-content" class="h-full w-full bg-gray-50 relative overflow-y-auto lg:ml-[15em]">
        <main>
          <div
            class="p-2 bg-white block sm:flex items-center justify-between border-b border-gray-200 lg:mt-1.5"
          >
            <div class="mb-1 w-full px-2">
              <div class="mb-4">
                <v-breadcrumbs :lists="breadcrumbs" />
                <slot />
              </div>
            </div>
          </div>
        </main>

        <!-- <Footer /> -->
      </div>
    </div>
  </div>
</template>

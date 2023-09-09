<script setup name="VHeader">
import { ref } from "vue";
import { usePage } from "@inertiajs/vue3";

const appName = import.meta.env.VITE_APP_NAME;

const props = defineProps({
  user: Object,
  state: Boolean,
});

const page = usePage();

const form = ref(null);
const token = ref(page.props.auth._token);

const logout = () => {
  form.value.submit();
};
</script>
<template>
  <nav class="bg-white border-b border-gray-200 fixed z-30 w-full">
    <div class="px-3 py-3 lg:px-5 lg:pl-3">
      <div class="flex items-center justify-between">
        <div class="flex items-center justify-start">
          <button
            @click.prevent="$emit('toggleSidebar')"
            aria-expanded="true"
            aria-controls="sidebar"
            class="lg:hidden mr-2 text-gray-600 hover:text-gray-900 cursor-pointer p-2 hover:bg-gray-100 focus:bg-gray-100 focus:ring-2 focus:ring-gray-100 rounded"
          >
            <!-- open -->
            <svg
              v-if="!state"
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h6a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"
              ></path>
            </svg>

            <!-- close -->
            <svg
              v-else
              class="w-6 h-6"
              fill="currentColor"
              viewBox="0 0 20 20"
              xmlns="http://www.w3.org/2000/svg"
            >
              <path
                fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>

          <a href="#" class="text-xl font-bold flex items-center ml-2">
            <span class="font-extrabold text-gray-900">{{ appName }}</span>
          </a>
        </div>

        <div class="flex items-center space-x-3">
          <v-dropdown
            width="48"
            align="right"
            contentClasses="bg-white p-2 rounded-md ring-1 ring-black ring-opacity-5"
          >
            <template #trigger>
              <div class="inline-flex space-x-3 cursor-pointer">
                <div class="flex flex-col">
                  <span class="text-primary text-xs">Halo, {{ user.username }}</span>
                  <span class="text-slate-800 text-sm">{{ user.name }}</span>
                </div>
                <img
                  v-if="user && 'profile_picture' in user"
                  class="rounded-full w-10 h-10"
                  :src="user.profile_picture"
                  :alt="user.name"
                />
              </div>
            </template>
            <template #content>
              <div
                class="flex flex-col p-4 w-full items-center justify-center"
                v-if="user && 'profile_picture' in user"
              >
                <img
                  class="rounded-full w-14 h-14 mb-2"
                  :src="user.profile_picture"
                  :alt="user.name"
                />
                <span class="text-sm">{{ user.name }}</span>
                <span class="text-xs">{{ user.email }}</span>
              </div>
              <div class="p-4 border-t">
                <button
                  @click.prevent="logout"
                  class="inline-flex w-full items-center justify-center space-x-2 text-red-600"
                >
                  <v-icon name="PowerIcon" type="outline" class="w-5 h-5" />
                  <span class="uppercase">Keluar</span>
                  <form ref="form" :action="route('logout')" method="post" class="hidden">
                    <input type="text" name="_token" :value="token" />
                  </form>
                </button>
              </div>
            </template>
          </v-dropdown>
        </div>
      </div>
    </div>
  </nav>
</template>

<template>
  <div
    class="
      bg-white
      sticky
      sm:flex
      items-center
      w-full
      sm:justify-between
      bottom-0
      right-0
      border-t border-gray-200
      p-4
    "
  >
    <div class="flex items-center mb-4 sm:mb-0">
      <span class="text-sm font-normal text-gray-500">
        Menampilkan
        <span class="text-gray-900 font-semibold">{{ from ?? 0 }}</span>
        ke <span class="text-gray-900 font-semibold">{{ to ?? 0 }}</span> dari
        <span class="text-gray-900 font-semibold">{{ total }}</span>
      </span>
    </div>
    <div class="flex items-center space-x-3">
      <button
        :disabled="noPreviousPage"
        :class="{ 'opacity-50 cursor-not-allowed': noPreviousPage }"
        @click="$emit('loadPage', 1)"
        class="
          inline-flex
          justify-center
          items-center
          p-2.5
          text-gray-700
          bg-white
          rounded
          border border-gray-200
          shadow-sm
          outline-none
          hover:bg-gray-50
          lg:text-sm
          focus:ring-1 focus:ring-purple-600 focus:border-purple-600
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-4 h-4 lg:h-5 lg:w-5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M18.75 19.5l-7.5-7.5 7.5-7.5m-6 15L5.25 12l7.5-7.5"
          />
        </svg>
      </button>
      <button
        :disabled="noPreviousPage"
        :class="{ 'opacity-50 cursor-not-allowed': noPreviousPage }"
        @click="$emit('loadPage', current - 1)"
        class="
          inline-flex
          justify-center
          items-center
          p-2.5
          text-gray-700
          bg-white
          rounded
          border border-gray-200
          shadow-sm
          outline-none
          hover:bg-gray-50
          focus:ring-1 focus:ring-purple-600 focus:border-purple-600
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-4 h-4 lg:h-5 lg:w-5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M15.75 19.5L8.25 12l7.5-7.5"
          />
        </svg>
      </button>

      <div class="flex flex-row items-center">
        <input
          min="1"
          type="number"
          v-model="page"
          :max="last"
          @keydown.enter="$emit('loadPage', page)"
          class="
            bg-gray-50
            mr-2
            border border-gray-300
            text-gray-900
            sm:text-sm
            rounded-lg
            focus:ring-purple-600 focus:border-purple-600
            block
            w-[4rem]
            p-2.5
          "
        />
        <div class="text-sm font-normal text-gray-500 mx-1">
          dari <span class="text-gray-900 font-semibold">{{ last }}</span>
        </div>
      </div>

      <button
        :disabled="noNextPage"
        :class="{ 'opacity-50 cursor-not-allowed': noNextPage }"
        @click="$emit('loadPage', current + 1)"
        class="
          inline-flex
          justify-center
          items-center
          text-gray-700
          bg-white
          rounded
          border border-gray-200
          shadow-sm
          outline-none
          hover:bg-gray-50
          p-2.5
          focus:ring-1 focus:ring-purple-600 focus:border-purple-600
        "
      >
        <svg
          class="w-4 h-4 lg:h-5 lg:w-5"
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M8.25 4.5l7.5 7.5-7.5 7.5"
          />
        </svg>
      </button>
      <button
        :disabled="noNextPage"
        :class="{ 'opacity-50 cursor-not-allowed': noNextPage }"
        @click="$emit('loadPage', last)"
        class="
          inline-flex
          justify-center
          items-center
          text-gray-700
          bg-white
          rounded
          border border-gray-200
          shadow-sm
          outline-none
          hover:bg-gray-50
          p-2.5
          focus:ring-1 focus:ring-purple-600 focus:border-purple-600
        "
      >
        <svg
          xmlns="http://www.w3.org/2000/svg"
          fill="none"
          viewBox="0 0 24 24"
          stroke-width="1.5"
          stroke="currentColor"
          class="w-4 h-4 lg:h-5 lg:w-5"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            d="M11.25 4.5l7.5 7.5-7.5 7.5m-6-15l7.5 7.5-7.5 7.5"
          />
        </svg>
      </button>
    </div>
  </div>
</template>
<script>
export default {
  emits: ["loadPage"],
  props: {
    total: Number,
    last: Number,
    current: Number,
    from: Number,
    to: Number,
  },
  data() {
    return {
      page: this.current,
    };
  },
  watch: {
    current: {
      handler(page) {
        this.page = page;
      },
    },
  },
  computed: {
    noPreviousPage() {
      return this.current - 1 <= 0;
    },
    noNextPage() {
      return this.current + 1 > this.last;
    },
  },
};
</script>

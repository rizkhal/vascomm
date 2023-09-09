<script setup name="VSidebar">
defineProps({
 user: Object,
 state: Boolean,
 navigators: String,
});
</script>
<template>
 <div>
  <aside
   id="sidebar"
   class="
    w-60
    z-20
    fixed
    top-0
    pt-16
    left-0
    h-full
    lg:flex
    duration-75
    transition-width
    flex-shrink-0 flex-col
   "
   :class="{ flex: state, hidden: !state }"
  >
   <div class="pt-0 min-h-0 relative bg-white flex-1 flex flex-col border-r border-gray-200">
    <div class="flex-1 flex flex-col pt-5 pb-4 overflow-y-auto scrollbar">
     <div class="flex-1 px-3 bg-white divide-y space-y-1">
      <div class="flex flex-col md:relative h-full overflow-auto mb-20">
       <v-navigator :user="user" :navigators="navigators" />
      </div>
     </div>
    </div>
   </div>
  </aside>

  <v-backdrop :state="state" />
 </div>
</template>
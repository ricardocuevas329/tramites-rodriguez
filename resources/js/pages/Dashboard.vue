<template>
  <Nav />
  <!--<div class="flex overflow-hidden ">
    <Aside />
    <div class="h-full w-full relative overflow-y-auto lg:ml-64">
      <main>-->
  <div class="pt-17 px-2">
    <section v-if="$route.name == 'Dashboard'" class="p-4 my-6 md:p-8">
    </section>
    <RouterView v-slot="{ Component }">
      <component :is="Component" />
    </RouterView>
  </div><!--
      </main>
    </div>
  </div>-->
</template>

<script setup lang="ts">
import Nav from "@/layouts/Nav.vue";
import Aside from "@/layouts/Aside.vue";

</script>

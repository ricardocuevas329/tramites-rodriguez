<template>
    <div class="pb-2 py-2 px-4  flex justify-center">
       <slot></slot>
   </div>
   </template>
   <script lang="ts">
   import { defineComponent } from "vue";
   
   export default defineComponent({
       name: "Center",
   });
   </script>
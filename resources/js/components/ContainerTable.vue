<template>
    <div  class="bg-base-100 shadow-sm sm:rounded-lg   ">
       <slot></slot>
   </div>
   </template>
   <script lang="ts">
   import { defineComponent } from "vue";

   export default defineComponent({
       name: "ContainerTable",
       props:{
           distance:
          {
           type: Number,
           default: 0
          }
       }
   });
   </script>



<template>
  <thead  class="text-xs uppercase bg-base-300 ">
    <slot></slot>
 </thead>
</template>
<script lang="ts">
import { defineComponent } from 'vue';
   export default defineComponent({
       name: "THead",
   });
</script>
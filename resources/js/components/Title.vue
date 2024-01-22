<template>
    <h5 class="mb-4  font-bold whitespace-nowrap truncate  leading-none" :class="size">
     <slot/>
    </h5>
   </template>
<script lang="ts">
import { defineComponent } from 'vue';
export default defineComponent({
   name: "Title",
    props:{
       size:{
           type: String,
           default: 'text-md',
           required: false
       }
    }
});
</script>

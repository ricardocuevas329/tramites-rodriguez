<template>
      <AddPermisoViaje/>
</template>
<script setup lang="ts">
import AddPermisoViaje from "@/pages/External/PermisoViaje/Add-PermisoViaje.vue";
const props = defineProps({
    type:{
        type:Boolean,
        required: true
    }
})
</script>


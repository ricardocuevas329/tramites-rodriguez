<template>
     <PermisoViaje :type="type"/>
</template>
<script lang="ts" setup>
import PermisoViaje from './RegisterPermissionTravel.vue';
import {ref} from "vue";
const type = ref<boolean>(true)
</script>


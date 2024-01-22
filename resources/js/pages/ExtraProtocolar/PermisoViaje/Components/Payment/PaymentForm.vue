<template>
  <Center>
    <button class="btn btn-primary" v-if="formValues.i_tipo">
      PAGAR
      <div class="badge badge-info">{{ formValues.i_tipo == 1 ? '80 SOLES' : '100 SOLES' }}</div>
    </button>
  </Center>
</template>
<script setup lang="ts">
import type {PropType} from "vue";
import type {PermisoViaje} from "@/models/types";
import {Center} from "@/components";
const props = defineProps({
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<PermisoViaje>,
  },
});
const { formValues  } = props


</script>

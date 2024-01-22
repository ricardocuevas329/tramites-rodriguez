<template>

  <Center>
    <p class="badge badge-ghost font-light text-center text-lg">PERMISO DE VIAJE</p>
  </Center>

  <div class="my-1 md:my-4 mx-4 ">
    <Row>
      <ClockIcon class="w-4 text-success "/>
      <progress class="progress progress-success h-1.5 w-72" :value="progressComplete" max="100"></progress>
      <span class="text-xs text-success ">{{ progressComplete }} %</span>
    </Row>
  </div>

  <FormFields
      :disabled="isSubmit"
      @onSubmit="onSubmit"
      @onCompleteProgress="onCompleteProgress"
  />

</template>
<script setup lang="ts">
import {ref, toRefs} from "vue";
import {FormFields,} from "./Index";
import {Center, Row} from "@/components";
import {ClockIcon} from "@heroicons/vue/20/solid";
import {usePermisoViajeStore} from "@/store/permiso-viaje";
import type {IPermisoViajeExternalFormModel} from "@/pages/External/PermisoViaje/Interfaces/typevieaje.interface";

const {isSubmit} = toRefs(usePermisoViajeStore());


const emit = defineEmits(["onSubmit"]);
const progressComplete = ref<number>(0)


const onSubmit = (form: IPermisoViajeExternalFormModel) => {
  emit("onSubmit", form)
}


const onCompleteProgress = (progress: number) => {
  if (progress) {
    return progressComplete.value = progress
  }

}
</script>

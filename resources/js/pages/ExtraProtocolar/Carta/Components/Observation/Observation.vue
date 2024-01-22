<template>
  <div class="w-full p-4 bg-base-100 rounded-lg shadow">
      <TextArea
          label="Observación"
          id="carta.s_observacion"
          v-model="formValues.s_observacion"
      />
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1  pb-2 px-2">
      <ul
          class="items-center w-full text-sm font-medium bg-base md:border py-2  md:border-success rounded-lg sm:flex"
      >
        <li class="w-full my-1  border-success sm:border-b-0 sm:border-r bg-base">
          <div class="flex items-center pl-3">
            <CheckBox
                id="checkbox-delivery"
                type="checkbox"
                v-model="formValues.i_delivery"
            >Delivery
            </CheckBox>
          </div>
        </li>
        <li class="w-full my-1 border-success sm:border-b-0 sm:border-r bg-base">
          <div class="flex items-center pl-3">
            <CheckBox
                id="checkbox-bajo-puerta"
                type="checkbox"
                v-model="formValues.i_bajopuerta"
            >Bajo puerta
            </CheckBox>
          </div>
        </li>
        <li class="w-full my-1 border-success sm:border-b-0 sm:border-r bg-base">
          <div class="flex items-center pl-3">
            <CheckBox id="checkbox-urgente" type="checkbox" v-model="formValues.i_urgente"
            >Urgente
            </CheckBox
            >
          </div>
        </li>
        <li class="w-full my-1 bg-base">
          <div class="flex items-center pl-3">
            <CheckBox
                id="checkbox-al-contado"
                type="checkbox"
                v-model="formValues.i_tipopago"
            >¿Al contado?
            </CheckBox>
          </div>
        </li>
      </ul>
    </div>

    <Center>
      <div class="badge badge-primary badge-lg">Total: {{ calculateTotal }}</div>
    </Center>
    <div class="flex justify-center pt-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
        <button
            class="btn btn-outline.btn-secondary"
            @click="tabCartasRef.selectedTab = 3"
        >
          <ArrowLeftBold/>
          Anterior
        </button>
        <button class="btn btn-success text-white" @click="tabCartasRef.selectedTab = 5">
          Siguiente
          <ArrowRightBold/>
        </button>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import {computed, type PropType} from 'vue';
import {Center, CheckBox, TextArea, TextInput} from "../../../../../components";
import ArrowRightBold from "vue-material-design-icons/ArrowRightBold.vue";
import ArrowLeftBold from "vue-material-design-icons/ArrowLeftBold.vue";
import {useArrayReduce} from '@vueuse/core'
import type {ICartaFormStore} from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";


const props = defineProps({
  formValues: {
    default: {},
    require: true,
    type: Object as PropType<ICartaFormStore>,
  },
  tabCartasRef: {
    require: false,
    type: Object as PropType<any>,
  }
});

const {formValues} = props


const calculateTotal = computed(() => {

  if (formValues.destinatarios?.length) {
    const sum = useArrayReduce(formValues.destinatarios, (sum, val) => sum + Number.parseFloat(val.precio.toString()), 0)
    return sum.value.toFixed(2)
  }

  return '0'

})
</script>

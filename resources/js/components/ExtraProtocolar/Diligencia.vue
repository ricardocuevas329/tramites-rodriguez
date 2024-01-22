<template>
  <ScrollForm>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 font-serif">
      <ul class="text-sm">
        <li class="mb-2 ">
          <span class="badge badge-neutral">Numero de carta:</span> {{ formValues.s_num_carta }}
        </li>
        <li class="mb-2">
          <span class="badge badge-neutral">Recibido por:</span> {{ formValues.s_recibido_por }}
        </li>
        <li class="mb-2">
          <span class="badge badge-neutral">Nº Documento:</span> {{ formValues.s_recibido_dni }}
        </li>
        <li class="mb-2">
          <span class="badge badge-neutral">Relacion:</span> {{ formValues.s_relacion_destinatario }}
        </li>
        <li class="mb-2">
          <span class="badge badge-neutral">Bajo puerta:</span> {{ formValues.i_bajo_puerta ? "SI" : "NO" }}
        </li>
        <li class="mb-2">
          <span class="badge badge-neutral">Buzón:</span> {{ formValues.i_buzon ? "SI" : "NO" }}
        </li>
        <li class="mb-2">
          <span class="badge badge-neutral">Motorizado:</span> {{ formValues.personal?.nombre_compuesto }}
        </li>
      </ul>
      <ul class="text-sm">
        <li class="mb-2"><span class="badge badge-neutral">Fecha:</span> {{ formValues.d_fecha_entrega }}</li>
        <li class="mb-2">
          <span class="badge badge-neutral">Inmueble:</span> {{ formValues.i_edificio ? "EDIFICIO" : "CASA" }}
        </li>
        <li class="mb-2"><span class="badge badge-neutral">Pisos:</span> {{ formValues.s_pisos }}</li>
        <li class="mb-2"><span class="badge badge-neutral">Color:</span> {{ formValues.s_color }}</li>
        <li class="mb-2"><span class="badge badge-neutral">Puertas:</span> {{ formValues.s_puertas }}</li>
        <li class="mb-2"><span class="badge badge-neutral">Ventanas:</span> {{ formValues.s_ventanas }}</li>
        <li class="mb-2">
          <span class="badge badge-neutral">Proyeccion:</span> {{ formValues.s_proyeccion }}
        </li>
      </ul>
    </div>
    <div class="badge badge-neutral">Observación:</div>
    <div class="text-sm mx-4">
      {{ formValues.s_observacion }}
    </div>
    <div class="text-sm"><span class="badge badge-neutral mt-2 mb-2">Fotos:</span></div>
    <Center>
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
      <div v-for="(item, index) in formValues.fotos" :key="index">
        <img :src="item.s_foto" width="300" height="341"/>
      </div>
    </div>
    </Center>
  </ScrollForm>
</template>
<script setup lang="ts">
import {ScrollForm, Center} from "@/components";
import {type PropType, toRefs} from 'vue';
import type {DiligenciaCarta} from '@/models/types';

const props = defineProps({
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<DiligenciaCarta>,
  },
});

const {formValues} = toRefs(props);
</script>

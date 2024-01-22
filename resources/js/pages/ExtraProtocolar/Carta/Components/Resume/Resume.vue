<template>
  <div class="w-full p-4 bg-base-100 rounded-lg shadow">
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-1  ">
      <div tabindex="0" class="collapse bg-base-200">
        <div class="collapse-title text-xl font-medium flex text-success">
          <CheckBadgeIcon class="mx-2 w-6 h-6"/>
          <h3 class="text-lg font-semibold">
            Remitente
          </h3>
        </div>
        <div class="collapse-content text-sm font-normal">
          <p class="mb-1 ">
            <span class="font-semibold">Nº documento:</span>
            {{ formValues.remitente?.s_num_doc }}
          </p>
          <p class="mb-1 ">
            <span class="font-semibold">Nombres y apellidos:</span>
            {{ formValues.remitente?.nombre_compuesto }}
          </p>
          <p class="mb-1 ">
            <span class="font-semibold">Nº documento (Referente):</span>
            {{ formValues.referente?.s_num_doc }}
          </p>
          <p class="mb-1 ">
            <span class="font-semibold">Nombres y apellidos (Referente):</span>
            {{ formValues.referente?.nombre_compuesto }}
          </p>
        </div>
      </div>

      <div tabindex="0" class="collapse bg-base-200">
        <div class="collapse-title text-xl font-medium flex text-success">
          <CheckBadgeIcon class="mx-2 w-6 h-6"/>
          <h3 class="text-lg font-semibold">
            Facturado a
          </h3>
        </div>
        <div class="collapse-content text-sm font-normal">
          <p class="mb-1">
            <span class="font-semibold">Comprobante:</span>
            {{ formValues.facturado_empresa ? "FACTURA" : "BOLETA" }}
          </p>

          <p v-if="formValues.facturado_empresa">
            <span class="font-semibold">RUC:</span>
            {{ formValues.facturado_empresa?.s_num_doc }}
          </p>
          <p v-else>
            <span class="font-semibold">Nº Documento:</span>
            {{ formValues.facturado_cliente?.s_num_doc }}
          </p>
          <p v-if="formValues.facturado_empresa">
            <span class="font-semibold">Razon social:</span>
            {{ formValues.facturado_empresa?.s_nombre }}
          </p>
          <p v-else class="mb-1 text-sm font-normal">
            <span class="font-semibold">Nombre y apellidos:</span>
            {{ formValues.facturado_cliente?.nombre_compuesto }}
          </p>
          <p v-if="formValues.facturado_empresa">
            <span class="font-semibold">Dirección fiscal:</span>
            {{
              formValues.facturado_empresa?.s_direccion +
              " " +
              formValues.facturado_empresa?.s_localidad
            }}
          </p>
        </div>
      </div>

      <div tabindex="0" class="collapse bg-base-200">
        <div class="collapse-title text-xl font-medium flex text-success">
          <CheckBadgeIcon class="mx-2 w-6 h-6"/>
          <h3 class="text-lg font-semibold">
            Destinatario
          </h3>
        </div>
        <div class="collapse-content text-sm font-normal">
          <p class="mb-1 text-sm font-normal">
            <span class="font-semibold">Cantidad:</span>
            {{ formValues.destinatarios?.length }}
          </p>
          <p
              v-for="(destinatario, index) in formValues.destinatarios"
              :key="index"
              class="mb-1"
          >
            <span class="font-semibold">Destinatario {{ index + 1 }}:</span>
            {{ destinatario.nombre }} - {{ destinatario.ubicacion }}-
            {{ destinatario.direccion }} -
            {{ destinatario.precio }}
          </p>
        </div>
      </div>

      <div tabindex="0" class="collapse bg-base-200">
        <div class="collapse-title text-xl font-medium flex text-success">
          <CheckBadgeIcon class="mx-2 w-6 h-6"/>
          <h3 class="text-lg font-semibold">
            Observaciones
          </h3>
        </div>
        <div class="collapse-content text-sm font-normal">
          <p class="mb-1">
            <span class="font-semibold">Observación:</span>
            {{ formValues.s_observacion }}
          </p>
          <p class="mb-1">
            <span class="font-semibold">Tipo de entrega:</span>
            {{ formValues.i_delivery ? "DELIVERY" : "" }}
            /
            {{ formValues.i_bajopuerta ? "BAJO PUERTA" : "" }}
            /
            {{ formValues.i_urgente ? "URGENTE" : "" }}
          </p>
          <p class="mb-1">
            <span class="font-semibold">Pago al contado:</span>
            {{ formValues.i_tipopago ? "SI" : "NO" }}
          </p>
          <p class="mb-1">
            <span class="font-semibold">Fecha de termino:</span>
            {{ formValues.d_fecha_cierre }}
          </p>
        </div>
      </div>

      <div tabindex="0" class="collapse bg-base-200">
        <div class="collapse-title text-xl font-medium flex text-success">
          <CheckBadgeIcon class="mx-2 w-6 h-6"/>
          <h3 class="text-lg font-semibold">
            Total
          </h3>
        </div>
        <div class="collapse-content text-sm font-normal">
          <p class="mb-1">
            <span class="font-semibold">Total a pagar: </span>
            <strong>S/. {{ calculateTotal }}</strong>
          </p>
        </div>
      </div>

      <div class="flex justify-center pt-4">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
          <button
              class="btn btn-outline.btn-secondary"
              @click="tabCartasRef.selectedTab = 4"
          >
            <ArrowLeftBold/>
            Anterior
          </button>
          <button :disabled="disabled" class="btn btn-success text-white" @click="onSubmit">
            Guardar
            <ContentSave/>
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup lang="ts">
import {computed, type PropType} from "vue";
import {CheckBadgeIcon} from "@heroicons/vue/20/solid";
import ArrowLeftBold from "vue-material-design-icons/ArrowLeftBold.vue";
import ContentSave from "vue-material-design-icons/ContentSave.vue";
import type {ICartaFormStore} from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";
import {useArrayReduce} from "@vueuse/core";


const props = defineProps({
  formValues: {
    default: {},
    require: true,
    type: Object as PropType<ICartaFormStore>,
  },
  tabCartasRef: {
    require: false,
    type: Object as PropType<any>,
  },
  disabled: {
    default: false,
    require: false,
    type: Boolean,
  }
});

const {formValues} = props;
const emit = defineEmits(["onSubmit"]);
const calculateTotal = computed(() => {
  if (formValues.destinatarios?.length) {
    const sum = useArrayReduce(
        formValues.destinatarios,
        (sum, val) => sum + Number.parseFloat(val.precio.toString()),
        0
    );
    return sum.value.toFixed(2);
  }
  return "0";
});
const onSubmit = () => {
  emit("onSubmit", formValues);
};

</script>

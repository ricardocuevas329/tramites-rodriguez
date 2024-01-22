<template>
  <div class="w-full p-4 bg-base-100 rounded-lg shadow">
    <div class="pb-2">
      <h3><strong>Datos del remitente</strong></h3>
    </div>

    <Row>
      <DropwdownSelect
          placeholder="Buscar Remitente"
          label="nombre_compuesto"
          label2="s_num_doc"
          @keyup="filterRemitente"
          @onSelecteValue="onSelecteRemitente"
          v-model="searchRemitente"
          :showValue="true"
          :data="Clientes"
          @keyup.enter="filterRemitente"
          class="w-full"
          @onClear="onClearRemitente"
      />
      <div class="flex items-center">
        <BtnAdd
            @click="useOpenModal('cartas.registro_cliente')"
            icon
        />
      </div>
    </Row>
    <template v-if="showRemitente">
      <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2">
        <TextInput
            label="Número documento"
            :modelValue="formValues.remitente?.s_num_doc"
            readonly
        />
        <TextInput
            label="Nombres y Apellidos"
            :modelValue="formValues.remitente?.nombre_compuesto"
            readonly
        />
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
        <TextInput label="Correo" id="remitter.remitenteCorreo"
                   :error-message="form.remitenteCorreo.$error?.message"
                   v-model="form.remitenteCorreo.$value"/>
        <TextInputNumber label="Telefono" id="remitter.remitenteTelefono" v-model="form.remitenteTelefono.$value"
                         :error-message="form.remitenteTelefono.$error?.message"/>
      </div>
    </template>

    <Row>
      <DropwdownSelect
          id="filterReferente"
          placeholder="Buscar Referente"
          label="nombre_compuesto"
          label2="s_num_doc"
          @keyup="filterReferente"
          @onSelecteValue="onSelecteReferente"
          v-model="searchReferente"
          @onClear="onClearReferente"
          :data="ClientsCompanies"
          @keyup.enter="filterReferente"
          class="w-full"

      />
      <div class="flex items-center">
        <BtnAdd
            @click="useOpenModal('cartas.registro_cliente')"
            type="button"
            icon

        />

      </div>
    </Row>

    <div
        v-if="showReferente"
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2"
    >
      <TextInput label="Usuario" :modelValue="formValues.referente?.s_num_doc" readonly/>
      <TextInput
          label="Referencia"
          :modelValue="formValues.referente?.nombre_compuesto"
          readonly
      />
    </div>

    <div class="flex justify-center">
      <button class="btn btn-success text-white" @click="tabCartasRef.selectedTab = 2">
        Siguiente
        <ArrowRightBold/>
      </button>
    </div>
  </div>
</template>

<script setup lang="ts">
import * as Yup from "yup";
import {defineForm, field} from "vue-yup-form";
import {type PropType, ref, toRefs} from 'vue';
import {BtnAdd, BtnClean, DropwdownSelect, Row, TextInput, TextInputNumber} from "../../../../../components";

import {debounce} from "../../../../../utils/debounce.js";
import ArrowRightBold from "vue-material-design-icons/ArrowRightBold.vue";

import type {Cliente} from "@/models/types";
import {useClienteStore} from "../../../../../store/cliente";
import {useOpenModal} from "../../../../../hooks/useUtils";
import type {ICartaFormStore} from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";
import {useClientCompanyStore} from "@/store/client-company";
import {validateMaxDigits} from "@/utils/Regexs";
import {useInputsEvents} from "@/hooks/useInputsEvents";

const {searchCliente} = useClienteStore();

const {Clientes} = toRefs(useClienteStore());

const {searchClientCompany} = useClientCompanyStore()
const {ClientsCompanies} = toRefs(useClientCompanyStore())


const searchRemitente = ref<string>("");
const searchReferente = ref<string>("");
const showReferente = ref<boolean>(false);
const showRemitente = ref<boolean>(false);
const {onFocusInput} = useInputsEvents();

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

const form = defineForm({
  remitenteCorreo: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .email("correo no válido")
          .min(5, "Minimo 5 caracteres")
          .max(100, "Máximo 100 caracteres")
          .nullable()
  ),
  remitenteTelefono: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => Number.isNaN(value) ? null : value)
          .test("maxDigits", "Máximo de 12 dígitos permitidos.", value => {
            return validateMaxDigits(value, 12)
          })
          .positive("Numero no Válido")
          .nullable()
  ),
  s_referente: field<string>('', Yup.string().required()),
  s_remitente: field<string>('', Yup.string().required()),
});

const filterRemitente = debounce(() => {
  return searchCliente(searchRemitente.value);
}, 500);

const filterReferente = debounce(() => {
  return searchClientCompany(searchReferente.value);
}, 500);

const onSelecteRemitente = (payload: Cliente) => {
  showRemitente.value = true
  searchRemitente.value = payload.nombre_compuesto;
  formValues.s_remitente = payload.s_codigo;
  formValues.remitente = payload;
  form.remitenteCorreo.$value = formValues?.remitente?.s_correo
  form.remitenteTelefono.$value = formValues?.remitente?.s_celular ? parseInt(formValues?.remitente?.s_celular) : null
  form.s_remitente.$value = payload.s_codigo;

};
const onSelecteReferente = (payload: Cliente) => {
  searchReferente.value = 'payload.nombre_compuesto'
  showReferente.value = true
  formValues.s_referente = payload.s_codigo;
  formValues.referente = payload;
  form.s_referente.$value = payload.s_codigo;
};

const onClearRemitente = (success: boolean) => {
  if (success) {
    showRemitente.value = false
    searchRemitente.value = "";
    formValues.s_remitente = ""
    form.s_remitente.$value = ""
    form.remitenteCorreo.$value = "";
    form.remitenteTelefono.$value = null;
  }

};

const onClearReferente = (success: boolean) => {
  if (success) {
    showReferente.value = false
    searchReferente.value = "";
    formValues.s_referente = "";
    form.s_referente.$value = "";
  }
};

const onValidateFocus = () => {
  if (form.remitenteCorreo.$error) {
    return onFocusInput("remitter.remitenteCorreo");
  }
  if (form.remitenteTelefono.$error) {
    return onFocusInput("remitter.remitenteTelefono");
  }
}

defineExpose({form, onValidateFocus});
</script>

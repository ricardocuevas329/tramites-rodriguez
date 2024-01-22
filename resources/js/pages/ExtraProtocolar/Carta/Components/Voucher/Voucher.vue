<template>
  <div class="w-full p-4 bg-base-100 rounded-lg shadow">
    <div class="pb-2">
      <h3><strong>Datos para comprobante de pago</strong></h3>
    </div>
    <ul class="grid w-full gap-6 md:grid-cols-2 pb-2">
      <li>
        <input
            type="radio"
            id="hosting-small"
            name="hosting"
            value="persona_juridica"
            v-model="selectedOption"
            class="hidden peer"
            required
        />

        <label
            for="hosting-small"
            class="inline-flex items-center justify-between w-full p-5 text-base-400 bg-base border border-base-400 rounded-lg cursor-pointer dark:hover:text-white dark:border-base-300 dark:peer-checked:text-success peer-checked:border-success peer-checked:text-success hover:text-base hover:bg-base-300 dark:text-base-400 dark:bg-base-400 dark:hover:bg-base-300"
        >
          <div class="block">
            <div class="w-full text-lg font-semibold">Persona juridica</div>
            <div class="w-full">Empresa</div>
          </div>
          <BuildingOfficeIcon class="w-10 h-10 ml-3"/>
        </label>
      </li>
      <li>
        <input
            type="radio"
            id="hosting-big"
            name="hosting"
            value="persona_natural"
            v-model="selectedOption"
            class="hidden peer"
        />
        <label
            for="hosting-big"
            class="inline-flex items-center justify-between w-full p-5 text-base-400 bg-base border border-base-400 rounded-lg cursor-pointer dark:hover:text-white dark:border-base-300 dark:peer-checked:text-success peer-checked:border-success peer-checked:text-success hover:text-base hover:bg-base-300 dark:text-base-400 dark:bg-base-400 dark:hover:bg-base-300"
        >
          <div class="block">
            <div class="w-full text-lg font-semibold">Persona Natural</div>
            <div class="w-full">Personal</div>
          </div>
          <UserIcon class="w-10 h-10 ml-3"/>
        </label>
      </li>
    </ul>
    <div v-show="selectedOption === 'persona_juridica'">
      <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2">
        <DropwdownSelect
            placeholder="Buscar Empresa"
            label="s_nombre"
            label2="s_num_doc"
            @keyup="filterPerJuridica"
            @onSelecteValue="onSelectePerJuridica"
            v-model="searchPerJuridica"
            :showValue="false"
            :data="Empresas"
            @keyup.enter="filterPerJuridica"
            class="w-full"
            id="voucher.s_facturado"
        />
        <div class="flex items-center">
          <BtnAdd
              @click="useOpenModal('cartas.registro_empresa')"
              type="button"
              icon
              class="mx-2"
          />
          <BtnClean @click="clearEmpresa" icon/>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
        <TextInput
            label="RUC"
            readonly
            :modelValue="formValues.facturado_empresa?.s_num_doc"
        />
        <TextInput
            label="Razón social"
            :modelValue="formValues.facturado_empresa?.s_nombre"
            readonly
        />
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
        <TextInput
            label="Distrito"
            :modelValue="formValues.facturado_empresa?.distrito?.distrito"
            readonly
        />
        <TextInput
            label="Direccion fiscal"
            :modelValue="formValues.facturado_empresa?.s_direccion"
            readonly
        />
      </div>
    </div>
    <div v-show="selectedOption === 'persona_natural'">
      <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2">
        <DropwdownSelect
            placeholder="Buscar Persona"
            label="nombre_compuesto"
            label2="s_num_doc"
            @keyup="filterPerNatural"
            @onSelecteValue="onSelectePerNatural"
            v-model="searchPerNatural"
            :showValue="false"
            :data="Clientes"
            @keyup.enter="onSelectePerNatural"
            class="w-full"
            id="voucher.s_facturado_persona"
        />
        <div class="flex items-center">
          <BtnAdd
              @click="useOpenModal('cartas.registro_cliente')"
              type="button"
              icon
              class="mx-2"
          />
          <BtnClean @click="clearPerNatural" icon/>
        </div>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
        <TextInput
            label="Documento"
            :modelValue="formValues.facturado_cliente?.s_num_doc"
            readonly
        />
        <TextInput
            label="Nombres y apellidos"
            :modelValue="formValues.facturado_cliente?.nombre_compuesto"
            readonly
        />
      </div>

    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
      <TextInput label="Correo" id="voucher.facturado_correo"
                 :error-message="form.facturado_correo.$error?.message"
                 v-model="form.facturado_correo.$value"/>
      <TextInputNumber label="Telefono" id="voucher.facturado_telefono" v-model="form.facturado_telefono.$value"
                       :error-message="form.facturado_telefono.$error?.message"/>
    </div>

    <div class="flex justify-center pt-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
        <button
            class="btn btn-outline.btn-secondary"
            @click="tabCartasRef.selectedTab = 1"
        >
          <ArrowLeftBold/>
          Anterior
        </button>
        <button class="btn btn-success text-white" @click="tabCartasRef.selectedTab = 3">
          <span class="">Siguiente</span>
          <ArrowRightBold/>
        </button>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import {defineForm, field} from "vue-yup-form";
import * as Yup from "yup";
import {type PropType, ref, toRefs} from "vue";
import {BtnAdd, BtnClean, DropwdownSelect, TextInput, TextInputNumber,} from "../../../../../components";
import {debounce} from "../../../../../utils/debounce.js";
import ArrowRightBold from "vue-material-design-icons/ArrowRightBold.vue";
import ArrowLeftBold from "vue-material-design-icons/ArrowLeftBold.vue";

import type {Cliente, Empresa} from "@/models/types";
import {useClienteStore} from "../../../../../store/cliente";
import {useEmpresaStore} from "../../../../../store/empresa";
import {useOpenModal} from "../../../../../hooks/useUtils";
import {BuildingOfficeIcon, UserIcon} from "@heroicons/vue/20/solid";
import type {ICartaFormStore} from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";
import {validateMaxDigits} from "@/utils/Regexs";
import {useInputsEvents} from "@/hooks/useInputsEvents";

const {searchCliente} = useClienteStore();
const {searchEmpresa} = useEmpresaStore();
const {onFocusInput} = useInputsEvents();

const {Clientes} = toRefs(useClienteStore());
const {Empresas} = toRefs(useEmpresaStore());
const selectedOption = ref<string>("");
const searchPerNatural = ref<string>("");
const searchPerJuridica = ref<string>("");

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
  s_facturado: field<string | null>(
      null,
      Yup.string().required()
  ),
  personaJuridicaDocumento: field<string | number | null | undefined>(
      "",
      Yup.string()
  ),
  personaJuridicaRazonsocial: field<string | number | null | undefined>(
      "",
      Yup.string()
  ),
  personaJuridicaDistrito: field<string | number | null | undefined>(
      "",
      Yup.string()
  ),
  personaJuridicaDireccion: field<string | number | null | undefined>(
      "",
      Yup.string()
  ),
  personaNaturalDocumento: field<string | number | null | undefined>(
      "",
      Yup.string()
  ),
  personaNaturalNombres: field<string | number | null | undefined>(
      "",
      Yup.string()
  ),
  facturado_correo: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .email("correo no válido")
          .min(5, "Minimo 5 caracteres")
          .max(100, "Máximo 100 caracteres")
          .nullable()
  ),
  facturado_telefono: field<number | null>(
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
});

const onValidateFocus = () => {

  if (form.s_facturado.$error) {
    onFocusInput("voucher.s_facturado");
     onFocusInput("voucher.s_facturado_persona");
    return
  }
  if (form.facturado_correo.$error) {
    return onFocusInput("voucher.facturado_correo");
  }
  if (form.facturado_telefono.$error) {
    return onFocusInput("voucher.facturado_telefono");
  }
}
const filterPerNatural = debounce(() => {
  return searchCliente(searchPerNatural.value);
}, 500);

const filterPerJuridica = debounce(() => {
  return searchEmpresa(searchPerJuridica.value);
}, 500);

const onSelectePerNatural = (payload: Cliente) => {
  searchPerNatural.value = "";
  formValues.facturado_empresa = null;
  formValues.s_facturado = payload.s_codigo;
  form.s_facturado.$value = payload.s_codigo;
  formValues.facturado_cliente = payload;
  form.facturado_correo.$value = payload.correo
  form.facturado_telefono.$value =  payload?.s_telefono ? parseInt(payload?.s_telefono) : null
};

const onSelectePerJuridica = (payload: Empresa) => {
  searchPerJuridica.value = "";
  formValues.facturado_cliente = null;
  formValues.s_facturado = payload.s_codigo;
  form.s_facturado.$value = payload.s_codigo;
  form.facturado_correo.$value = payload.correo
  form.facturado_telefono.$value =  payload?.s_telefono ? parseInt(payload?.s_telefono) : null
  formValues.facturado_empresa = payload;
};

const clearPerNatural = () => {
  searchPerNatural.value = "";
  form.s_facturado.$value = "";
  formValues.facturado_cliente = null;
  form.facturado_correo.$value = ""
  form.facturado_telefono.$value = null
};
const clearEmpresa = () => {
  searchPerJuridica.value = "";
  form.s_facturado.$value = "";
  formValues.facturado_empresa = null;
  form.facturado_correo.$value = ""
  form.facturado_telefono.$value = null
};


defineExpose({form, onValidateFocus});
</script>

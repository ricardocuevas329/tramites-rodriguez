<template>
  <div>
    <!-- AddCliente Form -->
    <Modal id="registro_cliente">
      <AddCliente :use-component="true" :redirect="false" />
    </Modal>
    <ScrollView>
        <div class="grid grid-cols-1 md:grid-cols-2">
          <InputSelect
            :items="TipoDocumentos"
            label="Tipo Documento"
            v-model="formFilter.s_tipo_docu.$value"
            :validate-error="isValidFilter"
            :error-message="formFilter.s_tipo_docu.$error?.message"
            label-data="s_abrev"
            value-data="s_codigo"
          />

          <div class="flex items-center">
            <TextInput
              label="Documento"
              v-model="formFilter.s_num_doc.$value"
              :validate-error="isValidFilter"
              @keyup.enter="
                getCliente(formFilter.s_tipo_docu.$value, formFilter.s_num_doc.$value)
              "
              :error-message="formFilter.s_num_doc.$error?.message"
            />
           <ToolTip text="Filtrar Cliente">
            <button
              @click.prevent="getCliente(formFilter.s_tipo_docu.$value, formFilter.s_num_doc.$value)"
              class="btn btn-sm btn-secondary btn-circle"
              :disabled="isLoadingFilter"
            >
              <SearchIcon class="relative px-2" />
            </button>
           </ToolTip>
          </div>
      </div>
      <LabelInput v-show="!isClient" class="text-warning">
        No se encontro al cliente, por favor registralo
        <button @click="useOpenModal('registro_cliente')" class="btn btn-sm btn-ghost">Click aqui</button>
      </LabelInput>
      <div v-show="form.s_nombres.$value">
        <div class="flex flex-wrap">
        <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2">
          <TextInput
            @keyup.enter="onFocusInput('s_paterno')"
            id="s_nombres"
            label="Nombres"
            readonly="true"
            :validate-error="isValid"
            v-model="form.s_nombres.$value"
            :error-message="form.s_nombres.$error?.message"    />
        </div>
        <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2">
          <TextInput
            @keyup.enter="onFocusInput('s_materno')"
            id="s_paterno"
            label="Apellido Paterno"
            readonly="true"
            :validate-error="isValid"
            v-model="form.s_paterno.$value"
            :error-message="form.s_paterno.$error?.message"
          />
        </div>
      </div>
      <div class="flex flex-wrap">
        <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2">
          <TextInput
            id="s_materno"
            label="Apellido Materno"
            :validate-error="isValid"
            readonly="true"
            v-model="form.s_materno.$value"
            :error-message="form.s_materno.$error?.message"
          />
        </div>
        <div class="w-full sm:w-1/2 md:w-1/2 lg:w-1/2 xl:w-1/2 mb-2">
          <TextInput
            id="s_compareciente"
            label="Compareciente"
            readonly="true"
            v-model="form.s_compareciente.$value"
            :error-message="form.s_compareciente.$error?.message"
          />
        </div>
      </div>
      </div>
    </ScrollView>
      <div class="pt-2 px-1">
        <BtnAdd @click.prevent="add" text="Agregar" />
      </div>
      <div class="pt-3">
        <TableList :comparecientes="comparecientes" v-if="comparecientes.length" />
      </div>

    <Center>
        <BtnSave :disabled="disabled" @click="onSubmit" />
      </Center>
  </div>
</template>
<script setup lang="ts">
import {
    InputSelect,
    BtnSave,
    Center,
    TextInput,
    BtnAdd,
    LabelInput,
    ToolTip,
    Modal,
    ScrollView,
} from "../../../../components";
import * as Yup from "yup";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { type PropType, toRefs, ref } from 'vue';
import type {ComparecienteBloqueado, DetalleBloqueado } from "@/models/types";
import { useTipoDocumentoStore } from "../../../../store/tipo-documento";
import { useInputsEvents } from "@/hooks/useInputsEvents";
import { useOpenModal } from "../../../../hooks/useUtils";
import { RegExps } from "../../../../utils/Regexs";
import { useClienteStore } from '../../../../store/cliente';
import { SearchIcon } from '../../../../components';
import { AddCliente, TableList } from "./Index";


const { onFocusInput } = useInputsEvents();
const { TipoDocumentos } = toRefs(useTipoDocumentoStore());
const { findClienteByDocument } = useClienteStore();
const isValid = ref<boolean>(false);
const isValidFilter = ref<boolean>(false);
const isClient = ref<boolean>(true);
const isLoadingFilter = ref<boolean>(false);

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: true,
        type: Object as PropType<ComparecienteBloqueado>,
    },
});


const emit = defineEmits(["onSubmit"]);
const { formValues } = toRefs(props);
const { comparecientes } = formValues.value


const form = defineForm({
    s_nombres: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Nombre no válido")
            .min(3, "minimo 3 caracteres")
            .max(50, "máximo 50 caracteres")
    ),
    s_paterno: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido paterno no válido")
            .min(3, "minimo 3 caracteres")
            .max(50, "máximo 50 caracteres")

    ),
    s_materno: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido materno no válido")
            .min(3, "minimo 3 caracteres")
            .max(50, "máximo 50 caracteres")
    ),
    s_compareciente: field<string | null>("",Yup.string().nullable()),
});

const formFilter = defineForm({
    s_tipo_docu: field<string >("", Yup.string().required("Seleccione una opción")),
    s_num_doc: field<string >("", Yup.string().required('Es requerido')),
});

const onSubmit = () => {
    emit("onSubmit", formValues.value);
};

const add = () => {
    isValid.value = true;
    if (isValidForm(form)) {
        let payload: DetalleBloqueado = {
            i_estado: 0,
            s_codigo: '',
            s_codreg_bloq: '',
            ...toObject(form)
        }
        comparecientes.push(payload);
        limpiar();
    }
};

const limpiar = () => {
    form.s_compareciente.$value = "";
    form.s_nombres.$value = "";
    form.s_paterno.$value = "";
    form.s_materno.$value = "";
    //formFilter.s_tipo_docu.$value = "";
    formFilter.s_num_doc.$value = "";
    isValid.value = false;
};


const disableButton = () => {
  setTimeout(() => {
   isLoadingFilter.value = false
  }, 1500);
}


const getCliente = async (tipodocu: string, numdocu: string) => {
    isValidFilter.value = true;
    if (isValidForm(formFilter)) {
      isLoadingFilter.value = true
        try {
            const { status, Cliente  } = await findClienteByDocument(tipodocu, numdocu);
            if (status) {
                form.s_compareciente.$value = Cliente.s_codigo;
                form.s_nombres.$value = Cliente.s_nombres;
                form.s_paterno.$value = Cliente.s_paterno;
                form.s_materno.$value = Cliente.s_materno;
                isClient.value = true;
            }
        } catch (error) {
                isClient.value = false;
                disableButton()
        } finally{
          disableButton()
        }
    }
};



</script>

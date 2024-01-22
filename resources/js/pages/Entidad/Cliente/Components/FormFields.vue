<template>
    <div>
        <ScrollView>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <InputSelect
                    :items="TipoDocumentsClients"
                    label="Tipo Documento"
                    v-model="form.id_tipo_documento.$value"
                    :validate-error="isSubmit"
                    :error-message="form.id_tipo_documento.$error?.message"
                    label-data="s_abrev"
                    value-data="s_codigo"
                    id="cliente.id_tipo_documento"
                    @input="onFocusInput('cliente.s_num_doc')"
                />
               <Row>
                <TextInput
                    label="Documento"
                    v-model="form.s_num_doc.$value"
                    :validate-error="isSubmit"
                    id="cliente.s_num_doc"
                    @keyup.enter="onFocusInput('cliente.s_localidad')"
                    :error-message="form.s_num_doc.$error?.message"
                />
                <ToolTip text="Buscar Cliente">
                <button :disabled="isSubmitFindByDocument" @click="onFindByDocument()" class="btn btn-sm btn-circle mt-6 ">
                    <MagnifyingGlassIcon  />
                </button>
                </ToolTip>
               </Row>
            </div>


            <TextInput
                label="Nombres"
                v-model="form.s_nombres.$value"
                :validate-error="isSubmit"
                :error-message="form.s_nombres.$error?.message"
                id="cliente.s_nombres"
                @keyup.enter="onFocusInput('cliente.s_paterno')"
            />

            <TextInput
                label="Apellido Paterno"
                v-model="form.s_paterno.$value"
                :validate-error="isSubmit"
                :error-message="form.s_paterno.$error?.message"
                id="cliente.s_paterno"
                @keyup.enter="onFocusInput('cliente.s_materno')"
            />

            <TextInput
                label="Apellido Materno"
                v-model="form.s_materno.$value"
                :validate-error="isSubmit"
                :error-message="form.s_materno.$error?.message"
                id="cliente.s_materno"
                @keyup.enter="onFocusInput('cliente.s_direccion')"
            />

           <div class="grid grid-cols-1 md:grid-cols-2">
            <InputSelect
                label="Sexo"
                :items="SexoItems"
                v-model="form.s_sexo.$value"
                :validate-error="isSubmit"
                :error-message="form.s_sexo.$error?.message"
                id="cliente.s_sexo"
                @input="onFocusInput('cliente.s_estado_civil')"
            />

            <InputSelect
                    :items="EstadoCivilItems"
                    label="Estado Civil"
                    v-model="form.s_estado_civil.$value"
                    :validate-error="isSubmit"
                    id="cliente.s_estado_civil"
                    @input="onFocusInput('cliente.s_localidad')"
                    :error-message="form.s_estado_civil.$error?.message"

                />
           </div>
          <LabelInput>Localidad:
            <LabelError v-if="isSubmit && form.s_localidad.$error?.message"> * {{ form.s_localidad.$error?.message }}</LabelError>
          </LabelInput>

          <Center>
            <MapPinIcon class="text-primary-500 w-5" />
            <span class="text-xs">
                    {{ SelectUbigeo?.distrito }} -
                    {{ SelectUbigeo?.provincia }} -
                    {{ SelectUbigeo?.departamento }}
                </span>
          </Center>
          <DropwdownSelect
              placeholder="Filtrar Localidad"
              label="distrito"
              label2="provincia"
              label3="departamento"
              @keyup="filterUbigeos"
              @onSelecteValue="onSelecteValue"
              v-model="searchUbigeos"
              :validate-error="isSubmit"
              :data="Ubigeos"
              id="cliente.s_localidad"
              @keyup.enter="onFocusInput('cliente.s_nombres')"
              @onClear="onClearLocality"

          />

            <TextInput
                label="Dirección"
                v-model="form.s_direccion.$value"
                :validate-error="isSubmit"
                :error-message="form.s_direccion.$error?.message"
                id="cliente.s_direccion"
                @keyup.enter="onFocusInput('cliente.s_correo')"
            />

            <TextInput
                type="email"
                label="Correo"
                v-model="form.s_correo.$value"
                :validate-error="isSubmit"
                :error-message="form.s_correo.$error?.message"
                id="cliente.s_correo"
            />



        </ScrollView>
        <Center>
            <BtnSave :disabled="disabled" @click="onSubmit" />
        </Center>
    </div>
</template>
<script setup lang="ts">
import {
    BtnSave,
    Center,
    ScrollView,
    TextInput,
    InputSelect,
    Row,
    DropwdownSelect,
    LabelInput,
    LabelError,
    ToolTip
} from "../../../../components";
import * as Yup from "yup";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { RegExps } from "../../../../utils/Regexs";
import {toRefs, onMounted, ref, watch} from "vue";
import type { PropType } from "vue";
import { useTipoDocumentoStore } from "../../../../store/tipo-documento";
import { useUbigeoStore } from "../../../../store/ubigeo";
import { debounce } from "../../../../utils/debounce.js";
import type { Ubigeo } from "../../../../models/ubigeo";
import { MapPinIcon, MagnifyingGlassIcon } from '@heroicons/vue/20/solid';
import type { Cliente } from "@/models/types";
import { EstadoCivilItems } from "@/services/EstadoCivilService";
import { useInputsEvents } from '@/hooks/useInputsEvents'
import { SexoItems } from "@/services/SexoService";
import { useClienteStore } from '../../../../store/cliente';


const searchUbigeos = ref<string>();
const SelectUbigeo = ref<Ubigeo>();
const isSubmit = ref<boolean>(false);
const { onFocusInput } = useInputsEvents()
const { Ubigeos } = toRefs(useUbigeoStore());
const { searchUbigeo } = useUbigeoStore();
const { TipoDocumentsClients } = toRefs(useTipoDocumentoStore());
const isSubmitFindByDocument = ref<boolean>(false);
const { findClienteByDocument } = useClienteStore();



const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: true,
        type: Object as PropType<Cliente>,
    },
});

const form = defineForm({
    s_nombres: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Nombre no válido")
            .min(3, "minimo 3")
            .max(50, "máximo 50 caracteres")
    ),
    s_paterno: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .min(3, "minimo 3 caracteres")
            .max(50, "máximo 50 caracteres")
    ),
    s_materno: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .min(3, "minimo 3")
            .max(50, "máximo 50 caracteres")
    ),
    id_tipo_documento: field<string | null | undefined>(
        "",
        Yup.string().required("es requerido").max(50, "máximo 50 caracteres")
    ),
    s_num_doc: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.isNumeric, "Documento no válido")
            .min(8, "minimo 8")
            .max(12, "máximo 12 caracteres")
    ),
    s_direccion: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(4, "minimo 4")
            .max(150, "máximo 150 caracteres")
    ),
    s_correo: field<string | null | undefined>(
        "",
        Yup.string()
            //.required("es requerido")
            .email("Email inVálido")
            //.min(5, "minimo 5")
            .max(100, "máximo 100 caracteres")
            .nullable()
    ),
    s_estado_civil: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(20, "máximo 20 caracteres")
    ),
    s_sexo: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(1, "máximo 1 caracteres").nullable()
    ),
    s_localidad: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(100, "máximo 100 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    onValidateFocus()
    isSubmit.value = true;
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (payload: Cliente) => {

    form.s_nombres.$value = payload.s_nombres;
    form.s_paterno.$value = payload.s_paterno;
    form.s_materno.$value = payload.s_materno;
    form.s_direccion.$value = payload.s_direccion;
    form.s_correo.$value = payload.s_correo;
    form.s_estado_civil.$value = payload.s_estado_civil;
    form.s_sexo.$value = payload.s_sexo;
    form.id_tipo_documento.$value = payload.id_tipo_documento;
    form.s_num_doc.$value = payload.s_num_doc;
    form.s_localidad.$value = payload.s_localidad;
    /**@ts-ignore */
    SelectUbigeo.value = payload.ubigeo;



};

const onValidateFocus = () => {
    if (form.id_tipo_documento.$error) {
        return onFocusInput("cliente.id_tipo_documento");
    }
    if (form.s_num_doc.$error) {
        return onFocusInput("cliente.s_num_doc");
    }
    if (form.s_localidad.$error) {
        return onFocusInput("cliente.s_localidad");
    }
    if (form.s_nombres.$error) {
        return onFocusInput("cliente.s_nombres");
    }
    if (form.s_paterno.$error) {
        return onFocusInput("cliente.s_paterno");
    }
    if (form.s_materno.$error) {
        return onFocusInput("cliente.s_materno");
    }
    if (form.s_direccion.$error) {
        return onFocusInput("cliente.s_direccion");
    }
    if (form.s_correo.$error) {
        return onFocusInput("cliente.s_correo");
    }
    if (form.s_estado_civil.$error) {
        return onFocusInput("cliente.s_estado_civil");
    }
    if (form.s_sexo.$error) {
        return onFocusInput("cliente.s_sexo");
    }

};

const onFindByDocument = async() => {
  let id_doc = form.id_tipo_documento.$value
  let num_doc = form.s_num_doc.$value
  if(id_doc && num_doc){

    try {
      isSubmitFindByDocument.value = true
      const { status, Cliente, message } = await findClienteByDocument(id_doc, num_doc)
      if(status){
        init(Cliente)
      }
    } catch (e) {
       // init({})
    } finally {
      setTimeout(()=>{
        isSubmitFindByDocument.value = false
      },1300)
    }
  }

}

const filterUbigeos = debounce(() => {
    return searchUbigeo(searchUbigeos.value);
}, 500);

const onSelecteValue = (payload: Ubigeo) => {
    onFocusInput('cliente.s_nombres')
    form.s_localidad.$value = payload.s_codigo;
    SelectUbigeo.value = payload;
};

const onClearLocality = (state) => {
  /*onFocusInput('cliente.s_localidad')
  form.s_localidad.$value = "";
  SelectUbigeo.value = {};*/
};

onMounted(() => {
  watch(formValues, (newValues, oldValues) => {
    init(newValues);
  });
});

</script>

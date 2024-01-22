<template>
  <ScrollView>
    <UploaderFiles :key="keyDocumentForm" :files="form.files.$value"
                   endPointDelete="/api/signature/document/" :maxFiles="MAX_TOTAL_FILES"
                   maxFileSize="15MB"
                   maxTotalFileSize="60MB" @deleteFile="onDeleteFile" @selectFile="onSelectFile" @getFiles="onGetFiles"
                   accept="image/* , application/pdf"
                   label="Arrastra o Agrega Documentos"/>
    <InputSelect
        :validate-error="isSubmit"
        :error-message="form.cliente.id_tipo_documento.$error?.message"
        labelData="s_abrev" valueData="s_codigo"
        :items="TipoDocumentsClients"
        v-model="form.cliente.id_tipo_documento.$value"
        id="firma.cliente.id_tipo_documento"
        label="Tipo Documento"/>
    <Row>
      <TextInput
          :validate-error="isSubmit"
          :error-message="form.cliente.s_num_doc.$error?.message"
          v-model="form.cliente.s_num_doc.$value"
          id="firma.cliente.s_num_doc"
          @onClear="onClearClient"
          label="N° Documento"/>

      <ToolTip text="Buscar Usuario">
        <button :disabled="isSubmitFindByDocument" @click="onFindByDocument"
                class="mt-5 btn btn-circle btn-sm text-success">
          <MagnifyingGlassIcon/>
        </button>
      </ToolTip>

    </Row>
    <div v-if="form.s_cliente.$value">

      <TextInput disabled v-model="form.cliente.nombre_compuesto.$value" label="Nombres"/>
      <TextInput disabled label="Distrito" v-model="form.cliente.ubigeo.$value"/>
      <TextInput disabled v-model="form.cliente.s_direccion.$value" label="Direccion"/>

      <div class=" grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2  ">
        <InputSelect
            :items="EstadoCivilItems"
            label="Estado Civil"
            v-model="form.cliente.s_estado_civil.$value"
            id="personal.s_estado_civil"
            validate disabled
            :validate-error="isSubmit"
            @input="onFocusInput('cliente.s_nombres')"
            :error-message="form.cliente.s_estado_civil.$error?.message"
        />
        <TextInput disabled v-model="form.cliente.s_cargo.$value" label="Ocupación"/>
      </div>
      <TextInput disabled v-model="form.cliente.s_correo.$value" label="Email"/>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 ">
        <TextInput disabled v-model="form.cliente.s_telefono.$value" label="Telefono"/>
        <TextInput disabled v-model="form.cliente.s_celular.$value" label="Celular"/>
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 ">
        <InputSelect
            label="Sexo"
            :items="SexoItems"
            v-model="form.cliente.s_sexo.$value"
            :validate-error="isSubmit"
            :error-message="form.cliente.s_sexo.$error?.message"
            id="personal.s_sexo"
            disabled
            @input="onFocusInput('cliente.s_estado_civil')"
        />
        <TextInput disabled v-model="form.cliente.nacionalidad.$value" label="Nacionalidad"/>
      </div>

    </div>


    <div class=" grid grid-cols-1 md:grid-cols-1   ">
      <InputSelect v-model="form.s_proceder.$value" id="firma.s_proceder"
                   :validate-error="isSubmit"
                   :error-message="form.s_proceder.$error?.message" :items="itemsProceder" label="Proceder"/>
      <TextInput v-model="form.d_caducidad.$value"
                 :validate-error="isSubmit" id="firma.d_caducidad"
                 :error-message="form.d_caducidad.$error?.message" label="Caducidad" type="date"/>
    </div>

  </ScrollView>

  <Center>
    <BtnSave :showIcon="false" :loading="isSubmitForm" :disabled="isSubmitForm" @click="onSubmit"
             class="btn-success btn-sm"
             text="Grabar">
      <template v-slot:icon>
        <ContentSave/>
      </template>
    </BtnSave>
  </Center>

</template>
<script setup lang="ts">
import {useTipoDocumentoStore} from "@/store/tipo-documento";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import {EstadoCivilItems} from "@/services/EstadoCivilService";
import {SexoItems} from "@/services/SexoService";
import {BtnSave, Center, InputSelect, Row, ScrollView, TextInput, ToolTip, UploaderFiles} from "@/components";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as Yup from "yup";
import {RegExps} from "@/utils/Regexs";
import {onMounted, type PropType, ref, toRefs, watch} from "vue";
import {useClienteStore} from "@/store/cliente";
import type {Cliente, Firma} from "@/models/types";
import ContentSave from "vue-material-design-icons/ContentSave.vue";
import {useDate} from "@/hooks/useDates"
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {useGenerateKeyRandom} from "@/hooks/useUtils";

const props = defineProps({
  isSubmitForm: {
    required: true,
    type: Boolean,
    default: false,
  },
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<Firma>,
  },
});
const MAX_TOTAL_FILES = 4
const {formValues, isSubmitForm} = toRefs(props)
const {todayDefault} = useDate()
const itemsProceder = [
  {
    id: "POR DERECHO PROPIO",
    label: "POR DERECHO PROPIO",
  },
  {
    id: "POR DERECHO PROPIO Y REPRESENTA",
    label: "POR DERECHO PROPIO Y REPRESENTA",
  },
  {
    id: "EN REPRESENTACION",
    label: "EN REPRESENTACIONA",
  }
]

const {onFocusInput} = useInputsEvents()
const {TipoDocumentsClients} = toRefs(useTipoDocumentoStore())
const {findClienteByDocument} = useClienteStore();
const keyDocumentForm = ref<string>();
const isSubmitFindByDocument = ref<boolean>(false);
const isSubmit = ref<boolean>(false)
const form = defineForm({

  s_proceder: field<string | null | undefined>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()),
  d_caducidad: field<string | null | undefined>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()),
  s_cliente: field<string | null | undefined>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()),
  cliente: {
    nombre_compuesto: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .nullable()),
    ubigeo: field<string | null>(
        "",
        Yup.string()
            .nullable()),
    s_telefono: field<string | null>(
        "",
        Yup.string()
            .nullable()),
    s_celular: field<string | null>(
        "",
        Yup.string()
            .nullable()),
    nacionalidad: field<string | null>(
        "",
        Yup.string()
            .nullable()),
    s_cargo: field<string | null>(
        "",
        Yup.string()
            .nullable()),
    id_tipo_documento: field<string | null>(
        "",
        Yup.string().required("es requerido")
            .max(50, "máximo 50 caracteres")
    ),
    s_num_doc: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.isNumeric, "Numero no válido")
            .min(8, "minimo 8")
            .max(12, "máximo 12 caracteres")
    ),
    s_direccion: field<string | null>(
        "",
        Yup.string()
            .max(150, "máximo 150 caracteres")
    ),
    s_correo: field<string | null>(
        "",
        Yup.string()
            //.required("es requerido")
            .email("Email inVálido")
            .max(100, "máximo 100 caracteres")
            .nullable()
    ),
    s_estado_civil: field<string | null>(
        "",
        Yup.string()
            .max(20, "máximo 20 caracteres")
    ),
    s_sexo: field<string | null>(
        "",
        Yup.string()
            .max(1, "máximo 1 caracteres").nullable()
    ),
    s_localidad: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(100, "máximo 100 caracteres")
    ),
  },
  files: field<IUploadFile[]>([]),
})

const onClearClient = (success: boolean) => {
  if (success) {
    form.s_cliente.$value = ""
  }
}

const emit = defineEmits(["onSubmit"]);
const setValuesClient = (payload: Cliente) => {
  form.s_cliente.$value = payload.s_codigo
  form.cliente.nombre_compuesto.$value = payload.nombre_compuesto
  form.cliente.s_direccion.$value = payload.s_direccion;
  form.cliente.s_correo.$value = payload.s_correo;
  form.cliente.s_estado_civil.$value = payload.s_estado_civil;
  form.cliente.s_sexo.$value = payload.s_sexo;
  form.cliente.id_tipo_documento.$value = payload.id_tipo_documento;
  form.cliente.s_num_doc.$value = payload.s_num_doc;
  form.cliente.s_localidad.$value = payload.s_localidad
  form.cliente.s_telefono.$value = payload.s_telefono
  form.cliente.s_celular.$value = payload.s_celular
  form.cliente.nacionalidad.$value = payload.nacionalidad?.s_gentilicio
  form.cliente.s_cargo.$value = payload.s_cargo
  form.cliente.ubigeo.$value = payload?.ubigeo?.ubigeo_compuesto

};

const setFormValues = (payload: Firma) => {
  form.s_cliente.$value = payload.s_cliente
  form.cliente.nombre_compuesto.$value = payload.cliente?.nombre_compuesto
  form.cliente.s_direccion.$value = payload.cliente.s_direccion;
  form.cliente.s_correo.$value = payload.cliente.s_correo;
  form.cliente.s_estado_civil.$value = payload.cliente.s_estado_civil;
  form.cliente.s_sexo.$value = payload.cliente.s_sexo;
  form.cliente.id_tipo_documento.$value = payload.cliente.id_tipo_documento;
  form.cliente.s_num_doc.$value = payload.cliente.s_num_doc;
  form.cliente.s_localidad.$value = payload.cliente.s_localidad
  form.cliente.s_telefono.$value = payload.cliente.s_telefono
  form.cliente.s_celular.$value = payload.cliente.s_celular
  form.cliente.nacionalidad.$value = payload.cliente.nacionalidad?.s_gentilicio
  form.cliente.s_cargo.$value = payload.cliente.s_cargo
  form.cliente.ubigeo.$value = payload?.cliente?.ubigeo?.ubigeo_compuesto
  form.s_proceder.$value = payload.s_proceder
  form.d_caducidad.$value = payload.d_caducidad
  if( payload.files.length){
    form.files.$value = payload.files
    keyDocumentForm.value = useGenerateKeyRandom()
  }

}


const onValidateFocus = () => {

  if (form.cliente.id_tipo_documento.$error) {
    return onFocusInput("firma.cliente.id_tipo_documento");
  }

  if (form.cliente.s_num_doc.$error) {
    return onFocusInput("firma.cliente.s_num_doc");
  }

  if (form.s_proceder.$error) {
    return onFocusInput("firma.s_proceder");
  }

  if (form.d_caducidad.$error) {
    return onFocusInput("firma.d_caducidad");
  }

  if (!form.cliente.nombre_compuesto.$value) {
    return onFindByDocument()
  }

}
const onFindByDocument = async () => {
  let id_doc = form.cliente.id_tipo_documento.$value
  let s_num_doc = form.cliente.s_num_doc.$value
  if (id_doc && s_num_doc) {

    try {
      isSubmitFindByDocument.value = true
      const {status, Cliente, message} = await findClienteByDocument(id_doc, s_num_doc)
      if (status) {
        setValuesClient(Cliente)
      }
    } catch (e) {
      // setValuesClient({})
    } finally {
      setTimeout(() => {
        isSubmitFindByDocument.value = false
      }, 1300)
    }
  }

}
const onSubmit = async () => {
  isSubmit.value = true
  onValidateFocus()
  if (isValidForm(form)) {
    emit("onSubmit", toObject(form));
  }
}

const onGetFiles = (files: IUploadFile[]) => {
  form.files.$value = files
}



const onDeleteFile = (file: IUploadFile) => {
  const indexDeleteFile = form.files.$value.findIndex(item => item.id === file?.id_primary);
  if (indexDeleteFile !== -1) {
    form.files.$value.splice(indexDeleteFile, 1);
    keyDocumentForm.value = useGenerateKeyRandom()
  }
}
const onSelectFile = (file: IUploadFile) => {
  window.open(file?.source)
}
onMounted(() => {
  let fecha = new Date(todayDefault.value);
  fecha.setFullYear(fecha.getFullYear() + 1);
  form.d_caducidad.$value = fecha.toISOString().slice(0, 10)
  if (formValues.value?.s_codigo) {
    setFormValues(formValues.value);
  }
  watch(
      () => formValues.value,
      (newId, oldId) => {
        setFormValues(newId);
      }
  )
});

</script>

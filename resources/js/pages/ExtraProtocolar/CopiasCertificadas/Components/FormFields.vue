<template>
  <div>
    <span ref="refFormField"></span>
    <ScrollView>
      <div class=" grid grid-cols-1 md:grid-cols-2 ">

        <TextInputNumber v-model="form.i_copias.$value" id="copy.i_copias" :validate-error="isSubmit"
                         :error-message="form.i_copias.$error?.message" label="N° Copias"/>


        <TextInputNumber v-model="form.i_inicial.$value" id="copy.i_inicial" :validate-error="isSubmit"
                         :error-message="form.i_inicial.$error?.message" label="Copia Inicial"/>
      </div>

      <TextArea v-model="form.s_descripcion.$value" id="copy.s_descripcion" :validate-error="isSubmit"
                :error-message="form.s_descripcion.$error?.message" label-full
                label="Correspondiente a los Folios"/>
      <TextInput v-model="form.s_libros.$value" id="copy.s_libros" :validate-error="isSubmit"
                 :error-message="form.s_libros.$error?.message" label="Del Libro"/>


         <div >
           <LabelInput class="w-full">Empresa: <span v-if="labelEmpresa" class="font-light p-2 badge badge-xs badge-outline badge-success">{{labelEmpresa}}</span>
           <LabelError class="relative" v-if="isSubmit && form.s_pertenece.$error?.message">* {{
               form.s_pertenece.$error?.message
             }}
           </LabelError>
           </LabelInput>
         </div>

        <DropwdownSelect
            placeholder="Perteneciente a"
            label="nombre_compuesto"
            label2="s_num_doc"
            @keyup="filterCompany"
            @onSelecteValue="onSelectedCompany"
            v-model="searchCompany"
            :data="Empresas"
            @keyup.enter="filterCompany"
            class="w-full"
            @onClear="onClearCompany"
            id="copy.s_pertenece"
        />



      <div class=" grid grid-cols-1 md:grid-cols-2  ">

        <TextInput id="copy.s_consta" label="Que consta de" v-model="form.s_consta.$value" :validate-error="isSubmit"
                   :error-message="form.s_consta.$error?.message"/>
        <InputSelect id="copy.s_folios" label="Folios" :items="LibroFormasItems" v-model="form.s_folios.$value"
                     :validate-error="isSubmit"
                     :error-message="form.s_folios.$error?.message"/>

      </div>


      <div >
        <LabelInput class="w-full">Notario: <span v-if="labelNotario" class="font-light p-2 badge badge-xs badge-outline badge-primary">{{labelNotario}}</span>
          <LabelError class="relative" v-if="isSubmit && form.s_legalizado.$error?.message">* {{
              form.s_legalizado.$error?.message
            }}
          </LabelError>
        </LabelInput>
      </div>
        <DropwdownSelect
            placeholder="Legalizado Ante"
            label="nombre_compuesto"
            label2="s_numdoc"
            @keyup="filterLegalizado"
            @onSelecteValue="onSelectedLegalizado"
            v-model="searchLegalizado"
            :showValue="true"
            :data="Notarios"
            @keyup.enter="filterLegalizado"
            class="w-full"
            @onClear="onClearLegalizado"
            id="copy.s_legalizado"
        />


      <div class=" grid grid-cols-1 md:grid-cols-2  ">

        <TextInput id="copy.s_cargo" label="Cargo" v-model="form.s_cargo.$value" :validate-error="isSubmit"
                   :error-message="form.s_cargo.$error?.message"/>
        <TextInput id="copy.s_numero_reg" label="Registrado bajo N°" v-model="form.s_numero_reg.$value"
                   :validate-error="isSubmit"
                   :error-message="form.s_numero_reg.$error?.message"/>

      </div>

      <TextInput type="date" :min="todayDefault" id="copy.d_fecha_legalizado" label="Con Fecha"
                 v-model="form.d_fecha_legalizado.$value" :validate-error="isSubmit"
                 :error-message="form.d_fecha_legalizado.$error?.message"/>


      <TextArea id="copy.s_observacion" v-model="form.s_observacion.$value" :validate-error="isSubmit"
                :error-message="form.s_observacion.$error?.message" label-full
                label="Observacion"/>
    </ScrollView>
    <Center>
      <BtnSave @click="onSubmit" :disabled="disabled" :loading="disabled" class="btn-success btn-sm" text="GUARDAR">
        <template v-slot:icon>
          <ContentSave class="w-4"/>
        </template>
      </BtnSave>
    </Center>
  </div>
</template>
<script setup lang="ts">
import {
  BtnSave,
  Center,
  DropwdownSelect,
  LabelError,
  LabelInput,
  ScrollView,
  TextArea,
  TextInput,
  TextInputNumber
} from "@/components";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as Yup from "yup";
import {validateMaxDigits} from "@/utils/Regexs";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import {useDate} from "@/hooks/useDates";
import {onMounted, type PropType, ref, toRefs, watch} from "vue";
import type {Abogado, CopiaCertificada, Empresa} from "@/models/types";
import ContentSave from "vue-material-design-icons/ContentSave.vue";
import {debounce} from "@/utils/debounce.js";
import {useEmpresaStore} from "@/store/empresa";
import InputSelect from "@/components/InputSelect.vue";
import {LibroFormasItems} from "@/services/LibroService";
import {useNotarioStore} from "@/store/notario";
import {useOnScrollMoveTo} from "@/hooks/useUtils";

const props = defineProps({
  disabled: {
    required: true,
    type: Boolean,
    default: false,
  },
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<CopiaCertificada>,
  },
});

const refFormField = ref<HTMLElement>()
const {disabled, formValues} = toRefs(props)
const {Empresas} = toRefs(useEmpresaStore())
const {searchEmpresa} = useEmpresaStore()
const {Notarios} = toRefs(useNotarioStore())
const {searchNotario} = useNotarioStore()

const searchCompany = ref<string>('')
const searchLegalizado = ref<string>('')
const labelEmpresa = ref<string>('')
const labelNotario = ref<string>('')


const {onFocusInput} = useInputsEvents();
const {todayDefault} = useDate()
const isSubmit = ref<boolean>(false);
const emit = defineEmits(["onSubmit"]);
const form = defineForm({
  i_copias: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => Number.isNaN(value) ? null : value)
          .test("maxDigits", "Máximo de 10 dígitos permitidos.", value => {
            return validateMaxDigits(value, 10)
          })
          .positive("Numero no Válido")
          .nullable()
  ),
  i_inicial: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => Number.isNaN(value) ? null : value)
          .test("maxDigits", "Máximo de 10 dígitos permitidos.", value => {
            return validateMaxDigits(value, 10)
          })
          .positive("Numero no Válido")
          .nullable()
  ),
  s_descripcion: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(255, "máximo 255 caracteres")
          .nullable()
  ),
  s_libros: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(255, "máximo 255 caracteres")
          .nullable()
  ),
  s_consta: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(20, "máximo 20 caracteres")
          .nullable()
  ),
  s_folios: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(50, "máximo 50 caracteres")
          .nullable()
  ),
  s_cargo: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(120, "máximo 120 caracteres")
          .nullable()
  ),
  s_legalizado: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(10, "máximo 10 caracteres")
          .nullable()
  ),
  d_fecha_legalizado: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  s_numero_reg: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(50, "máximo 50 caracteres")
          .nullable()
  ),
  s_observacion: field<string | null>(
      "",
      Yup.string()
          .max(255, "máximo 255 caracteres")
          .nullable()
  ),
  s_pertenece: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(100, "máximo 10 caracteres")
          .nullable()
  ),

})


const onSubmit = () => {
  isSubmit.value = true
  onValidateFocus()
  if (isValidForm(form)) {
    emit("onSubmit", toObject(form))
  }

}
const init = (payload: CopiaCertificada) => {
  form.i_copias.$value = payload.i_copias
  form.i_inicial.$value = payload.i_inicial
  form.s_cargo.$value = payload.s_cargo
  form.s_consta.$value = payload.s_consta
  form.s_descripcion.$value = payload.s_descripcion
  form.s_folios.$value = payload.s_folios
  form.s_legalizado.$value = payload.s_legalizado
  form.s_libros.$value = payload.s_libros
  form.s_numero_reg.$value = payload.s_numero_reg
  form.s_observacion.$value = payload.s_observacion
  form.s_pertenece.$value = payload.s_pertenece
  form.d_fecha_legalizado.$value = payload?.fecha_legalizado
  form.s_numero_reg.$value = payload.s_numeroReg
  labelEmpresa.value = payload?.empresa?.nombre_compuesto
  labelNotario.value = payload?.legalizado?.nombre_compuesto

}

const onValidateFocus = () => {
  if (form.i_copias.$error) {
    return onFocusInput("copy.i_copias");
  }
  if (form.i_inicial.$error) {
    return onFocusInput("copy.i_inicial");
  }
  if (form.s_cargo.$error) {
    return onFocusInput("copy.s_cargo");
  }
  if (form.s_consta.$error) {
    return onFocusInput("copy.s_consta");
  }
  if (form.s_descripcion.$error) {
    return onFocusInput("copy.s_descripcion");
  }
  if (form.s_folios.$error) {
    return onFocusInput("copy.s_folios");
  }
  if (form.s_legalizado.$error) {
    return onFocusInput("copy.s_legalizado");
  }
  if (form.s_libros.$error) {
    return onFocusInput("copy.s_libros");
  }
  if (form.s_numero_reg.$error) {
    return onFocusInput("copy.s_numero_reg");
  }
  if (form.s_observacion.$error) {
    return onFocusInput("copy.s_observacion");
  }
  if (form.s_pertenece.$error) {
    return onFocusInput("copy.s_pertenece");
  }
  if (form.d_fecha_legalizado.$error) {
    return onFocusInput("copy.d_fecha_legalizado");
  }

};

const filterCompany = debounce(() => {
  return searchEmpresa(searchCompany.value);
}, 500);


const filterLegalizado = debounce(() => {
  return searchNotario(searchLegalizado.value);
}, 500);


const onClearCompany = (success: boolean) => {
  if (success) {
    searchCompany.value = "";
    form.s_pertenece.$value = ""
    labelEmpresa.value =  ""

  }
};

const onClearLegalizado = (success: boolean) => {
  if (success) {
    searchLegalizado.value = "";
    form.s_legalizado.$value = ""
    labelNotario.value =  ""

  }
};


const onSelectedCompany = (payload: Empresa) => {
  searchCompany.value = payload.nombre_compuesto
  form.s_pertenece.$value = payload.s_codigo
  labelEmpresa.value =  payload.nombre_compuesto

};

const onSelectedLegalizado = (payload: Abogado) => {
  searchLegalizado.value = payload.nombre_compuesto
  form.s_legalizado.$value = payload.s_codigo
  labelNotario.value = payload.nombre_compuesto
};



onMounted(() => {
  useOnScrollMoveTo(refFormField.value)
  watch(
      () => formValues?.value,
      (newId, oldId) => {
        useOnScrollMoveTo(refFormField.value)
        init(newId);
      }
  )
});
//defineExpose({onSubmit, form, onValidateFocus});
</script>

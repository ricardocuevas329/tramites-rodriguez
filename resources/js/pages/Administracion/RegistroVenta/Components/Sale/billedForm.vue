<template>
  <div>

    <VirtualScrollForm>
      <br>
      <Row>
        <LabelInput>Documento</LabelInput>
        <InputSelect :showLabel="false" :validate-error="isSubmit" id="registration.invoice.documento"
          v-model="form.documento.$value" :error-message="form.documento.$error?.message" :items="TipoDocumentsCompanies"
          label-data="s_abrev" value-data="s_codigo" @input="onFocusInput('registration.invoice.numero')" />
      </Row>
      <Row>
        <LabelInput>Numero</LabelInput>
        <TextInputNumber id="registration.invoice.numero" v-model="form.numero.$value" :validate-error="isSubmit"
          :error-message="form.numero.$error?.message" @keyup.enter="onFocusInput('registration.invoice.nombres')"   :showLabel="false" />
      </Row>
      <Row>
        <LabelInput>Nombres</LabelInput>
        <TextInput id="registration.invoice.nombres" v-model="form.nombres.$value" :validate-error="isSubmit"
          :error-message="form.nombres.$error?.message"  @keyup.enter="onFocusInput('registration.invoice.direccion')"   :showLabel="false" />
      </Row>
      <Row>
        <LabelInput>Dirección</LabelInput>
        <TextInput id="registration.invoice.direccion" v-model="form.direccion.$value" :validate-error="isSubmit"
          :error-message="form.direccion.$error?.message"  @keyup.enter="onFocusInput('registration.invoice.distrito')"  :showLabel="false" />
      </Row>
      <Row>
        <LabelInput>Distrito</LabelInput>
        <TextInput id="registration.invoice.distrito" v-model="form.distrito.$value" :validate-error="isSubmit"
          :error-message="form.distrito.$error?.message" :showLabel="false" />
      </Row>
    </VirtualScrollForm>



  </div>
</template>
<script setup lang="ts">
import { LabelInput, Row, InputSelect, TextInputNumber, TextInput, VirtualScrollForm } from "@/components";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import * as Yup from "yup";
import { validateMaxDigits } from "@/utils/Regexs";
import { useInputsEvents } from "@/hooks/useInputsEvents";
import {  ref, toRefs } from 'vue';
import { useTipoDocumentoStore } from '../../../../../store/tipo-documento';

const { onFocusInput } = useInputsEvents()
const { TipoDocumentsCompanies } = toRefs(useTipoDocumentoStore())
const form = defineForm({
  documento: field<string | null>("", Yup.string()
    //.transform((value, originalValue) => (originalValue.trim()))
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
  numero: field<number | null>(
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
  nombres: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
  direccion: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
  distrito: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
});
const isSubmit = ref<boolean>(false)
const onSubmit = () => {
  if (!isSubmit.value) {
    isSubmit.value = true;
  }

 
  if (!isValidForm(form)) {
    setTimeout(() => {
      onValidateFocus()
    }, 300)
  }

};
const onValidateFocus = () => {
  if (form.documento.$error) {
    return onFocusInput("registration.invoice.documento");
  }
  if (form.numero.$error) {
    return onFocusInput("registration.invoice.numero");
  }
  if (form.nombres.$error) {
    return onFocusInput("registration.invoice.nombres");
  }
  if (form.direccion.$error) {
    return onFocusInput("registration.invoice.direccion");
  }

  if (form.distrito.$error) {
    return onFocusInput("registration.invoice.distrito");
  }

};

 
 
 

 
 

 

defineExpose({ onValidateFocus, onSubmit, form: form })

</script>

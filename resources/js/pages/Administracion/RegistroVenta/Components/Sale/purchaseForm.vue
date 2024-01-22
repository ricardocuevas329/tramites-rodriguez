<template>
  <div>
    <VirtualScrollForm height="250px">
      <br>
      <Row>
        <LabelInput>Recibo</LabelInput>
        <InputSelect :showLabel="false"
         :validate-error="isSubmit" 
         id="registration.sale.factura_electronica"
         v-model="form.factura_electronica.$value"
        :error-message="form.factura_electronica.$error?.message" 
        :items="[{id:'FACTURA ELECTRONICA', label:'FACTURA ELECTRONICA'}]"
        @input="onFocusInput('registration.sale.numero')"
        />
      </Row>
      <Row>
        <LabelInput full>N°</LabelInput>
        <Row>
          <TextInput   id="registration.sale.numero" v-model.trim="form.numero.$value"
            :validate-error="isSubmit" :error-message="form.numero.$error?.message" :showLabel="false"
            @keyup.enter="onFocusInput('registration.sale.serie')" />

          <TextInput  id="registration.sale.serie" v-model.trim="form.serie.$value"
            :validate-error="isSubmit" :error-message="form.serie.$error?.message" :showLabel="false"
            @keyup.enter="onFocusInput('registration.sale.orden_compra')" />
        </Row>
      </Row>
      <Row>
        <LabelInput full>Orden de Compra</LabelInput>
       
          <TextInput   id="registration.sale.orden_compra" v-model.trim="form.orden_compra.$value"
            :validate-error="isSubmit" :error-message="form.orden_compra.$error?.message" :showLabel="false"
            @keyup.enter="onFocusInput('registration.sale.fecha_emision')" />

       
      </Row>
      <Row>
        <LabelInput full>Fecha de Emision</LabelInput>
        <Row>
          <TextInput type="date" id="registration.sale.fecha_emision" v-model.trim="form.fecha_emision.$value"
            :validate-error="isSubmit" :error-message="form.fecha_emision.$error?.message" :showLabel="false"
            @keyup.enter="onFocusInput('registration.sale.hora_emision')" />

          <TextInput type="time" id="registration.sale.hora_emision"  v-model.trim="form.hora_emision.$value"
            :validate-error="isSubmit" :error-message="form.hora_emision.$error?.message" :showLabel="false"
            @keyup.enter="onFocusInput('registration.sale.fecha_vencimiento')" />
        </Row>
      </Row>
     
      <Row>
        <LabelInput full>Fecha de Vencimiento</LabelInput>
        <TextInput type="date" id="registration.sale.fecha_vencimiento" v-model.trim="form.fecha_vencimiento.$value"
            :validate-error="isSubmit" :error-message="form.fecha_vencimiento.$error?.message" :showLabel="false"
          @keyup.enter="onFocusInput('registration.sale.cantidad')" />

      </Row>

    </VirtualScrollForm>
    <Center>
      <div v-if="isValidForm(form)">
        <Button @click="addBudget"  label="Vista Previa"
           icon="pi   pi-eye" raised text size="small" />
      </div>
      <Button v-if="isEdit" @click="onCancel()" class=" bg-primary" label="Cancelar" icon="pi pi-times " raised text
        size="small" />
    </Center>
 
  </div>
</template>
<script setup lang="ts">
import { Center, LabelInput, Row,  TextInput, VirtualScrollForm, InputSelect } from "@/components";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import * as Yup from "yup";
import { useInputsEvents } from "@/hooks/useInputsEvents";
import { computed, ref } from "vue";
import Button from 'primevue/button';
 


const { onFocusInput } = useInputsEvents()

const form = defineForm({
  factura_electronica: field<string | null>("", Yup.string()
    //.transform((value, originalValue) => (originalValue.trim()))
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
    numero: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
    serie: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
    orden_compra: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
    fecha_emision: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
    hora_emision: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
    fecha_vencimiento: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
});
const isSubmit = ref<boolean>(false)
const isEdit = ref<boolean>(false)
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
  if (form.factura_electronica.$error) {
    return onFocusInput("registration.sale.factura_electronica");
  }
  if (form.numero.$error) {
    return onFocusInput("registration.sale.numero");
  }
  if (form.serie.$error) {
    return onFocusInput("registration.sale.serie");
  }

  if (form.orden_compra.$error) {
    return onFocusInput("registration.sale.orden_compra");
  }
  if (form.fecha_emision.$error) {
    return onFocusInput("registration.sale.fecha_emision");
  }
  if (form.hora_emision.$error) {
    return onFocusInput("registration.sale.hora_emision");
  }
  
  if (form.hora_emision.$error) {
    return onFocusInput("registration.sale.hora_emision");
  }
  
  if (form.fecha_vencimiento.$error) {
    return onFocusInput("registration.sale.fecha_vencimiento");
  }
  
};

const addBudget = () => {
  if (isValidForm(form)) {
    
  }
}
 
 


const setForm = (payload) => {
  form.descripcion.$value = payload.descripcion
  form.cantidad.$value = payload.cantidad
  form.precio.$value = payload.precio

}

const cleanForm = () => {
  form.descripcion.$value = ""
  form.cantidad.$value = null
  form.precio.$value = null

}

const onCancel = () => {
  isEdit.value = false
  cleanForm()
}
 
defineExpose({ onValidateFocus, onSubmit, form: form  })

</script>

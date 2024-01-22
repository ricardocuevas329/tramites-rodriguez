<template>
  <div>

    <VirtualScrollForm>
      <br>
      <Row>
        <LabelInput>REF</LabelInput>
        <TextInput id="registration.detail.ref" v-model.trim="form.ref.$value" :validate-error="isSubmit"
          :error-message="form.ref.$error?.message" :showLabel="false"
          @keyup.enter="onFocusInput('registration.detail.servicio')" />
      </Row>
      <Row>
        <LabelInput>Servicio:</LabelInput>
        <DropwdownSelect class="w-full" placeholder="Filtrar" label="s_descripcion" @keyup="filterUbigeos"
          id="registration.detail.servicio" @onSelecteValue="onSelectedPersonal" v-model="searchPerson" :data="Servicios"
          @onClear="onClearPerson" :validate-error="isSubmit" @keyup.enter="onFocusInput('registration.detail.cantidad')"
          :error-message="form.servicio.$error?.message" />
      </Row>
      <Row>
        <LabelInput>Cantidad</LabelInput>
        <TextInput @keyup.enter="onFocusInput('registration.detail.precio')" id="registration.detail.cantidad"
          v-model="form.cantidad.$value" :validate-error="isSubmit" :error-message="form.cantidad.$error?.message"
          :showLabel="false" />
      </Row>
      <Row>
        <LabelInput>Precio</LabelInput>
        <TextInput id="registration.detail.precio" v-model="form.precio.$value" :validate-error="isSubmit"
          :error-message="form.precio.$error?.message" :showLabel="false" />
      </Row>
    </VirtualScrollForm>
    <Center>
      <div v-if="isValidForm(form)">
        <Button @click="addBudget" :label="isEdit ? 'Actualizar' : 'Agregar' + 'Detalle Servicio'"
          :icon="isEdit ? 'pi   pi-save ' : 'pi   pi-plus '" raised text size="small" />
      </div>
      <Button v-if="isEdit" @click="onCancel()" class=" bg-primary" label="Cancelar" icon="pi pi-times " raised text
        size="small" />
    </Center>

    <VirtualScrollForm v-if="services.length" showScrollX height="150px">
      <Table>
        <THead>
          <tr>
            <td>
             REF
            </td>
            <td>
              Servicio
            </td>
            <td>
              Cantidad
            </td>
            <td>
              Precio
            </td>
            <td>
              Acciones
            </td>
          </tr>
        </THead>
        <tbody>
          <tr v-for="(item, index) in services" :key="index" class="cursor-pointer  hover:bg-base-300"
            @click="onEdit(index, item)">
            <td>
              {{ item?.ref }}
            </td>
            <td>
              {{ item?.servicio_nombre }}
            </td>
            <td>
              {{ item?.cantidad }}
            </td>
            <td>
              {{ item?.precio }}
            </td>
            <td>
              <div class="flex gap-1">
                <Button @click="onEdit(index, item)" icon="pi pi-pencil text-primary" raised text size="small"
                  class="h-9 " rounded aria-label="Filter" />
                <Button @click.stop @click="onRemove(index)" icon="pi pi-trash text-error" raised text size="small"
                  class="h-9" rounded aria-label="Filter" />
              </div>
            </td>
          </tr>
        </tbody>
      </Table>

    </VirtualScrollForm>
  </div>
</template>
<script setup lang="ts">
import {
  Center,
  DropwdownSelect,
  LabelError,
  LabelInput,
  Row,
  Table,
  TextInput,
  THead,
  VirtualScrollForm
} from "@/components";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import * as Yup from "yup";
import { useInputsEvents } from "@/hooks/useInputsEvents";
import { ref, toRefs } from "vue";
import Button from 'primevue/button';
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "@/utils/debounce.js";
import { usePersonalStore } from "@/store/personal";
import { useServicioStore } from '../../../../../store/servicio';

const { listarServicio } = useServicioStore();
const { onFocusInput } = useInputsEvents()
const { Servicios } = toRefs(useServicioStore())

const form = defineForm({
  ref: field<string | null>("", Yup.string()
    //.transform((value, originalValue) => (originalValue.trim()))
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
  servicio: field<string>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
  cantidad: field<string | null>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
  precio: field<string>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
    servicio_nombre: field<string>("", Yup.string()
    .required("es requerido")
    .max(250, "Máximo 250")
    .nullable()),
});
const isSubmit = ref<boolean>(false)
const isEdit = ref<boolean>(false)
const indexSelected = ref<number>(0)
const searchPerson = ref<string>('')
const services = ref<any[]>([])
const onSubmit = () => {
  if (!isSubmit.value) {
    isSubmit.value = true;
  }


  if (services.value.length == 0) {
    notify({
      title: "Agregue a la lista Detalle Servicio",
      type: "warn"
    })
  }

  if (!isValidForm(form)) {
    setTimeout(() => {
      onValidateFocus()
    }, 300)
  }

};
const onValidateFocus = () => {
  if (form.ref.$error) {
    return onFocusInput("registration.detail.ref");
  }
  if (form.servicio.$error) {
    return onFocusInput("registration.detail.servicio");
  }
  if (form.cantidad.$error) {
    return onFocusInput("registration.detail.cantidad");
  }
  if (form.precio.$error) {
    return onFocusInput("registration.detail.precio");
  }
};

const addBudget = () => {
  if (isValidForm(form)) {
    if (isEdit.value) {
      services.value[indexSelected.value] = toObject(form)
      isEdit.value = false
    } else {
      services.value.push(toObject(form))
    }
    cleanForm()
  }
}
const onRemove = (index: number) => {
  services.value.splice(index, 1)
  isEdit.value = false
  cleanForm()
}

const onEdit = (index: number, item) => {
  searchPerson.value = item.servicio_nombre
  indexSelected.value = index
  isEdit.value = true
  setForm(item)

}


const setForm = (payload) => {
  searchPerson.value = payload?.usuario
  form.ref.$value = payload.ref
  form.servicio.$value = payload.servicio
  form.cantidad.$value = payload.cantidad
  form.precio.$value = payload?.precio
  form.servicio_nombre.$value = payload.servicio_nombre
}

const cleanForm = () => {
  form.ref.$value = ""
  form.servicio.$value =  ""
  form.cantidad.$value =  ""
  form.precio.$value =  ""
  form.servicio_nombre.$value = ''
  searchPerson.value = ""
}

const onCancel = () => {
  isEdit.value = false
  cleanForm()
}

const onSelectedPersonal = (e) => {
  searchPerson.value = e?.s_nombre
  form.servicio.$value = e?.s_codigo
  form.servicio_nombre.$value = e?.s_nombre
 
}

const onClearPerson = () => {
  form.servicio.$value = ''
  searchPerson.value =  ''
  form.servicio_nombre.$value = ''
}

const filterUbigeos = debounce(() => {
  return listarServicio(searchPerson.value);
}, 500);


defineExpose({ onValidateFocus, onSubmit, form: services.value })

</script>

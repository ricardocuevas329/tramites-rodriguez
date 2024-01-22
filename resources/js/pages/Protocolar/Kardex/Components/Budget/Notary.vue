<template>
  <div>

    <VirtualScrollForm>
      <br>
      <Row>
        <LabelInput>Descripción</LabelInput>
        <TextArea
            id="kardex.notary.descripcion"
            v-model.trim="form.descripcion.$value"
            :validate-error="isSubmit"
            :error-message="form.descripcion.$error?.message"
            :showLabel="false"
            @keyup.enter="onFocusInput('kardex.notary.cantidad')"
        />
      </Row>
      <Row>
        <LabelInput>Cantidad</LabelInput>
        <TextInputNumber
            id="kardex.notary.cantidad"
            v-model="form.cantidad.$value"
            :validate-error="isSubmit"
            :error-message="form.cantidad.$error?.message"
            @keyup.enter="onFocusInput('kardex.notary.precio')"
            :showLabel="false"/>
      </Row>
      <Row>
        <LabelInput>Precio</LabelInput>
        <TextInputNumber
            id="kardex.notary.precio"
            v-model="form.precio.$value"
            :validate-error="isSubmit"
            :error-message="form.precio.$error?.message"
            :showLabel="false"/>
      </Row>
    </VirtualScrollForm>
    <Center>
      <div v-if="isValidForm(form)">
        <Button @click="addBudget" :label="isEdit ? 'Actualizar' : 'Agregar' +'Presupuesto'"
                :icon="isEdit? 'pi   pi-save ' : 'pi   pi-plus ' " raised text size="small"/>
      </div>
      <Button v-if="isEdit" @click="onCancel()" class=" bg-primary" label="Cancelar" icon="pi pi-times " raised text
              size="small"/>
    </Center>

    <VirtualScrollForm v-if="notaries.length" showScrollX height="150px">
      <Table>
        <THead>
        <tr>
          <td>
            Descripcion
          </td>
          <td>
            Cantidad
          </td>
          <td>
            Precio
          </td>
          <td>
            Monto
          </td>
          <td>
            Acciones
          </td>
        </tr>
        </THead>
        <tbody>
        <tr v-for="(item, index) in notaries" :key="index"
            class="cursor-pointer  hover:bg-base-300" @click="onEdit(index, item)">
          <td>
            {{ item?.descripcion }}
          </td>
          <td>
            {{ item?.cantidad }}
          </td>
          <td>
            {{ item?.precio }}
          </td>
          <td>
            {{ item?.cantidad * item?.precio }}
          </td>
          <td>
            <div class="flex gap-1">
              <Button @click="onEdit(index, item)" icon="pi pi-pencil text-primary" raised text size="small"
                      class="h-9 " rounded aria-label="Filter"/>
              <Button @click.stop @click="onRemove(index)" icon="pi pi-trash text-error" raised text size="small"
                      class="h-9" rounded aria-label="Filter"/>
            </div>
          </td>
        </tr>
        </tbody>
      </Table>
      <span class="mx-2 badge badge-xs badge-outline p-2"> Total Notarial: {{ total }} </span>
    </VirtualScrollForm>
  </div>
</template>
<script setup lang="ts">
import {Center, LabelInput, Row, Table, TextArea, TextInputNumber, THead, VirtualScrollForm} from "@/components";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as Yup from "yup";
import {validateMaxDigits} from "@/utils/Regexs";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import {computed, ref} from "vue";
import Button from 'primevue/button';
import {notify} from "@kyvg/vue3-notification";

const {onFocusInput} = useInputsEvents()
const form = defineForm({
  descripcion: field<string | null>("", Yup.string()
      //.transform((value, originalValue) => (originalValue.trim()))
      .required("es requerido")
      .max(250, "Máximo 250")
      .nullable()),
  cantidad: field<number | null>(
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
  precio: field<number | null>(
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


});
const isSubmit = ref<boolean>(false)
const isEdit = ref<boolean>(false)
const indexSelected = ref<number>(0)
const notaries = ref<any[]>([])
const onSubmit = () => {
  if (!isSubmit.value) {
    isSubmit.value = true;
  }


  if (notaries.value.length == 0) {
    notify({
      title: "Agregue a la lista de presupuesto Notarial",
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
  if (form.descripcion.$error) {
    return onFocusInput("kardex.notary.descripcion");
  }
  if (form.cantidad.$error) {
    return onFocusInput("kardex.notary.cantidad");
  }
  if (form.precio.$error) {
    return onFocusInput("kardex.notary.precio");
  }
};

const addBudget = () => {
  if (isValidForm(form)) {
    if (isEdit.value) {
      notaries.value[indexSelected.value] = toObject(form)
      isEdit.value = false
    } else {
      notaries.value.push(toObject(form))
    }
    cleanForm()
  }
}
const onRemove = (index: number) => {
  notaries.value.splice(index, 1)
  isEdit.value = false
  cleanForm()
}

const onEdit = (index: number, item) => {
  indexSelected.value = index
  isEdit.value = true
  setForm(item)

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

const total = computed(() => {
  if (notaries.value.length) {
    return notaries.value.reduce((total, producto) => {
      const precio = producto.precio ?? '0';
      const cantidad = producto.cantidad;
      return total + (parseFloat(precio) * cantidad);
    }, 0);
  }
  return 0
})

defineExpose({onValidateFocus, onSubmit, notaries: notaries.value,  total: total})

</script>

<template>
  <div>

    <VirtualScrollForm>
      <br>
      <Row>
        <LabelInput>Descripción</LabelInput>
        <TextArea
            id="kardex.history.descripcion"
            v-model.trim="form.descripcion.$value"
            :validate-error="isSubmit"
            :error-message="form.descripcion.$error?.message"
            :showLabel="false"
        />
      </Row>
      <Row>
        <LabelInput>Usuario:</LabelInput>
        <DropwdownSelect
            class="w-full"
            placeholder="Filtrar Personal"
            label="nombre_compuesto"
            @keyup="filterUbigeos"
            id="kardex.history.usuario"
            @keyup.enter="onFocusInput('kardex.history.fecha')"
            @onSelecteValue="onSelectedPersonal"
            v-model="searchPerson"
            :data="Personales"
            @onClear="onClearPerson"
            :validate-error="isSubmit"
            :error-message="form.usuario.$error?.message"
        />
      </Row>
      <Row>
        <LabelInput>Fecha</LabelInput>
        <TextInput
            type="date"
            id="kardex.history.fecha"
            v-model="form.fecha.$value"
            :validate-error="isSubmit"
            :error-message="form.fecha.$error?.message"
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

    <VirtualScrollForm v-if="histories.length" showScrollX height="150px">
      <Table>
        <THead>
        <tr>
          <td>
            Historial de Trámite
          </td>
          <td>
            Usuario
          </td>
          <td>
            Fecha
          </td>
          <td>
            Acciones
          </td>
        </tr>
        </THead>
        <tbody>
        <tr v-for="(item, index) in histories" :key="index"
            class="cursor-pointer  hover:bg-base-300" @click="onEdit(index, item)">
          <td>
            {{ item?.descripcion }}
          </td>
          <td>
            {{ item?.usuario }}
          </td>
          <td>
            {{ item?.fecha }}
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
  TextArea,
  TextInput,
  THead,
  VirtualScrollForm
} from "@/components";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as Yup from "yup";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import {ref, toRefs} from "vue";
import Button from 'primevue/button';
import {notify} from "@kyvg/vue3-notification";
import {debounce} from "@/utils/debounce.js";
import {usePersonalStore} from "@/store/personal";


const {onFocusInput} = useInputsEvents()
const {searchPersonal} = usePersonalStore()
const {Personales} = toRefs(usePersonalStore())

const form = defineForm({
  descripcion: field<string | null>("", Yup.string()
      //.transform((value, originalValue) => (originalValue.trim()))
      .required("es requerido")
      .max(250, "Máximo 250")
      .nullable()),
  usuario: field<string>("", Yup.string()
      .required("es requerido")
      .max(250, "Máximo 250")
      .nullable()),
  fecha: field<string | null>("", Yup.string()
      .required("es requerido")
      .max(250, "Máximo 250")
      .nullable()),
  cod_usuario: field<string>("", Yup.string()
      .required("es requerido")
      .max(250, "Máximo 250")
      .nullable()),

});
const isSubmit = ref<boolean>(false)
const isEdit = ref<boolean>(false)
const indexSelected = ref<number>(0)
const searchPerson = ref<string>('')
const histories = ref<any[]>([])
const onSubmit = () => {
  if (!isSubmit.value) {
    isSubmit.value = true;
  }


  if (histories.value.length == 0) {
    notify({
      title: "Agregue a la lista de Historial de Trámite",
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
    return onFocusInput("kardex.history.descripcion");
  }
  if (form.usuario.$error) {
    return onFocusInput("kardex.history.usuario");
  }
  if (form.fecha.$error) {
    return onFocusInput("kardex.history.fecha");
  }

};

const addBudget = () => {
  if (isValidForm(form)) {
    if (isEdit.value) {
      histories.value[indexSelected.value] = toObject(form)
      isEdit.value = false
    } else {
      histories.value.push(toObject(form))
    }
    cleanForm()
  }
}
const onRemove = (index: number) => {
  histories.value.splice(index, 1)
  isEdit.value = false
  cleanForm()
}

const onEdit = (index: number, item) => {
  indexSelected.value = index
  isEdit.value = true
  setForm(item)

}


const setForm = (payload) => {
  searchPerson.value = payload?.usuario
  form.descripcion.$value = payload.descripcion
  form.usuario.$value = payload.usuario
  form.fecha.$value = payload.fecha
  form.cod_usuario.$value = payload?.cod_usuario
}

const cleanForm = () => {
  form.descripcion.$value = ""
  form.usuario.$value = ""
  form.fecha.$value = null
  form.cod_usuario.$value = ""
  searchPerson.value = ""
}

const onCancel = () => {
  isEdit.value = false
  cleanForm()
}

const onSelectedPersonal = (e) => {
  searchPerson.value = e?.nombre_compuesto
  form.usuario.$value = e?.nombre_compuesto
  form.cod_usuario.$value = e?.s_codigo
}

const onClearPerson = () => {
  form.usuario.$value = ''
  form.cod_usuario.$value = ''
}

const filterUbigeos = debounce(() => {
  return searchPersonal(searchPerson.value);
}, 500);


defineExpose({onValidateFocus, onSubmit, histories: histories.value})

</script>

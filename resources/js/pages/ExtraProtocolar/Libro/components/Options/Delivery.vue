<template>
  <Modal :id="idModalDelivery">
    <button @click="useCloseModal()" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
    <h3 class="mx-2 font-bold text-lg">Entrega de Libros</h3>
    <div class="mt-4">
        <div
            class="grid grid-cols-1 md:grid-cols-2 "
        >
        <InputSelect
            :items="TipoDocumentos"
            label="Tipo Documento"
            v-model="form.id_tipo_documento.$value"
            label-data="s_abrev"
            value-data="s_codigo"


        />

        <Row>
            <TextInputNumber
                label="N° Documento"
                v-model="form.dni.$value"
                :error-message="form.dni.$error?.message"
                @keyup.enter="onFindByDocument()"
            />
            <ToolTip text="Buscar">
                <button :disabled="isSubmitFindByDocument" @click="onFindByDocument()"
                        class="btn btn-sm btn-circle mt-6 ">
                    <MagnifyingGlassIcon/>
                </button>
            </ToolTip>
        </Row>
      </div>


      <div v-if="personFound" class="mx-4 mb-4">
        <h5 class="text-sm">
          Nombre:
          <span class="badge badge-xs">{{ personFound?.nombre_compuesto || personFound?.s_nombre }}</span>
        </h5>
      </div>

        <div
            class="grid grid-cols-1 md:grid-cols-2 "
        >

        <TextInput
            type="date"
            label="Fecha"
            v-model="form.fecha.$value"
            :error-message="form.fecha.$error?.message"
           :min="todayDefault"
        />

        <TextInput
            type="time"
            label="Hora"
            v-model="form.hora.$value"
            :error-message="form.hora.$error?.message"

        />

      </div>
      <Center>
        <BtnSave />
      </Center>
    </div>

  </Modal>

</template>
<script setup lang="ts">
import {useCloseModal} from "@/hooks/useUtils";
import {BtnSave, Center, InputSelect, Modal, Row, TextInput, TextInputNumber, ToolTip} from "@/components";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import {defineForm, field} from "vue-yup-form";
import * as Yup from "yup";
import {validateMaxDigits} from "@/utils/Regexs";
import {ref, toRefs} from "vue";
import type {Cliente, Empresa} from "@/models/types";
import {useTipoDocumentoStore} from "@/store/tipo-documento";
import {useClienteStore} from "@/store/cliente";
import {useDate} from "@/hooks/useDates";

const {TipoDocumentos} = toRefs(useTipoDocumentoStore());
const {findClienteByDocument} = useClienteStore()
const { todayDefault } = useDate()
const props = defineProps({
  idModalDelivery: {
    require: true,
    type: String,
  },
})

const personFound = ref<Cliente | Empresa>();
const isSubmitFindByDocument = ref<boolean>(false);

const form = defineForm({
  dni: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => Number.isNaN(value) ? null : value)

          .test("maxDigits", "Máximo de 15 dígitos.", value => {
            return validateMaxDigits(value, 15)
          }).nullable()
  ),
  id_tipo_documento: field<string>(
      '',
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  fecha: field<string>(
      '',
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  hora: field<string>(
      '',
      Yup.string()
          .required("es requerido")
          .nullable()
  )
})

const onFindByDocument = async () => {
  let id_doc = form.id_tipo_documento.$value
  let num_doc = form.dni.$value
  if (id_doc && num_doc) {

    try {
      isSubmitFindByDocument.value = true
      const {status, Cliente, message} = await findClienteByDocument(id_doc, num_doc.toString())
      if (status) {
        personFound.value = Cliente
      }
    } catch (e) {
      //setClienteInfo({}, true)
    } finally {
      setTimeout(() => {
        isSubmitFindByDocument.value = false
      }, 1300)
    }
  }

}


</script>

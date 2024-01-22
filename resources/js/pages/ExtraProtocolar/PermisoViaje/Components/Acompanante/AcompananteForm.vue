<template>
  <div>
    <!-- AddCliente Form -->
    <Modal id="permiso_viaje_add_cliente_modal">
      <AddCliente :use-component="true" :redirect="false"/>
    </Modal>
    <Row>
      <span class="btn btn-sm">Lista de Acompañantes ({{acompanantesForm.length}}) </span>
      <BtnAdd
          class="self-center"
          @click="useOpenModal('permiso_viaje_add_cliente_modal')"
          icon
          text="Agregar Acompañante"
      />
    </Row>

    <DropwdownSelect
        id="permiso.viaje.filterClientes"
        placeholder="Buscar Acompañante"
        label="nombre_compuesto"
        label2="s_num_doc"
        label3="s_codigo"
        @keyup="filterClientes"
        @onSelecteValue="onAddClient"
        v-model="searchClient"
        :showValue="false"
        :data="Clientes"
        @keyup.enter="onFocusInput('permiso.viaje.s_formato')"
        class="w-full"
    />

    <ClientTableList
        @onDeleteParticipant="onDeleteParticipant"
        :acompanante="acompanantesForm"
        v-if="acompanantesForm?.length"
    />
  </div>
</template>
<script setup lang="ts">
import {useOpenModal} from "@/hooks/useUtils";
import {BtnAdd, DropwdownSelect, Modal, Row} from "@/components";
import {AddCliente, ClientTableList} from "@/pages/ExtraProtocolar/PermisoViaje/Components";
import {debounce} from "@/utils/debounce.js";
import {onMounted, type PropType, ref, toRefs} from "vue";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import type {Cliente, Participante, PermisoViaje} from "@/models/types";
import {useArrayUnique} from "@vueuse/core";
import {useClienteStore} from "@/store/cliente";
import {notify} from "@kyvg/vue3-notification";
import type {IParamsDeleteParticipant} from "@/pages/ExtraProtocolar/PermisoViaje/Interfaces/typevieaje.interface";
import {useParticipanteStore} from "@/store/participante";

const {onFocusInput} = useInputsEvents();
const props = defineProps({
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<PermisoViaje>,
  },
});

const {formValues} = props
const searchClient = ref<string>("");
const {searchCliente} = useClienteStore();
const {Clientes} = toRefs(useClienteStore());
const acompanantesForm = ref<Participante[]>([])
const {destroyParticipante} = useParticipanteStore();


const filterClientes = debounce(() => {
  return searchCliente(searchClient.value);
}, 500);

const onAddClient = (payload: Cliente) => {

  const result = useArrayUnique(
      acompanantesForm.value,
      (a, b) => a.cliente.s_codigo === b.cliente.s_codigo
  );
  searchClient.value = "";
  /*@ts-ignore*/
  acompanantesForm.value.push({
    i_condicion: 7,
    cliente: payload
  })
  acompanantesForm.value = result.value;
  formValues.acompanantes = acompanantesForm.value
  notify({
    title: "Acompañante Agregado Correctamente!",
    type: "successs"
  })
  onFocusInput("permiso.viaje.filterClientes");
};


const onDeleteParticipant = async(params: IParamsDeleteParticipant) => {
  const {index, participant} = params;
  if(!confirm("¿Estas Completamente seguro(a)?")) return
  acompanantesForm.value.splice(index, 1);
  if (participant?.i_codigo) {
    const {status} = await destroyParticipante(participant);
    if (!status) return;
  }
};


onMounted(() => {
  acompanantesForm.value = formValues.acompanantes
})
</script>

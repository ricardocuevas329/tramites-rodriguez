<template>
  <div class="w-full p-4 bg-base-100 rounded-lg shadow">
    <div class="pb-2">
      <h3><strong>Datos de los destinatarios</strong></h3>
    </div>
      <TextInput
        id="carta.destinatario_nombre"
        label="Nombres/Razón social"
        v-model="form.destinatario_nombre"
      />
    <div class="grid grid-cols-1 md:grid-cols-2  ">
      <DropwdownSelect
        id="carta.searchDitritos"
        placeholder="Filtrar ubicación"
        label="s_colum2"
        @keyup="filterDistritos"
        @onSelecteValue="onSelecteDistrito"
        v-model="searchDitritos"
        :data="DetalleRango"
        @keyup.enter="onFocusInput('s_direccion')"
      />
      <TextInput
        id="carta.destinatario_direccion"
        label="Dirección envío"
        v-model="form.destinatario_direccion"
      />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
      <TextInput
        id="carta.distrito_precio"
        label="Precio S/"
        v-model="form.distrito_precio"
        readonly
      />
      <div class="md:mt-4">
        <Center>
          <button @click.prevent="onAdd" class=" btn btn-success  btn-wide text-white btn-sm">
            <EmailFastOutline />
            <span>Agregar</span>
          </button>
        </Center>
      </div>
    </div>
    <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-2">
      <Table>
        <THead>
          <th scope="col" class="">Destinatario</th>
          <th scope="col" class="">Distrito - Destino</th>
          <th scope="col" class="">Total</th>
          <th>Quitar</th>
        </THead>
        <tbody>
          <tr
            v-for="(item, index) in destinatarios"
            :key="index"
            class="cursor-pointer hover:bg-base-300"
          >
            <td class="">{{ item.nombre }}</td>
            <td class="">{{ item.ubicacion + " - " + item.direccion }}</td>
            <td class="">{{ item.precio }}</td>
            <td class=" actions">
              <button
                class="btn btn-circle btn-xs btn-error text-white"
                @click="onDelete(index)"
              >
                <ToolTip text="Remover">
                  <DeleteIcon />
                </ToolTip>
              </button>
            </td>
          </tr>
        </tbody>
      </Table>
    </div>
    <div class="flex justify-center pt-4">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-2">
        <button
          class="btn btn-outline.btn-secondary"
          @click="tabCartasRef.selectedTab = 2"
        >
          <ArrowLeftBold />
          Anterior
        </button>
        <button class="btn btn-success text-white" @click="tabCartasRef.selectedTab = 4">
           Siguiente
          <ArrowRightBold />
        </button>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import {onMounted, type PropType, ref, toRefs} from "vue";
import {DropwdownSelect, Table, TextInput, THead, ToolTip, Center } from "../../../../../components";
import {debounce} from "../../../../../utils/debounce.js";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import ArrowRightBold from "vue-material-design-icons/ArrowRightBold.vue";
import ArrowLeftBold from "vue-material-design-icons/ArrowLeftBold.vue";
import EmailFastOutline from "vue-material-design-icons/EmailFastOutline.vue";

import type {DetalleRango} from "@/models/types";
import {useCartaStore} from "../../../../../store/carta";
import {useInputsEvents} from "../../../../../hooks/useInputsEvents";
import type {IDestinatario} from "../../Interfaces/destinatario.interface";
import type {ICartaFormStore} from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";
import type {IReceiverForm} from "@/pages/ExtraProtocolar/Carta/Interfaces/receiver.interface";

const {searchDistrito} = useCartaStore();
const {onFocusInput} = useInputsEvents();

const {DetalleRango} = toRefs(useCartaStore());
const searchDitritos = ref<string>("");
const destinatarios = ref<IDestinatario[]>([]);


const form = ref<IReceiverForm>({
  destinatario_direccion: '',
  destinatario_nombre: '',
  distrito_codigo: '',
  distrito_nombre: '',
  distrito_precio: ''
})


const props = defineProps({
  formValues: {
    default: {},
    require: true,
    type: Object as PropType<ICartaFormStore>,
  },
  tabCartasRef: {
    require: false,
    type: Object as PropType<any>,
  }
});

const emit = defineEmits(["onSubmit"]);
const {formValues} = toRefs(props);


const filterDistritos = debounce(() => {
  return searchDistrito(searchDitritos.value);
}, 500);

const onSelecteDistrito = (payload: DetalleRango) => {
  form.value.distrito_nombre = payload.s_colum2;
  form.value.distrito_codigo = payload.s_codigo;
  form.value.distrito_precio = payload.de_precio?.toString() ?? '';
};

const onAdd = () => {
  onValidateFocus()
  if (form.value.distrito_nombre) {
    destinatarios.value.push({
      nombre: form.value.destinatario_nombre ?? '',
      ubicacion: form.value.distrito_nombre ?? '',
      direccion: form.value.destinatario_direccion ?? '',
      precio: Number.parseFloat(form.value.distrito_precio ?? ''),
    });
    formValues.value.destinatarios = destinatarios.value
    cleanForm();
  }
};

const onDelete = (index: number) => {
  destinatarios.value.splice(index, 1)
  formValues.value.destinatarios = destinatarios.value
}

const cleanForm = () => {
  searchDitritos.value = "";
  form.value.distrito_nombre = "";
  form.value.distrito_codigo = "";
  form.value.distrito_precio = null;
  form.value.destinatario_nombre = "";
  form.value.destinatario_direccion = "";
};

const onValidateFocus = () => {
  if (!form.value.destinatario_nombre) {
    return onFocusInput("carta.destinatario_nombre");
  }
  if (!searchDitritos.value) {
    return onFocusInput("carta.searchDitritos");
  }
  if (!form.value.destinatario_direccion) {
    return onFocusInput("carta.destinatario_direccion");
  }
  if (!searchDitritos.value) {
    return onFocusInput("carta.searchDitritos");
  }
}
onMounted(() => {
});

defineExpose({destinatarios});
</script>

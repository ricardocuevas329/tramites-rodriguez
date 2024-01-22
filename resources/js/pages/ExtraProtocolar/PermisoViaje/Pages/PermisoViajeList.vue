<template>
    <ContainerTable v-if="!isLoading">
    <Table>
      <THead>
        <tr>
          <th scope="col" class="px-6">Acciones</th>
          <th scope="col" class="">Fecha Acta</th>
          <th scope="col" class="">Numero</th>
          <th scope="col" class="">Tipo de Viaje</th>
          <th scope="col" class="">Participantes</th>
          <th scope="col" class="">Fecha de Ida y Vuelta</th>
          <th scope="col" class="">Transporte</th>
          <th scope="col" class="">Destino</th>
          <th scope="col" class="">Estado</th>
        </tr>
      </THead>
      <tbody>
        <tr v-for="(item, index) in PermisoViajes" :key="index" @click="goDetail(item)"
          class="cursor-pointer  hover:bg-base-300">
          <td class="relative actions flex ">

            <div @click.stop class="dropdown  dropdown-right   dropdown-content  ">

              <label tabindex="0" class="  m-1">
                <button class="btn btn-sm btn-circle bg-base-200">
                  <DotsVertical />
                </button>
              </label>

              <ul  class="static  dropdown-content z-[50] -mt-4 menu p-2  bg-base-100 rounded-box ">
                <div class="flex">
                  <button @click="goDetail(item)" :disabled="isDownloadDocument" class="btn btn-sm btn-circle btn-ghost text-primary">
                    <ToolTip position="right" text="Editar">
                      <EditIcon />
                    </ToolTip>
                  </button>
                  <button @click="onGenerateExcel(item)" :disabled="isDownloadDocument"
                          class="btn btn-sm btn-circle btn-ghost text-green-400">
                    <ToolTip position="right" text="Exportar a Excel" >
                      <FileExcel/>
                    </ToolTip>
                  </button>
                  <button @click="onGeneratePDF(item)" :disabled="isDownloadDocument"
                          class="btn btn-sm btn-circle btn-ghost text-red-400">
                    <ToolTip position="right" text="Exportar a PDF" >
                      <FilePdfBox />
                    </ToolTip>
                  </button>
                </div>
              </ul>

            </div>

            <button @click.stop @click="onDownloadDocument(item)" :disabled="isDownloadDocument"
                    class="btn btn-sm btn-circle bg-base-200">
              <ToolTip position="right"  text="Generar Documento">
                <FileDocument />
              </ToolTip>
            </button>


            <button @click.stop @click="changeStatus(item)" type="button"
                    class="hidden text-red-500 dark:bg-btn-dark font-medium rounded-lg text-sm px-1 py-1 text-center mr-2 mb-2">
              <ToolTip v-if="item.i_estado" text="Desactivar">
                <DeleteIcon />
              </ToolTip>
              <ToolTip v-else text="Activar">
                <CloseIcon />
              </ToolTip>
            </button>
          </td>
          <td class=" ">
            {{ item?.d_fecha_reg }}
          </td>
          <td class=" ">
            {{ item?.i_numero }}
          </td>
          <td class=" ">
            {{ item?.tipo_viaje }}
          </td>
          <td class=" ">
            <span v-if="item.participantes?.length" v-for="(p, key) in item?.participantes" :key="key">
              {{ p?.participa_como }}: {{ p.cliente?.nombre_compuesto }} <br>
            </span>

          </td>
          <td class="">
            {{formatDateDefault(item?.d_fecha_sal, false)}} - {{ formatDateDefault(item?.d_fecha_ret, false) }}
          </td>
          <td class=" ">
            {{ item?.tipo_transporte }}
          </td>
          <td class=" ">
            {{ item?.s_ruta }}
          </td>
            <td class=" ">
               <span class="badge badge-outline badge-sm badge-success">Finalizado</span>
            </td>
        </tr>
      </tbody>
    </Table>
    <ListEmpty v-if="PermisoViajes?.length == 0" />
  </ContainerTable>
  <Skeleton v-if="isLoading" :tipo="2" />
  <Paginate v-if="PermisoViajes?.length && !isLoading" :pagination="pagination" @paginate="listarPermisoViaje()" />
</template>
<script setup lang="ts">
import { toRefs, ref } from "vue";
import { ContainerTable, ListEmpty, Paginate, Skeleton, Table, THead, ToolTip } from "@/components";
import type { PermisoViaje } from "@/models/types";
import { notify } from "@kyvg/vue3-notification";
import { usePermisoViajeStore } from "@/store/permiso-viaje";
import { configExtraProtocolar } from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import { useRouter } from "vue-router";
import { useDate } from "@/hooks/useDates";
import CloseIcon from "vue-material-design-icons/Close.vue";
import FileDocument from "vue-material-design-icons/FileDocument.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import DotsVertical from "vue-material-design-icons/DotsVertical.vue";
import FileExcel from "vue-material-design-icons/FileExcel.vue";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import Checkbox from 'primevue/checkbox';
import Button from 'primevue/Button';


import AutoComplete from 'primevue/autocomplete';
import Dropdown from 'primevue/Dropdown';
const { PermisoViajes, pagination, isLoading } = toRefs(usePermisoViajeStore());
const { listarPermisoViaje, disabledPermisoViaje, enabledPermisoViaje, generateDocument, generateExcel, generatePDF } = usePermisoViajeStore();
const isDownloadDocument = ref<boolean>(false);
const router = useRouter();
const { formatDateDefault } = useDate()

const onDownloadDocument = (item: PermisoViaje) => {
  isDownloadDocument.value = true
  try {
    generateDocument(item)
  } catch (error) {
    notify({
      title: "Ups!",
      text: "Ocurrio un error, Intentelo Nuevamente!",
      type: "warn",

    });
    isDownloadDocument.value = false
  } finally {
    setTimeout(() => {
      isDownloadDocument.value = false
    }, 1500);
  }
}

const onGenerateExcel = (item: PermisoViaje) => {
  if (isDownloadDocument.value) return
  isDownloadDocument.value = true
  try {
    generateExcel(item)
  } catch (error) {
    notify({
      title: "Ups!",
      text: "Ocurrio un error, Intentelo Nuevamente!",
      type: "warn",
    });
    isDownloadDocument.value = false
  } finally {
    setTimeout(() => {
      isDownloadDocument.value = false
    }, 1700);
  }
}

const onGeneratePDF = (item: PermisoViaje) => {
  if (isDownloadDocument.value) return
  isDownloadDocument.value = true
  try {
    generatePDF(item)
  } catch (error) {
    notify({
      title: "Ups!",
      text: "Ocurrio un error, Intentelo Nuevamente!",
      type: "warn",
    });
    isDownloadDocument.value = false
  } finally {
    setTimeout(() => {
      isDownloadDocument.value = false
    }, 1700);
  }
}

const changeStatus = async (item: PermisoViaje) => {
  if (!confirm("¿Estas completamente Seguro(a)?")) {
    return;
  }

  const { status, message } = item.i_estado
    ? await disabledPermisoViaje(item)
    : await enabledPermisoViaje(item);

  if (status) {
    notify({
      title: "Exito",
      text: message,
    });
    await listarPermisoViaje();
  }
};

const goDetail = (item: PermisoViaje) => {
  if (isDownloadDocument.value) return
  router.push({
    name: configExtraProtocolar._PERMISO_VIAJE_.update.name,
    params: {
      id: item.i_codigo,
    },
  });
};
</script>

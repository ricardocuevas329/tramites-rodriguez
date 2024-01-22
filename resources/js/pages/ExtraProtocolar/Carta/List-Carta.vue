<template>
  <Container>
    <Card>
      <Title
      >Cartas <span v-if="pagination?.total">({{ pagination?.total }})</span>
      </Title>
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 my-4">
        <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
          <TextInputSearch
              @input="filterTipoDocumento()"
              @keyup="filterTipoDocumento()"
              v-model="search"
              placeholder="Buscar..."
          />
        </div>
        <div class="col-span-1">
          <Options text="Opciones">
            <div class="lg:mx-1 lg:px-1 mx-2 px-3 py-1">
              <MenuItem v-slot="{ active }">
                <Item @click="filterData" :active="active">
                  <RefreshIcon
                      :active="active"
                      class="mr-2 h-5 w-5 text-violet-400"
                      aria-hidden="true"
                  />
                  Refrescar
                </Item>
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <Item :active="active">
                  <DownloadIcon
                      :active="active"
                      class="mr-2 h-5 w-5 text-violet-400"
                      aria-hidden="true"
                  />
                  Exportar
                </Item>
              </MenuItem>
              <MenuItem v-slot="{ active }">
                <Item :active="active">
                  <Printer
                      :active="active"
                      class="mr-2 h-5 w-5 text-violet-400"
                      aria-hidden="true"
                  />
                  Imprimir
                </Item>
              </MenuItem>
            </div>
          </Options>
        </div>
        <div class="md:text-end lg:text-right">
          <BtnAdd text="Nuevo" :path="configExtraProtocolar._CARTA_.add.path"/>
        </div>
      </div>

      <ContainerTable v-if="!isLoading">
        <Table>
          <THead>
          <tr>
            <th scope="col" class="actions"></th>
            <th scope="col">Delivery</th>
            <th scope="col" class=" ">Nº Carta</th>
            <th scope="col">Fecha Ingreso</th>
            <th scope="col">Motorizado</th>
            <th scope="col">Remitente</th>
            <th scope="col">Referente</th>
            <th scope="col">Destinatario</th>
            <th scope="col">Distrito</th>
            <th scope="col" class=" overflow-hidden">Direccion</th>
            <th scope="col">Estado</th>
            <th scope="col">Bajo Puerta</th>
            <th scope="col">Situacion</th>
          </tr>
          </THead>
          <tbody>
          <tr v-for="(item, key) in Cartas" :key="key">
            <td class=" text-xs actions">

              <div @click.stop class="dropdown  dropdown-right   dropdown-content  ">
                <label tabindex="0" class="  m-1">
                  <button class="btn btn-sm btn-circle bg-base-200">
                    <DotsVertical/>
                  </button>
                </label>
                <ul class="static  dropdown-content z-[50] -mt-4 menu p-2  bg-base-100 rounded-box ">
                  <div class="flex">
                    <button
                        :disabled="isDownloadDocument"
                        type="button"
                        class="btn btn-sm btn-circle bg-base-200"
                        @click="onGenerateExcel(item)"
                    >
                      <ToolTip position="right" text="Generar expediente">
                        <FileExcel class="text-blue-600"/>
                      </ToolTip>
                    </button>
                    <button
                        :disabled="isDownloadDocument"
                        type="button"
                        class="btn btn-sm btn-circle bg-base-200"
                        @click="verObservacion(item)"
                    >
                      <ToolTip position="right" text="Ver Observación">
                        <CommentText class="text-blue-600"/>
                      </ToolTip>
                    </button>
                    <button
                        @click.stop
                        :disabled="isDownloadDocument"
                        type="button"
                        class="btn btn-sm btn-circle bg-base-200"
                    >
                      <ToolTip position="right" text="Entregado">
                        <FileChartCheckOutline class="text-green-500"/>
                      </ToolTip>
                    </button>
                    <button
                        @click.stop
                        :disabled="isDownloadDocument"
                        type="button"
                        class="btn btn-sm btn-circle bg-base-200"
                        @click="onGenerateDocumentPDF(item)"
                    >
                      <ToolTip position="right" text="Generar Certificado">
                        <FileDocument class="text-gray-700"/>
                      </ToolTip>
                    </button>
                    <button
                        @click.stop
                        :disabled="isDownloadDocument"
                        type="button"
                        class="btn btn-sm btn-circle bg-base-200"
                    >
                      <ToolTip position="right" text="Pago">
                        <CashRegister/>
                      </ToolTip>
                    </button>
                    <button
                        @click.stop
                        :disabled="isDownloadDocument"
                        type="button"
                        class="btn btn-sm btn-circle bg-base-200"
                    >
                      <ToolTip position="right" text="Generar QR">
                        <Qrcode/>
                      </ToolTip>
                    </button>
                    <button
                        type="button"
                        class="btn btn-sm btn-circle bg-base-200"
                        @click="editar(item)"
                    >
                      <ToolTip position="right" text="Editar">
                        <EditIcon/>
                      </ToolTip>
                    </button>
                  </div>
                </ul>
              </div>
            </td>
            <td class="flex actions justify-center">
                <span
                    v-if="item.diligencia_carta?.s_num_carta"
                    @click="verDiligencia(item.diligencia_carta)"
                    class="cursor-pointer hover:bg-base-300"
                >
                  <ToolTip position="right" text="VER DILIGENCIA">
                    <Motorbike class="text-green-600"/>
                  </ToolTip>
                </span>
              <span
                  v-else
                  @click="programar(item)"
                  class="cursor-pointer hover:bg-base-300"
              >
                  <ToolTip position="right" text="PROGRAMAR CARTA">
                    <Motorbike class="text-yellow-300"/>
                  </ToolTip>
                </span>
            </td>
            <td>{{ item.s_numcarta }}</td>
            <td>
              {{ item.d_fecha && formatDate(item.d_fecha?.toString()) + " " + item.s_hora }}
            </td>
            <td>{{ item.diligencia_carta?.personal?.nombre_compuesto }}</td>
            <td>
                <span
                    v-if="item.remitente_cliente?.length"
                    v-for="(p, key) in item?.remitente_cliente"
                    :key="key"
                >
                  {{ p.nombre_compuesto }} <br/>
                </span>
              <span
                  v-if="item.remitente_empresa.length"
                  v-for="(p, key) in item?.remitente_empresa"
                  :key="key"
              >
                  {{ p.s_nombre }} <br/>
                </span>
            </td>
            <td>
                <span
                    v-if="item.referente_cliente?.length"
                    v-for="(p, key) in item?.referente_cliente"
                    :key="key"
                >
                  {{ p.nombre_compuesto }} <br/>
                </span>
              <span
                  v-if="item.remitente_empresa.length"
                  v-for="(p, key) in item?.remitente_empresa"
                  :key="key"
              >
                  {{ p.s_nombre }} <br/>
                </span>
            </td>
            <td>{{ item.s_destinatario }}</td>
            <td>{{ item.s_localidad }}</td>
            <td>
              {{ item.s_direccioncarta }}
            </td>
            <td>{{ item.i_delivery == 1 ? "SI" : "NO" }}</td>
            <td>{{ item.i_bajopuerta == 1 ? "SI" : "NO" }}</td>
            <td>
                <span
                    v-if="item?.situacion"
                    class="badge badge-xs badge-outline p-2"
                    :class="item.situacion.s_nombre === 'DILIGENCIADO' ? 'badge-success' : 'badge-ghost'"
                >
                  {{ item.situacion.s_nombre }}
                </span>
            </td>

          </tr>
          </tbody>
        </Table>

        <ListEmpty v-if="Cartas?.length == 0"/>
      </ContainerTable>
      <Skeleton v-if="isLoading" :tipo="2"/>
      <Paginate
          v-if="Cartas?.length && !isLoading"
          :pagination="pagination"
          @paginate="listarCarta()"
      />
    </Card>

    <RouterView/>
  </Container>
</template>

<script setup lang="ts">
import {useRouter} from "vue-router";
import {defineAsyncComponent, onMounted, ref, toRefs} from "vue";
import {
  BtnAdd,
  Card,
  Container,
  ContainerTable,
  Item,
  ListEmpty,
  Options,
  Paginate,
  Skeleton,
  Table,
  TextInputSearch,
  THead,
  Title,
  ToolTip
} from "../../../components";
import {notify} from "@kyvg/vue3-notification";
import {debounce} from "../../../utils/debounce.js";
import {MenuItem} from "@headlessui/vue";

import {configExtraProtocolar} from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import type {Carta, DiligenciaCarta} from "@/models/types";
import {useTipoDocumentoStore} from "../../../store/tipo-documento";
import {useZonaRegistralStore} from "../../../store/zona-registral";
import {useCondicionStore} from "../../../store/condicion";
import {useNacionalidadStore} from "../../../store/nacionalidad";
import {useCartaStore} from "../../../store/carta";

const RefreshIcon = defineAsyncComponent(() => import("vue-material-design-icons/Refresh.vue"))
const EditIcon = defineAsyncComponent(() => import("vue-material-design-icons/Pencil.vue"))
const DownloadIcon = defineAsyncComponent(() => import("vue-material-design-icons/Download.vue"))
const FileDocument = defineAsyncComponent(() => import("vue-material-design-icons/FileDocument.vue"))
const FileExcel = defineAsyncComponent(() => import("vue-material-design-icons/FileExcel.vue"))
const CommentText = defineAsyncComponent(() => import("vue-material-design-icons/CommentText.vue"))
const FileChartCheckOutline = defineAsyncComponent(() => import("vue-material-design-icons/FileChartCheckOutline.vue"))
const CashRegister = defineAsyncComponent(() => import("vue-material-design-icons/CashRegister.vue"))
const Qrcode = defineAsyncComponent(() => import("vue-material-design-icons/Qrcode.vue"))
const Motorbike = defineAsyncComponent(() => import("vue-material-design-icons/Motorbike.vue"))
const Printer = defineAsyncComponent(() =>
    import("vue-material-design-icons/Printer.vue")
);

const DotsVertical = defineAsyncComponent(() =>
    import("vue-material-design-icons/DotsVertical.vue")
);


const {Cartas, pagination, isLoading, search} = toRefs(useCartaStore());
const {listarCarta, generateExcel, cleanPagination, generatePDF} = useCartaStore();
const {listarActivos} = useTipoDocumentoStore();
const {listarZonaRegistral} = useZonaRegistralStore();
const {listarCondicion} = useCondicionStore();
const {listarNacionalidad} = useNacionalidadStore();

const router = useRouter();
const isDownloadDocument = ref<boolean>(false);


const verDiligencia = (item: DiligenciaCarta) => {
  if (isDownloadDocument.value) return;
  router.push({
    name: configExtraProtocolar._CARTA_.diligencia.name,
    params: {
      id: item.s_num_carta,
    },
  });
};

const programar = (item: Carta) => {
  //if (isDownloadDocument.value) return;
  router.push({
    name: configExtraProtocolar._CARTA_.programacion.name,
    params: {
      id: item.s_carta,
    },
  });
};

const verObservacion = (item: Carta) => {
  if (isDownloadDocument.value) return;
  router.push({
    name: configExtraProtocolar._CARTA_.observation.name,
    params: {
      id: item.s_carta,
    },
  });
};

const editar = (item: Carta) => {
  if (isDownloadDocument.value) return;
  router.push({
    name: configExtraProtocolar._CARTA_.update.name,
    params: {
      id: item.s_carta,
    },
  });
};

const formatDate = (dateString: string) => {
  const date = new Date(dateString);
  const day = String(date.getDate()).padStart(2, "0");
  const month = String(date.getMonth() + 1).padStart(2, "0");
  const year = date.getFullYear();
  return `${day}-${month}-${year}`;
};

const filterTipoDocumento = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  cleanPagination();
  await listarCarta();
};

const onGenerateExcel = (item: Carta) => {
  if (isDownloadDocument.value) return;
  isDownloadDocument.value = true;
  try {
    generateExcel(item);
  } catch (error) {
    notify({
      title: "Ups!",
      text: "Ocurrio un error, Intentelo Nuevamente!",
      type: "warn",
    });
    isDownloadDocument.value = false;
  } finally {
    setTimeout(() => {
      isDownloadDocument.value = false;
    }, 1700);
  }
};

const onGenerateDocumentPDF = (item: Carta) => {
  if (isDownloadDocument.value) return;
  isDownloadDocument.value = true;
  try {
    generatePDF(item);
  } catch (error) {
    notify({
      title: "Ups!",
      text: "Ocurrio un error, Intentelo Nuevamente!",
      type: "warn",
    });
    isDownloadDocument.value = false;
  } finally {
    setTimeout(() => {
      isDownloadDocument.value = false;
    }, 1700);
  }
};

onMounted(() => {
  if (!Cartas.value.length) {
    listarCarta();
  }

  listarActivos();
  listarZonaRegistral();
  listarCondicion();
  listarNacionalidad();

});
</script>

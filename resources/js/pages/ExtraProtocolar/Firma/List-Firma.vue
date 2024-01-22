<template>
  <div>
    <div class="grid grid-cols-1"
         :class="$route.name == configExtraProtocolar._FIRMA_.listar.name ? '' : 'md:grid-cols-4 lg:grid-cols-4'">
      <div class="col-span-2">
        <RouterView v-slot="{ Component}">
          <TransitionSlide>
            <component :is="Component"/>
          </TransitionSlide>
        </RouterView>
      </div>
      <div class="col-span-2 md:mx-1">
        <Card>
          <Title>Registro de Firmas <span v-if="pagination?.total">({{ pagination?.total }})</span></Title>

          <div
              class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4  gap-2 my-4"
          >
            <div
                class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
            >
              <TextInputSearch
                  @input="filter()"
                  @keyup="filter()"
                  v-model="search"
                  placeholder="Buscar..."
              />
            </div>
            <div class="col-span-1">
              <Options text="Opciones">
                <ul tabindex="0"
                    class="static  dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                  <li>
                    <a @click="filter()">
                      <RefreshIcon/>
                      Refrescar
                    </a>
                  </li>
                </ul>
              </Options>
            </div>
            <div class="md:text-end lg:text-right">

              <BtnAdd
                  text="Nuevo"
                  :path="configExtraProtocolar._FIRMA_.add.path"
              />
            </div>
          </div>

          <ContainerTable v-if="!isLoading">
            <Table>
              <THead>
              <tr>
                <th scope="col">Acciones</th>
                <th scope="col">Firma</th>
                <th scope="col">Datos</th>
                <th scope="col">Atendido</th>
                <th scope="col">Proceder</th>
                <th scope="col">Caducidad</th>
                <th scope="col">Registro</th>
              </tr>
              </THead>
              <tbody>
              <tr v-for="(item, index) in Firmas" :key="index" @click="onEdit(item)"
                  class="cursor-pointer  hover:bg-base-300"
                  :class="item.d_caducidad && item.d_caducidad <= todayDefault && ' bg-red-100 text-gray-700  dark:bg-base-200 '  ">
                <td class="relative flex actions ">

                  <div @click.stop class="dropdown  dropdown-right  dropdown-content  ">

                    <label tabindex="0" class="  ">
                      <button class="btn btn-sm btn-circle btn-ghost  ">
                        <DotsVertical/>
                      </button>
                    </label>

                    <ul tabindex="0"
                        class="static  dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                      <li @click="onEdit(item)">
                        <a>
                          <EditIcon/>
                          Editar

                        </a>
                      </li>

                    </ul>

                  </div>

                  <button @click.stop @click="onDownloadDocument(item)" :disabled="isDownloadDocument"
                          class="btn btn-sm btn-circle btn-ghost">
                    <ToolTip position="right" text="Generar Documento">
                      <FileDocument/>
                    </ToolTip>
                  </button>

                  <button @click.stop @click="onOpenUploadSignature(item)" :disabled="isDownloadDocument"
                          class="btn btn-sm btn-circle btn-ghost">
                    <ToolTip position="right" text="Buscar Firma">
                      <Camera/>
                    </ToolTip>
                  </button>
                </td>
                <td @click.stop>
                  <div v-if="item?.foto_firma" class="avatar" @click="onViewImage(item.foto_firma)">
                    <div class="w-16 rounded">
                      <img :src="item?.foto_firma"/>
                    </div>
                  </div>
                </td>
                <td>
                  {{ item?.cliente?.nombre_compuesto }}
                </td>
                <td>
                  {{ item?.atendido?.nombre_compuesto }}
                </td>

                <td>
                  {{ item?.s_proceder }}
                </td>
                <td>
                  {{ item?.d_caducidad }}
                </td>

                <td>
                  {{ item.d_fechaRegistro }}
                </td>

              </tr>
              </tbody>
            </Table>
            <ListEmpty v-if="Firmas?.length == 0"/>
          </ContainerTable>
          <Skeleton v-if="isLoading" :tipo="2"/>
          <Paginate v-if="Firmas?.length && !isLoading" :pagination="pagination"
                    @paginate="listarRegistroFirmas()"/>

          <div class=" grid grid-cols-2 grid-cols-2 md:grid-cols-2 gap-2 mt-2 ">
            <BtnSave @click="useOpenModal(idModalRepresentation)" :disabled="!route.params?.id"
                     class="btn btn-outline btn-xs btn-primary" text="REPRESENTACION">
              <template v-slot:icon>
                <BagPersonalTag/>
              </template>
            </BtnSave>
            <BtnSave :disabled="!route.params?.id" class="btn btn-outline btn-xs btn-success" text="Biometrico">
              <template v-slot:icon>
                <CashRegister/>
              </template>
            </BtnSave>
            <BtnSave :disabled="!route.params?.id" class="btn btn-xs btn-primary" text="Ver Reniec">
              <template v-slot:icon>
                <MagnifyingGlassIcon class="w-4"/>
              </template>
            </BtnSave>
            <BtnSave :disabled="!route.params?.id" class="btn btn-xs btn-secondary" text="Migraciones">
              <template v-slot:icon>
                <MagnifyingGlassIcon class="w-4"/>
              </template>
            </BtnSave>


          </div>

          <div class=" grid grid-cols-2 md:grid-cols-2 gap-2 mt-2 ">
            <BtnSave :disabled="!route.params?.id" class=" btn  btn-outline btn-xs btn-info" text="Vigencia">
              <template v-slot:icon>
                <Key class="w-4"/>
              </template>
            </BtnSave>

            <BtnSave :disabled="!route.params?.id" class="btn btn-outline btn-xs btn-secondary" text="Doc">
              <template v-slot:icon>
                <FileDocument class="w-4"/>
              </template>
            </BtnSave>
            <BtnSave @click="selected ? onDownloadDocument(selected) : null" :disabled="!route.params?.id"
                     class="btn btn-outline btn-xs btn-primary" text="Word">
              <template v-slot:icon>
                <FileWord class="w-4"/>
              </template>
            </BtnSave>
            <BtnSave :disabled="!route.params?.id" class=" btn btn-outline btn-xs btn-error" text="PDF/QR">
              <template v-slot:icon>
                <FilePdfBox class="w-4"/>
              </template>
            </BtnSave>


          </div>

        </Card>
      </div>
    </div>
    <UploadFirma :id_signature="id_signature" :idModal="idModalUploadFirma" :source="source"/>
    <Representation :signature="selected" :idModal="idModalRepresentation"/>
  </div>
</template>
<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
import {
  BtnAdd,
  BtnSave,
  Card,
  ContainerTable,
  ListEmpty,
  Options,
  Paginate,
  Skeleton,
  Table,
  TextInputSearch,
  THead,
  Title,
  ToolTip
} from "@/components";
import {debounce} from "../../../utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import CashRegister from "vue-material-design-icons/CashRegister.vue";
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import type {Firma} from "@/models/types";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import DotsVertical from "vue-material-design-icons/DotsVertical.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import FileDocument from "vue-material-design-icons/FileDocument.vue";
import BagPersonalTag from "vue-material-design-icons/BagPersonalTag.vue";
import Camera from "vue-material-design-icons/Camera.vue";

import Key from "vue-material-design-icons/Key.vue";
import FileWord from "vue-material-design-icons/FileWord.vue";
import {TransitionSlide} from "@morev/vue-transitions"
import {Representation, UploadFirma} from "./Components"

import {useFirmaStore} from "@/store/firma";
import {useRoute, useRouter} from "vue-router";
import {useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";
import {notify} from "@kyvg/vue3-notification";
import {useTipoDocumentoStore} from "@/store/tipo-documento";
import {useDate} from "@/hooks/useDates"

const {getDocumentClient, getDocumentCompany} = useTipoDocumentoStore()
const {cleanPagination, listarRegistroFirmas, generateDocument} = useFirmaStore()
const {Firmas, search, isLoading, pagination} = toRefs(useFirmaStore())
const idModalUploadFirma = useGenerateKeyRandom()
const idModalRepresentation = useGenerateKeyRandom()
const selected = ref<Firma>();
const router = useRouter()
const route = useRoute()
const id_signature = ref<string>('');
const source = ref<string>('');
const isDownloadDocument = ref<boolean>(false);
const {todayDefault} = useDate()

const filter = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  cleanPagination()
  await listarRegistroFirmas();
}

const onViewImage = (url: string) => {
  window.open(url)
}

const onEdit = async (item: Firma) => {
  selected.value = item
  await router.push({
    name: configExtraProtocolar._FIRMA_.update.name,
    params: {
      id: item.s_codigo,
    },
  });
}

const onDownloadDocument = async (item: Firma) => {
  if (isDownloadDocument.value) return
  isDownloadDocument.value = true
  try {
    await generateDocument(item)
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
const onOpenUploadSignature = (item: Firma) => {
  source.value = ''
  id_signature.value = item.s_codigo
  source.value = item.foto_firma
  useOpenModal(idModalUploadFirma)
}

onMounted(() => {
  listarRegistroFirmas();
  getDocumentClient()
  getDocumentCompany()
});
</script>

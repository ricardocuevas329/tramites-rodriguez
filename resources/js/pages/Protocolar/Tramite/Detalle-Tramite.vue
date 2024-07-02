<template>
  <Container>
    <Card v-if="isLoadingDetail">
      <Skeleton :tipo="2"/>
    </Card>
    <Card v-else>
      <div v-if="detailTramite?.id">
        <div class="flex items-center justify-between">
          <router-link to="/Tramite" class="btn btn-sm align-left">
            <i class="pi pi-arrow-circle-left text-lg cursor-pointer"></i>Mis Trámites
          </router-link>
          <a @click.native="recargarPagina" class="btn btn-sm align-center">
            Refrescar
          </a>
          <a role="button" class="btn btn-sm align-center">Trámite :
            {{ detailTramite?.detalle_kardex?.s_tipokardex }} -
            {{ detailTramite?.detalle_kardex?.num_kardex }}</a>
        </div>
        <div style="margin-top: 5px;"></div>
        <details class="collapse">
          <summary class="text-md font-medium bg-blue flex items-center">
                    <span class="margin-spam">
                        <button class="btn btn-circle btn-xs btn-ghost bg-blue">
                            <AccountGroupOutline/>
                        </button>
                    </span>
            <span style="vertical-align: text-bottom;" class="ml-2 text-md">PARTICIPANTES</span>
          </summary>
          <div class="collapse-content">
            <table class="table table-xs">
              <thead>
              <tr>
                <th>Nombres</th>
                <th>Firma</th>
                <th>Fecha</th>
              </tr>
              </thead>
              <tbody>
              <tr class="bg-base-200" v-for="(item, key) in participants" :key="key">
                <td>{{ item.compareciente?.nombre_compuesto }}</td>
                <td>
                                    <span class="badge badge-outline badge-md"
                                          :class="item.i_firma ? 'badge-success' : 'badge-error'">{{
                                        item.i_firma ? 'SI' : 'NO'
                                      }}</span>
                </td>
                <td>{{ item.d_fechfirma }}</td>
              </tr>
              </tbody>
            </table>
          </div>
        </details>
        <div style="margin-top: 5px;"></div>
        <details class="collapse">
          <summary class="text-md font-medium bg-blue flex items-center">
                    <span class="margin-spam">
                        <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                            <i class="pi pi-file-import text-lg bg-blue cursor-pointer"></i>
                        </button>
                    </span>
            <span style="vertical-align: text-bottom;" class="ml-2 text-md">DOCUMENTOS - COORPORATIVO</span>
          </summary>
          <div class="collapse-content">
            <DocumentFormDetalle :uploadFile="false" :documents="detailTramite?.files"/>
          </div>
        </details>
        <div style="margin-top: 5px;"></div>
        <details class="collapse">
          <summary class="text-md font-medium bg-blue flex items-center">
                    <span class="margin-spam">
                        <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                            <i class="pi pi-file-import text-lg bg-blue cursor-pointer"></i>
                        </button>
                    </span>
            <span style="vertical-align: text-bottom;" class="ml-2 text-md">DOCUMENTOS - NOTARIA</span>
          </summary>
          <div class="collapse-content">
            <div class="flex justify-between  pt-1 pb-1 mt-1 mx-1">
              <button to="tramite" class="btn btn-outline custom-hover btn-sm ml-auto"
                      @click="onUploadFileDocument()">ADJUNTAR DOCUMENTO
              </button>
            </div>
            <DocumentFormDetalle :uploadFile="false" :documents="detailTramite?.files_notaria"/>
          </div>
        </details>

        <div style="margin-top: 5px;"></div>
        <details class="collapse">
          <summary class="text-md font-medium bg-blue">
                    <span class="margin-spam">
                        <button class="btn btn-xs btn-circle  btn-ghost"><i class="bg-blue pi pi-comments"></i></button>
                    </span>
            <span style="vertical-align: text-bottom;" class="ml-2 text-md">COMENTARIOS</span>
          </summary>
          <div class="collapse-content">
            <div class="flex justify-between  pt-1 pb-1 mt-1 mx-1">
              <button to="tramite" class="btn btn-outline custom-hover btn-sm ml-auto"
                      @click="onOpenObservation">NUEVO
                COMENTARIO
              </button>
            </div>
            <Table>
              <THead>
              <tr>
                <th>Personal</th>
                <th>Observacion</th>
                <th>Fecha</th>
              </tr>
              </THead>
              <tbody>
              <tr v-if="allObservations && allObservations.length > 0"
                  v-for="(item, k) in allObservations" :key="k">
                <td>{{ item.personal?.nombre_compuesto }} {{ item.cliente?.nombre_compuesto }} {{
                    item.empresa?.nombre_compuesto
                  }}
                </td>
                <td>{{ item.s_observacion }}</td>
                <td>{{ item.created_at }}</td>
              </tr>
              <tr v-else>
                <td colspan="2">Sin Información</td>
              </tr>
              </tbody>
            </Table>
          </div>
        </details>
        <div style="margin-top: 5px;"></div>

        <!-- Contenido de COTIZACIÓN NOTARIAL -->
        <details class="collapse ">
          <summary class="text-md font-medium bg-blue">
                                <span class="margin-spam">
                                    <button class="btn btn-circle btn-xs btn-ghost bg-blue-claro ">
                                        <i class="pi pi-money-bill text-lg bg-blue-claro cursor-pointer"></i>
                                    </button>
                                </span>
            <span style="vertical-align: text-bottom;">COTIZACIÓN NOTARIAL</span>
          </summary>
          <div class="collapse-content">
            <!-- Contenido de COTIZACIÓN NOTARIAL -->
            <Table>
              <THead>
              <tr class="text-left">
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Monto</th>
              </tr>
              </THead>
              <tbody>
              <tr v-for="(item, key) in detailTramite?.servicio_notarial" :key="key">
                <td>{{ item?.servicio?.s_nombre }}</td>
                <td>{{ item.i_cantidad }}</td>
                <td>{{ item.de_precio.toFixed(2) }}</td>
                <td>{{ item.de_total.toFixed(2) }}</td>
              </tr>
              <tr>
                <td colspan="4">TOTAL <span class="badge badge-outline badge-success">{{
                    sumTotalNotarial
                  }}</span>
                </td>
              </tr>
              </tbody>
            </Table>
          </div>
        </details>
        <div style="margin-top: 5px;"></div>
        <!-- Contenido de COTIZACIÓN REGISTRAL -->
        <details class="collapse ">
          <summary class="text-md font-medium bg-blue">
                                <span class="margin-spam">
                                    <button class="btn btn-circle btn-xs btn-ghost bg-blue-claro ">
                                        <i class="pi pi-money-bill text-lg bg-blue-claro cursor-pointer"></i>
                                    </button>
                                </span>
            <span style="vertical-align: text-bottom;">COTIZACIÓN REGISTRAL</span>
          </summary>
          <div class="collapse-content">
            <!-- Contenido de COTIZACIÓN REGISTRAL -->
            <Table>
              <THead>
              <tr class="text-left">
                <th>Descripcion</th>
                <th>Cantidad</th>
                <th>Precio</th>
                <th>Monto</th>
              </tr>
              </THead>
              <tbody>
              <tr v-for="(item, key) in detailTramite?.servicio_registral"
                  :key="key">
                <td>{{ item?.servicio?.s_nombre }}</td>
                <td>{{ item.i_cantidad }}</td>
                <td>{{ item.de_precio.toFixed(2) }}</td>
                <td>{{ item.de_total.toFixed(2) }}</td>
              </tr>
              <tr>
                <td colspan="4">TOTAL <span class="badge badge-outline badge-success">{{
                    sumTotalRegistral
                  }}</span>
                </td>
              </tr>
              </tbody>
            </Table>
          </div>
        </details>


        <Modal :id="idModalUploadFileDocument">
          <button class="btn btn-xs  btn-circle" @click="$router.back()">
            <i class="pi pi-arrow-left"/>
          </button>
          Adjuntar Documentos
          <UploaderFiles documentType="varios" :key="keyUploadFile" :files="files" :multiple="true"
                         maxFileSize="50MB"
                         maxTotalFileSize="200MB"
                         accept="image/* , application/pdf,.docx, .xlsx"
                         @selectFile="onSelectedFile" label="Arrastra o Agrega tus Archivos"/>
          <Center>
            <BtnSave :loading="isSubmitAction" :disabled="isSubmitAction" @click="onSaveDocuments"
                     text="SUBIR ARCHIVO"/>
          </Center>
        </Modal>
        <Modal :id="idModalUploadFileTestimonio">
          <button class="btn btn-xs  btn-circle" @click="$router.back()">
            <i class="pi pi-arrow-left"/>
          </button>
          Testimonio Digital
          <UploaderFiles documentType="testimonio" :key="keyUploadFile" :files="files" :multiple="true"
                         :maxFiles="4"   maxFileSize="50MB"
                         maxTotalFileSize="200MB"
                         accept="image/* , application/pdf,.docx, .xlsx" @selectFile="onSelectedFile"
                         label="Arrastra o Agrega tus Archivos"/>
          <Center>
            <BtnSave :loading="isSubmitAction" :disabled="isSubmitAction" @click="onSaveDocuments"
                     text="SUBIR ARCHIVO"/>
          </Center>
        </Modal>
        <Modal :id="idAddObservationModal">
          <button class="btn btn-xs btn-circle right-0" @click="useCloseModal()">
            <i class="pi pi-arrow-left"></i>
          </button>
          Agregar Observacion
          <div>
                    <TextArea v-model="form_observacion.observacion.$value"
                              :error-message="form_observacion.observacion.$error?.message" label="Observacion"/>
          </div>
          <Center>
            <BtnSave @click="onSaveObservation()" :loading="isSaveObservation"
                     :disabled="isSaveObservation || !isValidForm(form_observacion)" text="Grabar"/>
          </Center>
        </Modal>

      </div>
      <div class="mx-2 text-center" v-else>No se encontró información que mostrar</div>
    </Card>
  </Container>
</template>

<script setup lang="ts">
import {computed, onMounted, ref, toRefs} from "vue";
import {
  Card,
  Container,
  Table,
  THead,
  Skeleton,
  Modal,
  TextArea, Center, UploaderFiles, BtnSave
} from "@/components";
import {debounce} from "../../../utils/debounce.js";
import Button from "primevue/button";
import {useTramiteStore} from "@/store/tramite";
import {useCloseModal, useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";
import AccountGroupOutline from "vue-material-design-icons/AccountGroupOutline.vue";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {notify} from "@kyvg/vue3-notification";
import type {HistorialTramite} from "@/models/types";
import {useKardexExternalStore} from "@/store/external/kardex.external";
import {DocumentFormDetalle} from '../../External/Tramite/Components'
import {defineForm, field, isValidForm} from "vue-yup-form";
import * as Yup from "yup";
import axios from "axios";
import type {ResponseList} from "@/models/extends";
import {useRoute, useRouter} from "vue-router";

const {isSubmitAction} = toRefs(useKardexExternalStore())
const {saveDocumentsInternal} = useKardexExternalStore()
const {isLoadingDetail, detailTramite} = toRefs(useTramiteStore());
const {saveObservationInternal, getAllObservationById, getDetail} = useTramiteStore();
const files = ref<IUploadFile[]>([])
const route = useRoute();
const tramite_id = ref<string>('');


const idModalUploadFileTestimonio = useGenerateKeyRandom()
const idModalUploadFileDocument = useGenerateKeyRandom()
const fileSelected = ref<IUploadFile[]>([]);
const keyUploadFile = ref<string>('')
const galeryComponentRef = ref<any>(null);
const idAddObservationModal = useGenerateKeyRandom()
const isLoadingAllObservation = ref<boolean>(false)
const allObservations = ref<HistorialTramite[]>([]);
const isSaveObservation = ref<boolean>(false)


const participants = ref<any[]>([]);
const router = useRouter()
const apiResource = "/api/external/kardex";


const form_observacion = defineForm({
  observacion: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .max(500, "Máximo 500 caracteres")
          .nullable()
  ),
});

const recargarPagina = () => {
  window.location.reload();
}

const onUploadFileDocument = () => {
  keyUploadFile.value = useGenerateKeyRandom()
  useOpenModal(idModalUploadFileDocument)
}

const onOpenObservation = () => {
  useOpenModal(idAddObservationModal)
}

const onSaveObservation = async () => {
  if (isValidForm(form_observacion)) {
    isSaveObservation.value = true
    try {

      const {historial_tramite, message, status} = await saveObservationInternal({
        s_tramite: detailTramite.value?.id,
        s_observacion: form_observacion.observacion.$value
      })

      if (status) {
        notify({
          title: "Bien Hecho!",
          text: message,
          type: 'success'
        })
        useCloseModal()
        cleanDataObservation()
        router.go(0);
      }

    } catch (error) {
      isSaveObservation.value = false
    } finally {
      setTimeout(() => {
        isSaveObservation.value = false
      }, 1000);
    }
  }
}

const cleanDataObservation = () => {
  form_observacion.observacion.$value = ''
}

const onSaveDocuments = async () => {

  if (files.value?.length) {
    try {
      isSubmitAction.value = true
      const {status, message} = await saveDocumentsInternal(files.value, detailTramite.value?.id)
      if (status) {
        isSubmitAction.value = false
        notify({
          title: message,
          type: 'success'
        })
        keyUploadFile.value = useGenerateKeyRandom()
        files.value = []
        useCloseModal()
        router.go(0);
      }
    } catch (e) {
      isSubmitAction.value = false
    } finally {
      isSubmitAction.value = false
    }
  }

}

async function listParticipants(items) {
  try {
    const {
      data: {data, meta},
    }: ResponseList<any> = await axios.post(
        `${apiResource}/get/participants`,
        items
    );
    participants.value = data;
  } catch (error) {
  } finally {

  }
}


const onSelectedFile = (doc) => {
  if (doc.file?.type.includes("image/")) {
    fileSelected.value = [doc.file];
    galeryComponentRef.value?.onOpen()
  } else {
    window.open(doc.file.file)
  }
}


const onGetAllObservationByKardex = async () => {

  isLoadingAllObservation.value = true
  try {
    const {historial_tramites} = await getAllObservationById(detailTramite.value?.id)
    if (historial_tramites) {
      allObservations.value = historial_tramites
    }

  } catch (error) {
    isLoadingAllObservation.value = false
  } finally {
    isLoadingAllObservation.value = false

  }

}


const sumTotalNotarial = computed(() => {
  const sumaTotalNotarialOne = detailTramite.value?.servicio_notarial?.reduce((total, item) => total + item.de_precio, 0);
  return sumaTotalNotarialOne ? sumaTotalNotarialOne.toFixed(2) : '0.00';
});

const sumTotalRegistral = computed(() => {
  const sumaTotalRegistralOne = detailTramite.value?.servicio_registral?.reduce((total, item) => total + item.de_precio, 0);
  return sumaTotalRegistralOne ? sumaTotalRegistralOne.toFixed(2) : '0.00';
});


onMounted(async () => {
  if (route.params?.id) {
    tramite_id.value = route.params?.id?.toString()
    await getDetail(tramite_id.value)
    const items = {
      "kardex": detailTramite.value?.kardex,
      "id": tramite_id.value
    };

    await listParticipants(items);
    await onGetAllObservationByKardex();
  }


});
</script>

<style scoped>
.bg-blue {
  background-color: #006aa6;
  color: white;
}

.margin-spam {
  margin-right: 5px;
  margin-left: 10px;
}

.custom-hover:hover {
  background-color: #006aa6 !important;
  color: white !important;
}

.custom-hover {
  border-color: #66a3d2;
  color: #66a3d2;
}
</style>

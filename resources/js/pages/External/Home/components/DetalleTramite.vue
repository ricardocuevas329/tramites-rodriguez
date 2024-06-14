<template>
    <div>
        <div class="md:mx-5">
            <div class="grid gap-2 my-4 border p-4">
                <div class="flex items-center justify-between">
                    <router-link to="/Home" class="btn btn-sm align-left">
                        <i class="pi pi-arrow-circle-left text-lg cursor-pointer"></i>Mis Trámites
                    </router-link>
                    <a @click.native="recargarPagina" class="btn btn-sm align-center">
                        Refrescar
                    </a>
                    <a role="button" class="btn btn-sm align-center">Trámite : {{ sTipokardex }} - {{ numKardex }}</a>
                </div>
                <details class="collapse">
                    <summary class="text-md font-medium bg-blue flex items-center">
                        <span class="margin-spam">
                            <button class="btn btn-circle btn-xs btn-ghost bg-blue">
                                <AccountGroupOutline />
                            </button>
                        </span>
                        <span style="vertical-align: text-bottom;" class="ml-2 text-md">COMPARECIENTES</span>
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
                                <tr class="bg-base-200" v-if="participants && participants.length > 0"
                                    v-for="(item, key) in participants" :key="key">
                                    <td>
                                        <span class="icon" @click.prevent="handleRowClick(item.s_compareciente)">
                                            <i class="pi pi-info-circle color-icono"></i>
                                        </span>
                                        {{ item.compareciente?.nombre_compuesto }}
                                    </td>
                                    <td>
                                        <span class="badge badge-outline badge-md"
                                            :class="item.i_firma ? 'badge-success' : 'badge-error'">{{ item.i_firma ?
                        'SI' :
                        'NO'
                                            }}</span>
                                    </td>
                                    <td>{{ item.d_fechfirma }}</td>
                                </tr>
                                <tr v-else>
                                    <td colspan="3">Sin Información</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </details>
                <details class="collapse ">
                    <summary class="text-md font-medium bg-blue">
                        <span class="margin-spam">
                            <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                                <i class="pi pi-file-import text-lg bg-blue cursor-pointer"></i>
                            </button>
                        </span>
                        <span style="vertical-align: text-bottom;">DOCUMENTOS - COORPORATIVO</span>
                    </summary>
                    <div class="collapse-content">
                        <div class="flex justify-between  pt-1 pb-1 mt-1 mx-1">
                            <button to="tramite" class="btn btn-outline custom-hover btn-sm ml-auto"
                                @click="onUploadFileDocument(itemId)">ADJUNTAR DOCUMENTO</button>
                        </div>
                        <DocumentFormDetalle :uploadFile="false" :documents="filesSelectedsExternal" />
                    </div>
                </details>
                <details class="collapse ">
                    <summary class="text-md font-medium bg-blue">
                        <span class="margin-spam">
                            <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                                <i class="pi pi-file-import text-lg bg-blue cursor-pointer"></i>
                            </button>
                        </span>
                        <span style="vertical-align: text-bottom;">DOCUMENTOS - NOTARIA</span>
                    </summary>
                    <div class="collapse-content">
                        <!--<div class="flex justify-between  pt-1 pb-1 mt-1 mx-1">
                    <button to="tramite" class="btn btn-outline custom-hover btn-sm ml-auto"
                        @click="onUploadFileDocument(itemId)">ADJUNTAR DOCUMENTO</button>
                </div>-->
                        <DocumentFormDetalle :uploadFile="false" :documents="filesSelectedsNotaria" />
                    </div>
                </details>
                <details class="collapse ">
                    <summary class="text-md font-medium bg-blue">
                        <span class="margin-spam">

                            <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                                <i class="pi pi-file text-lg bg-blue cursor-pointer"></i>
                            </button>
                        </span>
                        <span style="vertical-align: text-bottom;">ESTADO REGISTRAL</span>
                    </summary>
                    <div class="collapse-content">
                        <Table>
                            <THead>
                                <tr>
                                    <th>N° TITULO</th>
                                    <th>FECHA DE PRESENTACION</th>
                                    <th>ACTO</th>
                                    <th>ESTADO</th>
                                    <th>PARTIDA</th>
                                </tr>
                            </THead>
                            <tbody>
                                <tr v-if="recordsRegisterPublics?.registro_publico?.length"
                                    v-for="(item, k) in recordsRegisterPublics?.registro_publico" :key="k">
                                    <td>{{ item?.s_titulo }}</td>
                                    <td>{{ item?.d_fecha }}</td>
                                    <td> </td>
                                    <td> {{ item?.s_estadoR }}</td>
                                    <td> {{ item?.s_partida }}</td>
                                </tr>
                                <tr v-else>
                                    <td>Sin Información</td>
                                </tr>
                            </tbody>
                        </Table>
                    </div>
                </details>

                <details class="collapse ">
                    <summary class="text-md font-medium bg-blue">
                        <span class="margin-spam">
                            <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                                <i class="pi pi-money-bill text-lg bg-blue cursor-pointer"></i>
                            </button>
                        </span>
                        <span style="vertical-align: text-bottom;">PRESUPUESTO</span>
                    </summary>
                    <div style="margin-top: 10px;"></div>
                    <div class="collapse-content">

                        <!-- Contenido de COTIZACIÓN NOTARIAL -->
                        <details class="collapse ">
                            <summary class="text-md font-medium bg-blue-claro">
                                <span class="margin-spam">
                                    <button class="btn btn-circle btn-xs btn-ghost bg-blue-claro ">
                                        <i class="pi pi-money-bill text-lg bg-blue-claro cursor-pointer"></i>
                                    </button>
                                </span>
                                <span style="vertical-align: text-bottom;">COTIZACIÓN NOTARIAL</span>
                            </summary>
                            <div class="collapse-content">
                                <!-- Contenido de COTIZACIÓN NOTARIAL -->
                                <table class="table table-xs">
                                    <THead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Monto</th>
                                        </tr>
                                    </THead>
                                    <tbody>
                                        <tr v-for="(item, key) in recordsRegisterPublics?.servicio_notarial" :key="key">
                                            <td>{{ item?.servicio?.s_nombre }}</td>
                                            <td>{{ item.i_cantidad }}</td>
                                            <td class="text-right">{{ item.de_precio.toFixed(2) }}</td>
                                            <td class="text-right">{{ item.de_total.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">TOTAL <span class="badge badge-outline badge-success">{{
                        sumaTotalNotarial
                    }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </details>
                        <div style="margin-top: 5px;"></div>
                        <!-- Contenido de COTIZACIÓN REGISTRAL -->
                        <details class="collapse ">
                            <summary class="text-md font-medium bg-blue-claro">
                                <span class="margin-spam">
                                    <button class="btn btn-circle btn-xs btn-ghost bg-blue-claro ">
                                        <i class="pi pi-money-bill text-lg bg-blue-claro cursor-pointer"></i>
                                    </button>
                                </span>
                                <span style="vertical-align: text-bottom;">COTIZACIÓN REGISTRAL</span>
                            </summary>
                            <div class="collapse-content">
                                <!-- Contenido de COTIZACIÓN REGISTRAL -->
                                <table class="table table-xs">
                                    <THead>
                                        <tr>
                                            <th>Descripcion</th>
                                            <th>Cantidad</th>
                                            <th>Precio</th>
                                            <th>Monto</th>
                                        </tr>
                                    </THead>
                                    <tbody>
                                        <tr v-for="(item, key) in recordsRegisterPublics?.servicio_registral"
                                            :key="key">
                                            <td>{{ item?.servicio?.s_nombre }}</td>
                                            <td>{{ item.i_cantidad }}</td>
                                            <td class="text-right">{{ item.de_precio.toFixed(2) }}</td>
                                            <td class="text-right">{{ item.de_total.toFixed(2) }}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="4">TOTAL <span class="badge badge-outline badge-success">{{
                        sumaTotalRegistral
                    }}</span>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </details>

                    </div>
                </details>

                <details class="collapse ">
                    <summary class="text-md font-medium bg-blue">
                        <span class="margin-spam">
                            <button class="btn btn-xs btn-circle  btn-ghost"><i
                                    class="bg-blue pi pi-comments"></i></button>
                        </span>
                        <span>COMENTARIOS</span>
                    </summary>
                    <div class="collapse-content">
                        <div class="flex justify-between  pt-1 pb-1 mt-1 mx-1">
                            <button to="tramite" class="btn btn-outline custom-hover btn-sm ml-auto"
                                @click="onOpenObservation">NUEVO
                                COMENTARIO</button>
                        </div>
                        <Table>
                            <THead>
                                <tr>
                                    <th>Personal</th>
                                    <th>Observacion</th>
                                </tr>
                            </THead>
                            <tbody>
                                <tr v-if="allObservations && allObservations.length > 0"
                                    v-for="(item, k) in allObservations" :key="k">
                                    <td>{{ item.personal?.nombre_compuesto }} {{ item.cliente?.nombre_compuesto }} {{
                        item.empresa?.nombre_compuesto }}</td>
                                    <td>{{ item.s_observacion }}</td>
                                </tr>
                                <tr v-else>
                                    <td colspan="2">Sin Información</td>
                                </tr>
                            </tbody>
                        </Table>
                    </div>
                </details>
            </div>
            <Modal :id="idAddObservationModal">
                <button class="btn btn-xs btn-circle right-0" @click="useCloseModal()">
                    <i class="pi pi-arrow-left"></i>
                </button>
                Agregar Observacion
                <div>
                    <TextArea v-model="form_observacion.observacion.$value"
                        :error-message="form_observacion.observacion.$error?.message" label="Observacion" />
                </div>
                <Center>
                    <BtnSave @click="onSaveObservation()" :loading="isSaveObservation"
                        :disabled="isSaveObservation || !isValidForm(form_observacion)" text="Grabar" />
                </Center>
            </Modal>
            <Modal :id="idModalUploadFileDocument">
                <button class="btn btn-xs  btn-circle" @click="$router.back()">
                    <i class="pi pi-arrow-left" />
                </button>
                Adjuntar Documentos
                <UploaderFiles documentType="varios" :key="keyUploadFile" :files="files" :multiple="true"
                    maxFileSize="15MB" maxTotalFileSize="60MB" accept="image/*, application/pdf, .docx, .xlsx"
                    @selectFile="onSelectedFile" label="Arrastra o Agrega tus Archivos" />
                <Center>
                    <BtnSave :loading="isSubmitAction" :disabled="isSubmitAction" @click="onSaveDocuments"
                        text="SUBIR ARCHIVO" />
                </Center>
            </Modal>
            <Modal :id="idClienteDetalle">
                <div class="modal-header">
                    <button class="btn btn-xs btn-circle" @click="$router.back()">
                        <i class="pi pi-arrow-left" />
                    </button>
                    <h4 class="modal-title">Detalle del Compareciente</h4>
                </div>
                <div v-if="numKardex" class="modal-body">
                    <div>
                        <strong>Tipo Documento:</strong> {{ detalleCliente?.tipo_documento?.s_abrev }}
                    </div>
                    <div>
                        <strong>Número Documento:</strong> {{ detalleCliente?.s_num_doc }}
                    </div>
                    <div>
                        <strong>Nombre:</strong> {{ detalleCliente?.nombre_compuesto }}
                    </div>
                    <div>
                        <strong>Estado Civil:</strong> {{ detalleCliente?.s_estado_civil }}
                    </div>
                    <div>
                        <strong>Sexo:</strong> {{ detalleCliente?.s_sexo }}
                    </div>
                    <div>
                        <strong>Edad:</strong> {{ detalleCliente?.edad }}
                    </div>
                </div>
            </Modal>
        </div>
        <router-view></router-view>
    </div>
</template>

<script lang="ts" setup>
import {
    Center,
    BtnSave,
    Table,
    THead,
    UploaderFiles,
    Modal,
    TextArea,
} from "@/components";
import { useCloseModal, useGenerateKeyRandom, useOpenModal } from "@/hooks/useUtils";

import AccountGroupOutline from 'vue-material-design-icons/AccountGroupOutline.vue'
import { useKardexExternalStore } from "@/store/external/kardex.external";
import type { IUploadFile } from "@/models/components/upload-file.interface";
import { watch, onMounted, ref, toRefs, defineEmits } from "vue";
import { notify } from "@kyvg/vue3-notification";
import { useClientExternalStore } from "@/store/external/client.external";
import { useTramiteStore } from "@/store/tramite";
import { DocumentFormDetalle } from '../../../External/Tramite/Components';
import type { HistorialTramite } from "@/models/types";
import type { ResponseList } from "@/models/extends";
import * as Yup from "yup";
import { defineForm, field, isValidForm } from "vue-yup-form";
import axios from "axios";
import { useRoute, useRouter } from "vue-router";

const { isLoading, details } = toRefs(useClientExternalStore())
const { listProcedureDetail } = useClientExternalStore()
const { listParticipants, saveDocumentsExternal } = useKardexExternalStore()
const { saveObservationExternal, getAllObservationById } = useTramiteStore();
const files = ref<IUploadFile[]>([])
const emit = defineEmits(['onSelectedRow'])

const { isSubmitAction, participants } = toRefs(useKardexExternalStore())
const idModalUploadFileDocument = useGenerateKeyRandom()
const idClienteDetalle = useGenerateKeyRandom()

const idSelected = ref<number>(0)
const keyUploadFile = ref<string>('')
const filesSelectedsExternal = ref<IUploadFile[]>([])
const filesSelectedsNotaria = ref<IUploadFile[]>([])
const allObservations = ref<HistorialTramite[]>([]);
const isSaveObservation = ref<boolean>(false)
const kardexSelected = ref<string>('')
const sTipokardex = ref<string>('')
const numKardex = ref<string>('')
const isLoadingAllObservation = ref<boolean>(false)
const apiResource = "/api/external/client";
const recordsRegisterPublics = ref<any>();
const idAddObservationModal = useGenerateKeyRandom()
const fileSelected = ref<IUploadFile[]>([]);
const galeryComponentRef = ref<any>(null);
const itemId = ref<string>('')
const router = useRouter()
const sumaTotalNotarial = ref<any>();
const sumaTotalRegistral = ref<any>();
const detalleCliente = ref<any>();
const route = useRoute();
const id = ref<string>('');
const kardex_num = ref<string>('');


const onViewParticipant = async (payload) => {
    idSelected.value = payload.id
    //useOpenModal(idModalParticpant)
    await listParticipants({
        kardex: payload.kardex,
        id: payload.id
    })
}
const onOpenViewObservation = (id: string) => {
    kardexSelected.value = id
    //useOpenModal(idViewObservationModal)
    onGetAllObservationByKardex()
}

const form_observacion = defineForm({
    observacion: field<string>(
        "",
        Yup.string()
            .required("es requerido")
            .max(500, "Máximo 500 caracteres")
            .nullable()
    ),
});

const onUploadFileDocument = (id) => {
    files.value = []
    keyUploadFile.value = useGenerateKeyRandom()
    idSelected.value = id
    useOpenModal(idModalUploadFileDocument)
}
const handleRowClick = async (codigo) => {
    if (!numKardex.value) return
    try {
        const { data, status } = await axios.get(
            `${apiResource}/list-cliente/${codigo}`
        );
        if (status === 200) {
            useOpenModal(idClienteDetalle)
            detalleCliente.value = data.data;
        }
    } catch (error) {
        // Maneja cualquier error que pueda ocurrir durante la solicitud.
        console.error('Error al realizar la solicitud GET:', error);
    }
};

const onSaveDocuments = async () => {
    if (files.value.length) {
        try {
            isSubmitAction.value = true
            const { status, message } = await saveDocumentsExternal(files.value, idSelected.value)
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
        const { historial_tramites } = await getAllObservationById(kardexSelected.value)
        if (historial_tramites) {
            allObservations.value = historial_tramites
        }

    } catch (error) {
        isLoadingAllObservation.value = false
    } finally {
        isLoadingAllObservation.value = false

    }
}

const onViewDocumentsExternal = (paylaod) => {
    console.log('paylaod', paylaod);
    filesSelectedsExternal.value = paylaod.files
}

const onViewDocumentsNotaria = (paylaod) => {
    console.log('paylaod', paylaod);
    filesSelectedsNotaria.value = paylaod.files_notaria
}
const onOpenObservation = () => {
    useOpenModal(idAddObservationModal)
}
const onSaveObservation = async () => {
    if (isValidForm(form_observacion)) {
        isSaveObservation.value = true
        try {

            const { historial_tramite, message, status } = await saveObservationExternal({
                s_tramite: kardexSelected.value,
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
    kardexSelected.value = ''
    form_observacion.observacion.$value = ''
}
const recargarPagina = () => {
    window.location.reload();
}

const onTotalNotarial = (recordsRegisterPublics) => {
    const sumaTotalNotarialOne = recordsRegisterPublics.servicio_notarial.reduce((total, item) => total + item.de_precio, 0);
    sumaTotalNotarial.value = sumaTotalNotarialOne.toFixed(2)
    console.log('sumaTotalNotarialNuevo', sumaTotalNotarialOne.toFixed(2));
}

const onTotalRegistral = (recordsRegisterPublics) => {
    const sumaTotalRegistralOne = recordsRegisterPublics.servicio_registral.reduce((total, item) => total + item.de_precio, 0);
    sumaTotalRegistral.value = sumaTotalRegistralOne.toFixed(2)
    console.log('sumaTotalNotarialNuevo', sumaTotalRegistralOne.toFixed(2));
}
async function listRegisterPublic(id: number) {
    try {
        isLoading.value = true;
        const {
            data: { data },
        }: ResponseList<any> = await axios.post(
            `${apiResource}/get/register-public`, {
            id
        }
        );
        recordsRegisterPublics.value = data;
        onTotalNotarial(recordsRegisterPublics.value)
        onTotalRegistral(recordsRegisterPublics.value)
    } catch (error) {
        console.error('Error al obtener registros públicos:', error);
    } finally {
        isLoading.value = false;
    }
}


const onGetDetail = async (id: string) => {
    await listProcedureDetail(id);
    const rowData = details.value;
    sTipokardex.value = rowData.detalle_kardex.s_tipokardex;
    numKardex.value = rowData.detalle_kardex.num_kardex;
    onViewParticipant(rowData);
    onViewDocumentsExternal(rowData);
    onViewDocumentsNotaria(rowData);
    onOpenViewObservation(rowData.kardex);
    listRegisterPublic(rowData.id);

}

onMounted(() => {

    kardex_num.value = route.params?.kardex?.toString()
    onGetDetail(kardex_num.value)
    watch(
        () => route.params.id,
        async (newId, oldId) => {
            console.log(newId)
            if (newId && newId != oldId) {
                itemId.value = route.params?.id?.toString()
                kardex_num.value = route.params?.kardex?.toString()
                await onGetDetail(kardex_num.value)
                try {

                } catch (error) {

                }
            }
        });
})






</script>

<style scoped>
.bg-blue {
    background-color: #006aa6;
    color: white;
}

.bg-blue-claro {
    background-color: #007ab6;
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

.align-left {
    text-align: left !important;
}

.align-center {
    text-align: center !important;
}

.color-icono {
    color: #006aa6
}

/** Para el modal de Detalle Cliente */
.modal-header {
    background-color: #3498db;
    /* Cambia el color de fondo según tus preferencias */
    color: white;
    padding: 10px;
    display: flex;
    align-items: center;
}

.modal-title {
    margin-left: 10px;
}

.modal-body {
    padding: 20px;
    background-color: #ecf0f1;
    /* Cambia el color de fondo según tus preferencias */
    border-radius: 5px;
    /* Agrega bordes redondeados */
}
</style>

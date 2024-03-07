<template>
    <Container>
        <Card>
            <div class="flex items-center justify-between">
                <router-link to="/Tramite" class="btn btn-sm align-left">
                    <i class="pi pi-arrow-circle-left text-lg cursor-pointer"></i>Mis Trámites
                </router-link>
                <a @click.native="recargarPagina" class="btn btn-sm align-center">
                    Refrescar
                </a>
                <a role="button" class="btn btn-sm align-center">Trámite : {{ sTipokardex }} - {{ numKardex }}</a>
            </div>
            <div style="margin-top: 5px;"></div>
            <details class="collapse">
                <summary class="text-md font-medium bg-blue flex items-center">
                    <span class="margin-spam">
                        <button class="btn btn-circle btn-xs btn-ghost bg-blue">
                            <AccountGroupOutline />
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
                    <!--<div class="flex justify-between  pt-1 pb-1 mt-1 mx-1">
                        <button to="tramite" class="btn btn-outline custom-hover btn-sm ml-auto"
                            @click="onUploadFileDocument()">ADJUNTAR DOCUMENTO</button>
                    </div>-->
                    <DocumentFormDetalle :uploadFile="false" :documents="filesSelectedsExternal" />
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
                            @click="onUploadFileDocument()">ADJUNTAR DOCUMENTO</button>
                    </div>
                    <DocumentFormDetalle :uploadFile="false" :documents="filesSelectedsNotaria" />
                </div>
            </details>
            <!--
            <div style="margin-top: 5px;"></div>
            <details class="collapse">
                <summary class="text-md font-medium bg-blue flex items-center">
                    <span class="margin-spam">
                        <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                            <i class="pi pi-file-import text-lg bg-blue cursor-pointer"></i>
                        </button>
                    </span>
                    <span style="vertical-align: text-bottom;" class="ml-2 text-md">TESTIMONIO DIGITAL</span>
                </summary>
                <div class="collapse-content">
                    <div class="flex justify-between  pt-1 pb-1 mt-1 mx-1">
                        <button to="tramite" class="btn btn-outline custom-hover btn-sm ml-auto"
                            @click="onUploadFileTestimonio()">SUBIR TESTIMONIO DIGITAL</button>
                    </div>
                    <DocumentForm :uploadFile="false" :documents="filesSelectedTestimonio" />
                </div>
            </details>
            -->
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
            <div style="margin-top: 5px;"></div>
            <details class="collapse">
                <summary class="text-md font-medium bg-blue">
                    <span class="margin-spam">

                        <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                            <i class="pi pi-file text-lg bg-blue cursor-pointer"></i>
                        </button>
                    </span>
                    <span style="vertical-align: text-bottom;" class="ml-2 text-md">COT. NOTARIAL</span>
                </summary>
                <div class="collapse-content">
                    <tr>
                        <td><span class="badge badge-outline badge-success">{{
                    sumaTotalNotarial
                }}</span>
                        </td>
                    </tr>
                </div>
            </details>
            <div style="margin-top: 5px;"></div>
            <details class="collapse">
                <summary class="text-md font-medium bg-blue">
                    <span class="margin-spam">

                        <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                            <i class="pi pi-file text-lg bg-blue cursor-pointer"></i>
                        </button>
                    </span>
                    <span style="vertical-align: text-bottom;" class="ml-2 text-md">COT. REGISTRAL</span>
                </summary>
                <div class="collapse-content">
                    <tr>
                        <td><span class="badge badge-outline badge-success">{{
                        sumaTotalRegistral
                    }}</span>
                        </td>
                    </tr>
                </div>
            </details>

            <Modal :id="idModalUploadFileDocument">
                <button class="btn btn-xs  btn-circle" @click="$router.back()">
                    <i class="pi pi-arrow-left" />
                </button>
                Adjuntar Documentos
                <UploaderFiles documentType="varios" :key="keyUploadFile" :files="files" :multiple="true"
                    maxFileSize="15MB" maxTotalFileSize="60MB" accept="image/* , application/pdf,.docx, .xlsx"
                    @selectFile="onSelectedFile" label="Arrastra o Agrega tus Archivos" />
                <Center>
                    <BtnSave :loading="isSubmitAction" :disabled="isSubmitAction" @click="onSaveDocuments"
                        text="SUBIR ARCHIVO" />
                </Center>
            </Modal>
            <Modal :id="idModalUploadFileTestimonio">
                <button class="btn btn-xs  btn-circle" @click="$router.back()">
                    <i class="pi pi-arrow-left" />
                </button>
                Testimonio Digital
                <UploaderFiles documentType="testimonio" :key="keyUploadFile" :files="files" :multiple="true"
                    :maxFiles="4" maxFileSize="15MB" maxTotalFileSize="60MB"
                    accept="image/* , application/pdf,.docx, .xlsx" @selectFile="onSelectedFile"
                    label="Arrastra o Agrega tus Archivos" />
                <Center>
                    <BtnSave :loading="isSubmitAction" :disabled="isSubmitAction" @click="onSaveDocuments"
                        text="SUBIR ARCHIVO" />
                </Center>
            </Modal>
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
        </Card>
    </Container>
</template>

<script setup lang="ts">
import { onMounted, ref, toRefs } from "vue";
import {
    Card,
    Container,
    ContainerTable,
    ListEmpty,
    Options,
    Paginate,
    Skeleton,
    Table,
    TextInputSearch,
    THead,
    Title,
    ToolTip,
    Modal,
    TextArea, Center, Galery, UploaderFiles, BtnSave, ScrollView
} from "@/components";
import { debounce } from "../../../utils/debounce.js";
import Button from "primevue/button";
import { useTramiteStore } from "@/store/tramite";
import { useCloseModal, useGenerateKeyRandom, useOpenModal } from "@/hooks/useUtils";
import AccountGroupOutline from "vue-material-design-icons/AccountGroupOutline.vue";
import type { IUploadFile } from "@/models/components/upload-file.interface";
import { notify } from "@kyvg/vue3-notification";
import type { HistorialTramite } from "@/models/types";
import { useKardexExternalStore } from "@/store/external/kardex.external";
import { DocumentFormDetalle } from '../../External/Tramite/Components'
import { defineForm, field, isValidForm } from "vue-yup-form";
import * as Yup from "yup";
import axios from "axios";
import type { ResponseList } from "@/models/extends";
import type { Kardex } from "@/models/types";
import { API_URL } from "@/config/enviroments";
import { useRouter } from "vue-router";

const { isSubmitAction } = toRefs(useKardexExternalStore())
const { saveDocuments } = useKardexExternalStore()
const { search, pagination, isLoading } = toRefs(useTramiteStore());
const { cleanPagination, saveObservation, getAllObservationById } = useTramiteStore();
const files = ref<IUploadFile[]>([])
const filesSelectedsExternal = ref<IUploadFile[]>([])
const filesSelectedsNotaria = ref<IUploadFile[]>([])

const idModalUploadFileTestimonio = useGenerateKeyRandom()
const idModalUploadFileDocument = useGenerateKeyRandom()
const filesSelectedTestimonio = ref<IUploadFile[]>([]);
const fileSelected = ref<IUploadFile[]>([]);
const idSelected = ref<number>(0)
const keyUploadFile = ref<string>('')
const galeryComponentRef = ref<any>(null);
const idAddObservationModal = useGenerateKeyRandom()
const idViewObservationModal = useGenerateKeyRandom()
const kardexSelected = ref<string>('')
const isLoadingAllObservation = ref<boolean>(false)
const allObservations = ref<HistorialTramite[]>([]);
const isSaveObservation = ref<boolean>(false)


const participants = ref<any[]>([]);
const router = useRouter()
const documentoValue = ref<string>('')
const TramiteResults = ref<Kardex[]>([]);
const apiResource = "/api/external/kardex";
const apiResourceTramite = API_URL + "/api/tramite";
const sTipokardex = ref<string>('')
const numKardex = ref<string>('')
const cotNotarial = ref<string>('')
const sumaTotalNotarial = ref<any>();
const sumaTotalRegistral = ref<any>();

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
    idSelected.value = TramiteResults.value[0].id
    useOpenModal(idModalUploadFileDocument)
}

const onOpenObservation = () => {
    kardexSelected.value = TramiteResults.value[0].id
    useOpenModal(idAddObservationModal)
}

const onSaveObservation = async () => {
    if (isValidForm(form_observacion)) {
        isSaveObservation.value = true
        try {

            const { historial_tramite, message, status } = await saveObservation({
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

const onSaveDocuments = async () => {

    if (files.value?.length) {
        try {
            isSubmitAction.value = true
            const { status, message } = await saveDocuments(files.value, idSelected.value)
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
            data: { data, meta },
        }: ResponseList<any> = await axios.post(
            `${apiResource}/get/participants`,
            items
        );
        participants.value = data;
    } catch (error) {
    } finally {

    }
}

const onViewDocumentsExternal = (paylaod) => {
    filesSelectedsExternal.value = paylaod.files
}

const onViewDocumentsNotaria = (paylaod) => {
    filesSelectedsNotaria.value = paylaod.files_notaria
}

const onViewDocumentsTestimonio = (paylaod) => {
    filesSelectedTestimonio.value = paylaod.files_testimonio
}

const onUploadFileTestimonio = () => {
    keyUploadFile.value = useGenerateKeyRandom()
    idSelected.value = TramiteResults.value[0].id
    useOpenModal(idModalUploadFileTestimonio)
}

const onSelectedFile = (doc) => {
    if (doc.file?.type.includes("image/")) {
        fileSelected.value = [doc.file];
        galeryComponentRef.value?.onOpen()
    } else {
        window.open(doc.file.file)
    }
}

async function listTramite(documento) {
    try {
        isLoading.value = true;
        let current_page = pagination.value?.current_page;
        let page = current_page ? current_page : 1;
        let searchFilter = documento
        const {
            data: { data, meta },
        }: ResponseList<Kardex> = await axios.get(
            `${apiResourceTramite}?page=${page.toString()}&search=${searchFilter}`
        );
        TramiteResults.value = data;
        console.log('Tramite Results', TramiteResults.value);
        pagination.value = meta;
    } catch (error) {
    } finally {
        isLoading.value = false;
    }
}

const onOpenViewObservation = (id: string) => {
    kardexSelected.value = id
    useOpenModal(idViewObservationModal)
    onGetAllObservationByKardex()
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

// Función para obtener valores de la URL
const getURLValues = () => {
    const pathSegments = window.location.pathname.split('/');
    return {
        documentoValue: pathSegments[4],
        itemId: pathSegments[3],
        codeKardex: pathSegments[5],
    };
}

const onTotalNotarial = (recordsRegisterPublics) => {

    //Filtrar solo los servicios notariales con s_tipo_servicio igual a 0
    const serviciosNotarialesTipo0 = recordsRegisterPublics.filter(item => item.s_tipo_servicio === 0);
    //console.log('serviciosNotarialesTipo0', serviciosNotarialesTipo0);
    const sumaTotalNotarialOne = serviciosNotarialesTipo0.reduce((total, item) => total + item.de_precio, 0);
    sumaTotalNotarial.value = sumaTotalNotarialOne.toFixed(2)
    console.log('sumaTotalNotarialNuevo', sumaTotalNotarialOne.toFixed(2));
}

const onTotalRegistral = (recordsRegisterPublics) => {

    //Filtrar solo los servicios Registrales con s_tipo_servicio igual a 
    const serviciosRegistralesTipo1 = recordsRegisterPublics.filter(item => item.s_tipo_servicio === 1);
    //console.log('serviciosRegistralesTipo1', serviciosRegistralesTipo1);
    const sumaTotalRegistralTwo = serviciosRegistralesTipo1.reduce((total, item) => total + item.de_precio, 0);
    sumaTotalRegistral.value = sumaTotalRegistralTwo.toFixed(2)
    console.log('sumaTotalRegistralNuevo', sumaTotalRegistralTwo.toFixed(2));
}

onMounted(async () => {
    try {
        // Obtener el valor del documento desde la URL
        documentoValue.value = window.location.pathname.split('/')[4];

        // Obtener resultados de trámite y mostrar en la consola
        await listTramite(documentoValue.value);
        const rowData = TramiteResults.value[0];
        console.log('rowData Final', rowData);

        // Resto de tu código usando rowData...
        sTipokardex.value = rowData.detalle_kardex.s_tipokardex;
        numKardex.value = rowData.detalle_kardex.num_kardex;
        cotNotarial.value = rowData.detalle_kardex.num_kardex;
        // Obtener valores de la URL para itemId y codeKardex
        const { itemId, codeKardex } = getURLValues();

        // Crear un objeto con los valores obtenidos
        const items = {
            "kardex": codeKardex,
            "id": itemId
        };
        console.log('items finales', items);

        // Listar participantes con los items creados
        await listParticipants(items);

        // Mostrar participantes en la consola
        console.log('participantes', participants);

        onViewDocumentsExternal(rowData);
        onViewDocumentsNotaria(rowData);
        onViewDocumentsTestimonio(rowData);
        onOpenViewObservation(rowData.id);
        onTotalNotarial(rowData.servicio_notarial)
        onTotalRegistral(rowData.servicio_notarial)

    } catch (error) {
        console.error('Error en la función onMounted:', error);
        // Puedes realizar alguna acción o mostrar un mensaje de error al usuario
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

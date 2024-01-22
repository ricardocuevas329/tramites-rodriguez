<template>
    <Container>
        <div v-if="$route.name == configProtocolar._TRAMITE_.listar.name">
            <Card>

                <Title>Trámite</Title>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4  gap-2 my-4">
                    <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                        <TextInputSearch @input="filter()" @keyup="filter()" v-model="search" placeholder="Buscar..." />
                    </div>
                    <div class="col-span-1">
                        <Options text="Opciones">
                            <ul tabindex="0"
                                class="static  dropdown-content z-60 menu p-2 shadow bg-base-100 rounded-box w-52">
                                <li>
                                    <a @click="filter()">
                                        <RefreshIcon />
                                        Refrescar
                                    </a>

                                </li>
                            </ul>
                        </Options>
                    </div>

                </div>

                <ContainerTable v-if="!isLoading">
                    <Table>
                        <THead>
                            <tr>
                                <th>Accion</th>
                                <th>CODIGO</th>
                                <th>F. INGRESO</th>
                                <th>SOLICITANTE</th>
                                <th>N° DOCUMENTO</th>
                                <th>ACTO NOTARIAL</th>
                                <th>KARDEX</th>
                                <th>F. APERTURA</th>
                                <th>COT. NOTARIAL</th>
                                <th>COT. REGISTRAL</th>
                                <th>F. ESCRITURACION</th>
                                <th>F. ULTIMA FIRMA</th>
                                <th>TESTIMONIO DIGITAL</th>
                                <th>Observacion</th>
                            </tr>
                        </THead>
                        <tbody>
                            <tr class="cursor-pointer" :class="idSelected === item.id && 'bg-gray-400'"
                                v-for="(item, key) in TramiteResults" :key="key" @click="onSelectedRow(item)">
                                <td @click.stop class="flex actions">
                                    <ToolTip v-if="item?.kardex" text="Ver Participantes" position="right">
                                        <button @click="onVieParticipant(item)"
                                            class="btn btn-circle btn-xs btn-ghost text-primary ">
                                            <AccountGroupOutline />
                                        </button>
                                    </ToolTip>
                                    <ToolTip text="Ver Documentos" position="right">
                                        <button @click="onViewDocuments(item)"
                                            class="btn btn-circle btn-xs btn-ghost text-primary ">
                                            <i class="pi pi-file-import text-lg text-success cursor-pointer"></i>
                                        </button>
                                    </ToolTip>
                                    <ToolTip text="Ver Testimonio Digital" position="right">
                                        <button @click="onViewDocumentsTestimonio(item)"
                                            class="btn btn-circle btn-xs btn-ghost text-primary ">
                                            <i class="pi pi-file text-lg text-primary cursor-pointer"></i>
                                        </button>
                                    </ToolTip>
                                    <ToolTip text="asignar kardex" position="right">
                                        <button :disabled="item?.kardex" @click="onAsignationKardex(item.id)"
                                            class="btn btn-circle btn-xs btn-ghost text-success ">
                                            <DocumentAttachSharp />
                                        </button>
                                    </ToolTip>


                                    <ToolTip text="Adjuntar Documentos" position="right">
                                        <button @click="onUploadFileDocument(item)"
                                            class="btn btn-circle btn-xs btn-ghost text-primary ">
                                            <CloudUpload class="w-8  text-primary cursor-pointer" />
                                        </button>
                                    </ToolTip>

                                </td>
                                <td class="text-center">{{ item.id }}</td>
                                <td>{{ item.created_at }}</td>
                                <td>{{ item.nombre_compuesto }}</td>
                                <td>{{ item.documento }}</td>
                                <td> {{ item?.detalle_kardex?.s_obstitulo }}</td>
                                <td> {{ item?.detalle_kardex?.s_tipokardex }} - {{ item?.detalle_kardex?.num_kardex }}</td>
                                <td>{{ item?.detalle_kardex?.d_feching }}</td>
                                <td class="text-end"> {{ onTotalNotarial(item?.servicio_notarial) }}</td>
                                <td class="text-end"> {{ onTotalRegistral(item?.servicio_notarial) }}</td>
                                <td>{{ item?.detalle_kardex?.d_fechescritura }}</td>
                                <td> {{ item?.is_date_mayor }}</td>
                                <Center>
                                    <ToolTip v-if="item?.kardex" text="Subir Tetimonio Digital" position="right">
                                        <button @click="onUploadFileTestimonio(item)"
                                            class="btn btn-circle btn-xs btn-ghost text-primary ">
                                            <CloudUpload class="w-8  text-primary cursor-pointer" />
                                        </button>
                                    </ToolTip>
                                </Center>
                                <td class="actions  ">

                                    <div v-if="item?.kardex">
                                        <ToolTip text="Agregar Mensaje">
                                            <button @click="onOpenObservation(item.kardex)"
                                                class="btn btn-xs btn-circle btn-ghost"><i
                                                    class="text-primary pi pi-comment"></i></button>
                                        </ToolTip>

                                        <ToolTip text="Ver Mensajes">
                                            <button @click="onOpenViewObservation(item.kardex)"
                                                class="btn btn-xs btn-circle  btn-ghost"><i
                                                    class="text-success pi pi-comments"></i></button>
                                        </ToolTip>

                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </Table>
                    <ListEmpty v-if="TramiteResults?.length == 0" />
                </ContainerTable>
                <Skeleton v-if="isLoading" :tipo="2" />
                <Paginate v-if="TramiteResults?.length && !isLoading" :pagination="pagination" @paginate="listTramite()" />
            </Card>



        </div>


        <Modal :id="idModalUploadFileTestimonio">
            <button class="btn btn-xs  btn-circle" @click="$router.back()">
                <i class="pi pi-arrow-left" />
            </button>
            Testimonio Digital
            <UploaderFiles documentType="testimonio" :key="keyUploadFile" :files="files" :multiple="true" :maxFiles="4"
                maxFileSize="15MB" maxTotalFileSize="60MB" accept="image/* , application/pdf,.docx, .xlsx" @selectFile="onSelectedFile"
                label="Arrastra o Agrega tus Archivos" />
            <Center>
                <BtnSave :loading="isSubmitAction" :disabled="isSubmitAction" @click="onSaveDocuments"
                    text="SUBIR ARCHIVO" />
            </Center>
        </Modal>

        <Modal :id="idModalUploadFileDocument">
            <button class="btn btn-xs  btn-circle" @click="$router.back()">
                <i class="pi pi-arrow-left" />
            </button>
            Adjuntar Documentos
            <UploaderFiles documentType="varios" :key="keyUploadFile" :files="files" :multiple="true" :maxFiles="4"
                maxFileSize="15MB" maxTotalFileSize="60MB" accept="image/* , application/pdf,.docx, .xlsx" @selectFile="onSelectedFile"
                label="Arrastra o Agrega tus Archivos" />
            <Center>
                <BtnSave :loading="isSubmitAction" :disabled="isSubmitAction" @click="onSaveDocuments"
                    text="SUBIR ARCHIVO" />
            </Center>
        </Modal>

        <Modal :id="idModalParticpant">


            <h3 class="card-title text-primary">
                <button class="btn btn-xs btn-circle  " @click="useCloseModal()">
                    <i class="pi pi-arrow-left" />
                </button>
                Participantes
            </h3>
            <div class="divider"></div>
            <div v-if="participants?.length">
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

        <Modal :id="idViewObservationModal">
            <button class="btn btn-xs btn-circle right-0 mb-2" @click="useCloseModal()">
                <i class="pi pi-arrow-left"></i>
            </button>
            Mensajes
            <Table>
                <THead>
                    <tr>
                        <th>
                            Personal
                        </th>
                        <th>
                            Observacion
                        </th>
                    </tr>
                </THead>
                <tbody>
                    <tr v-for="(item, k) in allObservations" :key="k">
                        <td>{{ item.personal?.nombre_compuesto }}</td>
                        <td>{{ item.s_observacion }}</td>
                    </tr>
                </tbody>

            </Table>

        </Modal>


        <Modal :id="idModalDocuments">
            <div>
                <button class="btn btn-xs btn-circle" @click="useCloseModal()">
                    <i class="pi pi-arrow-left"></i>
                </button>
                <DocumentForm :uploadFile="false" :documents="filesSelecteds" />
            </div>
        </Modal>
        <Modal :id="idModalDocumentTestimonio">
            <div>
                <button class="btn btn-xs btn-circle" @click="useCloseModal()">
                    <i class="pi pi-arrow-left"></i>
                </button>
                <DocumentForm :uploadFile="false" :documents="filesSelectedTestimonio" />
            </div>
        </Modal>


        <Galery ref="galeryComponentRef" :showItemNavigators="false" :files="fileSelected" />

        <Modal :id="idModalAsignKardex" @onCloseModal="useCloseModal()">

            <h3 class="card-title text-primary">
                <button class="btn btn-xs btn-circle right-0" @click="useCloseModal()">
                    <i class="pi pi-arrow-left"></i>
                </button>

                Asignar Kardex
            </h3>
            <div class="divider"></div>
            <ScrollView>
                <span v-if="form.num_kardex.$error?.message" class="text-xs text-error">{{ form.num_kardex.$error?.message
                }}</span>
                <div class="flex w-full">
                    <select v-model="form.cod_tramite.$value" v-if="recordsKardex?.length"
                        class="input  select input-primary">
                        <option v-for="(item, i) in recordsKardex" :key="i" :value="item.s_abre"> {{
                            item.s_abre
                        }}
                        </option>
                    </select>
                    <input v-model="form.num_kardex.$value" placeholder="N° Kardex" type="number"
                        class="w-full mx-2 input input-primary">
                </div>
                <div class="text-center my-4">
                    <btn-save @click="onSaveAsignationKardex" :disabled="isSubmitAction" :loading="isSubmitAction" />
                </div>
            </ScrollView>
        </Modal>

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
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import { configProtocolar } from "@/router/Protocolar/ProtocolarConfig";
import Button from "primevue/button";
import { useTramiteStore } from "@/store/tramite";
import { useCloseModal, useGenerateKeyRandom, useOpenModal } from "@/hooks/useUtils";
import CloudUpload from "@vicons/ionicons5/CloudUpload";
import AccountGroupOutline from "vue-material-design-icons/AccountGroupOutline.vue";
import type { IUploadFile } from "@/models/components/upload-file.interface";
import { notify } from "@kyvg/vue3-notification";
import type { HistorialTramite, ServicioNotarial } from "@/models/types";
import { useKardexExternalStore } from "@/store/external/kardex.external";


import { DocumentForm } from '../../External/Tramite/Components'
import DocumentAttachSharp from "@vicons/ionicons5/DocumentAttachSharp";
import { defineForm, field, isValidForm } from "vue-yup-form";
import * as Yup from "yup";
import { validateMaxDigits } from "@/utils/Regexs";

const { isSubmitAction, participants, recordsKardex } = toRefs(useKardexExternalStore())
const { listParticipants, saveDocuments, saveAsignationKardex, listKardexActives } = useKardexExternalStore()
const { search, pagination, isLoading, TramiteResults } = toRefs(useTramiteStore());
const { listTramite, cleanPagination, saveObservation, getAllObservationById } = useTramiteStore();
const files = ref<IUploadFile[]>([])
const filesSelecteds = ref<IUploadFile[]>([])

const idModalParticpant = useGenerateKeyRandom()
const idModalUploadFileTestimonio = useGenerateKeyRandom()
const idModalDocuments = useGenerateKeyRandom()
const idModalAsignKardex = useGenerateKeyRandom()
const idModalDocumentTestimonio = useGenerateKeyRandom()
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



const form_observacion = defineForm({
    observacion: field<string>(
        "",
        Yup.string()
            .required("es requerido")
            .max(500, "Máximo 500 caracteres")
            .nullable()
    ),
});

const form = defineForm({
    cod_tramite: field<string>(
        "",
        Yup.string()
            .required("es requerido")
            .nullable()
    ),
    num_kardex: field<number | null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("maxDigits", "Máximo de 15 dígitos permitidos.", value => {
                return validateMaxDigits(value, 15)
            })
            .positive("Numero no Válido")
            .nullable()
    )
});


const filter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination()
    await listTramite();
}




const onVieParticipant = async (payload) => {
    idSelected.value = payload.id
    useOpenModal(idModalParticpant)
    await listParticipants({
        kardex: payload.kardex,
        id: payload.id
    })

}




const onSelectedRow = (paylaod) => {
    idSelected.value = paylaod.id
    filesSelecteds.value = paylaod.files

}

const onViewDocuments = (paylaod) => {
    filesSelecteds.value = paylaod.files
    useOpenModal(idModalDocuments)
}


const onViewDocumentsTestimonio = (paylaod) => {
    filesSelectedTestimonio.value = paylaod.files_testimonio
    useOpenModal(idModalDocumentTestimonio)
}


const onAsignationKardex = (cod: number) => {
    idSelected.value = cod
    useOpenModal(idModalAsignKardex)
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
                listTramite()
            }
        } catch (e) {
            isSubmitAction.value = false
        } finally {
            isSubmitAction.value = false
        }
    }

}


const onTotalNotarial = (records: ServicioNotarial[]) => {
    if (!records.length) return
    let tot = 0
    for (let i = 0; i < records.length; i++) {
        if (records[i].s_tipo_servicio == 0) {
            tot += records[i].de_total
        }
    }
    return tot.toFixed(2);
}

const onTotalRegistral = (records: ServicioNotarial[]) => {
    if (!records.length) return
    let tot = 0
    for (let i = 0; i < records.length; i++) {
        if (records[i].s_tipo_servicio == 1) {
            tot += records[i].de_total
        }
    }
    return tot.toFixed(2);
}


const onSelectedFile = (doc) => {
    if (doc.file?.type.includes("image/")) {
        fileSelected.value = [doc.file];
        galeryComponentRef.value?.onOpen()
    } else {
        window.open(doc.file.file)
    }
}

const onUploadFileTestimonio = (payload) => {
    keyUploadFile.value = useGenerateKeyRandom()
    idSelected.value = payload.id
    useOpenModal(idModalUploadFileTestimonio)
}


const onUploadFileDocument = (payload) => {
    keyUploadFile.value = useGenerateKeyRandom()
    idSelected.value = payload.id
    useOpenModal(idModalUploadFileDocument)
}
const onSaveAsignationKardex = async () => {
    if (isValidForm(form)) {
        try {
            isSubmitAction.value = true
            const { status, message } = await saveAsignationKardex({
                cod_client: idSelected.value,
                codigo: form.cod_tramite.$value,
                number_kardex: form.num_kardex.$value,
            })
            if (status) {
                isSubmitAction.value = false
                notify({
                    title: message,
                    type: 'success'
                })
                listTramite()
                useCloseModal()
                cleanFormAssign()
            }
        } catch (e) {
            isSubmitAction.value = false
        } finally {
            isSubmitAction.value = false
        }
    }

}

const cleanFormAssign = async () => {
    form.num_kardex.$value = null
    form.cod_tramite.$value = ""
}

const onOpenObservation = (id: string) => {
    kardexSelected.value = id
    useOpenModal(idAddObservationModal)
}

const onOpenViewObservation = (id: string) => {
    kardexSelected.value = id
    useOpenModal(idViewObservationModal)
    onGetAllObservationByKardex()
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

const cleanDataObservation = () => {
    kardexSelected.value = ''
    form_observacion.observacion.$value = ''
}

onMounted(() => {
    listKardexActives()
    if (!TramiteResults.value.length) {
        listTramite();
    }
});
</script>

<template>
    <div>
        <div class="flex justify-between pt-4 pb-4 mt-4 mx-2">
            <div>
                <a role="button" class="btn btn-sm">Mis Trámites</a>
            </div>
            <div>
                <router-link to="tramite" class="btn btn-outline btn-primary btn-sm">NUEVO TRÁMITE</router-link>
            </div>
        </div>
        
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
        <Table v-if="!isLoading">
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
                    <th>OBSERVACION</th>
                    <th>ESTATUS</th>
                </tr>
            </THead>
            <tbody>
                <tr class="cursor-pointer hover:bg-gray-200"  
                    v-for="(item, key) in recordsClients" :key="key" >
                    <td @click.stop class="flex actions">

                        <ToolTip v-if="item?.kardex" text="Ver Participantes" position="right">
                            <button @click="onViewParticipant(item)" class="btn btn-circle btn-xs btn-ghost text-primary ">
                                <AccountGroupOutline />
                            </button>
                        </ToolTip>
                        <ToolTip text="Adjuntar Documentos" position="right">
                            <button @click="onUploadFileDocument(item)"
                                class="btn btn-circle btn-xs btn-ghost text-primary ">
                                <CloudUpload class="w-8  text-primary cursor-pointer" />
                            </button>
                        </ToolTip>

                        <ToolTip text="Ver Documentos" position="right">
                            <button @click="onViewDocuments(item)" class="btn btn-circle btn-xs btn-ghost text-primary ">
                                <i class="pi pi-file-import text-lg text-success cursor-pointer"></i>
                            </button>
                        </ToolTip>

                        <ToolTip text="Ver Estado Registral" position="right">
                            <button @click="onSelectedRowEstadoRegistral(item.id)" class="btn btn-circle btn-xs btn-ghost text-primary ">
                                <i class="pi pi-file text-lg text-primary cursor-pointer"></i>
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
                    <td class="text-end">
                        <button @click="onSelectedRowNotarial(item.id)"
                            class="btn btn-xs btn-outline btn-success">VER
                        </button>
                    </td>
                    <td class="text-end">
                        <button @click="onSelectedRowRegistral(item.id)" class="btn btn-xs btn-outline btn-success">VER</button>
                    </td>
                    <td>{{ item?.detalle_kardex?.d_fechescritura }}</td>
                    <td> {{ item?.is_date_mayor }}</td>
                    <td class="actions  ">

                        <div v-if="item?.kardex">
                            <ToolTip text="Agregar Mensaje">
                                <button @click="onOpenObservation(item.kardex)" class="btn btn-xs btn-circle btn-ghost"><i
                                        class="text-primary pi pi-comment"></i></button>
                            </ToolTip>

                            <ToolTip text="Ver Mensajes">
                                <button @click="onOpenViewObservation(item.kardex)"
                                    class="btn btn-xs btn-circle  btn-ghost"><i
                                        class="text-success pi pi-comments"></i></button>
                            </ToolTip>

                        </div>
                    </td>
                    <td> <span v-if="item?.detalle_kardex?.i_estadonota" class="btn btn-outline btn-xs btn-success">{{
                        getStatus(item?.detalle_kardex?.i_estadonota) }}</span> </td>
                </tr>
            </tbody>
        </Table>
        <div class="mx-4">
            <Paginate v-if="recordsClients?.length && !isLoading" :pagination="pagination" @paginate="listProcedure()" />
        </div>
        <Skeleton v-if="isLoading" :tipo="2" />

        <Modal :id="idModalDocumentTestimonio">
            <button class="btn btn-xs  btn-circle" @click="$router.back()">
                <i class="pi pi-arrow-left" />
            </button>
            Testimonio Digital
            <UploaderFiles documentType="testimonio" :key="keyUploadFile" :files="files" :multiple="true"  
                :maxFiles="4" maxFileSize="15MB" maxTotalFileSize="60MB"   
                accept="image/* , application/pdf,.docx, .xlsx" @selectFile="onSelectedFile" label="Arrastra o Agrega tus Archivos" />
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
            <UploaderFiles documentType="varios" :key="keyUploadFile" :files="files" :multiple="true"  
                :maxFiles="4" maxFileSize="15MB" maxTotalFileSize="60MB"  
                accept="image/* , application/pdf, ,.docx, .xlsx" @selectFile="onSelectedFile" label="Arrastra o Agrega tus Archivos" />
            <Center>
                <BtnSave :loading="isSubmitAction" :disabled="isSubmitAction" @click="onSaveDocuments"
                    text="SUBIR ARCHIVO" />
            </Center>
        </Modal>

        <Modal :id="idModalParticpant">
            <h3 class="card-title text-primary">
                <button class="btn btn-xs btn-circle  " @click="$router.back()">
                    <i class="pi pi-arrow-left"></i>
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

        <Modal :id="idModalServicioNotarial">
            <h3 class="card-title text-primary">
                <button class="btn btn-xs btn-circle right-0" @click="useCloseModal()">
                    <i class="pi pi-arrow-left"></i>
                </button>
                Servicio Notarial
            </h3>
            <div class="divider"></div>
            <div v-if="recordsRegisterPublics?.servicio_notarial?.length">
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
                            <td> {{ item.de_precio }}</td>
                            <td>{{ item.de_total }}</td>
                        </tr>
                        <tr>
                            <td colspan="4">TOTAL <span class="badge badge-outline badge-success">{{
                                onTotalNotarial(recordsRegisterPublics.servicio_notarial)
                            }}</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </Modal>
        <Modal :id="idModalServicioRegistral">
            <h3 class="card-title text-primary">
                <button class="btn btn-xs btn-circle right-0" @click="useCloseModal()">
                    <i class="pi pi-arrow-left"></i>
                </button>
                Servicio Registral
            </h3>
            <div class="divider"></div>
            <div v-if="recordsRegisterPublics?.servicio_registral?.length">
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
                        <tr v-for="(item, key) in recordsRegisterPublics?.servicio_registral" :key="key">
                            <td>{{ item?.servicio?.s_nombre }}</td>
                            <td>{{ item.i_cantidad }}</td>
                            <td> {{ item.de_precio }}</td>
                            <td>{{ item.de_total }}</td>
                        </tr>
                        <tr>
                            <td colspan="4">TOTAL <span class="badge badge-outline badge-success">{{
                                onTotalRegistral(recordsRegisterPublics.servicio_registral)
                            }}</span>
                            </td>
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
                        <td>{{ item.personal?.nombre_compuesto }} {{ item.cliente?.nombre_compuesto }} {{
                            item.empresa?.nombre_compuesto }}</td>
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
       
        <Modal :id="idModalDocuments">
            <div>
                <button class="btn btn-xs btn-circle" @click="useCloseModal()">
                    <i class="pi pi-arrow-left"></i>
                </button>
                <DocumentForm :uploadFile="false" :documents="filesSelecteds" />
            </div>
        </Modal>
        <Modal :id="idModalEstadoRegistral">
            <EstadoRegistral/>
        </Modal>
        

        <Galery ref="galeryComponentRef" :showItemNavigators="false" :files="fileSelected" />
    </div>
</template>
<script lang="ts" setup>
import EstadoRegistral from "./EstadoRegistral.vue"
import { onMounted, ref, toRefs } from "vue";
import {
    Center,
    BtnSave,
    Table,
    THead,
    Paginate,
    Skeleton,
    ToolTip,
    UploaderFiles, Galery,
    Modal,
    TextArea,
    TextInputSearch,
    Options
} from "@/components";
import AccountGroupOutline from 'vue-material-design-icons/AccountGroupOutline.vue'
import { useCloseModal, useGenerateKeyRandom, useOpenModal } from "@/hooks/useUtils";
import type { HistorialTramite, ServicioNotarial } from "@/models/types";
import { useClientExternalStore } from "@/store/external/client.external";
import { useKardexExternalStore } from "@/store/external/kardex.external";
import { defineForm, field, isValidForm } from "vue-yup-form";
import * as Yup from "yup";
import { notify } from "@kyvg/vue3-notification";
import type { IUploadFile } from "@/models/components/upload-file.interface";
import Button from "primevue/button";
import { useTramiteStore } from "@/store/tramite";
import CloudUpload from "@vicons/ionicons5/CloudUpload";
import { DocumentForm } from '../../../External/Tramite/Components'
import { debounce } from "@/utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";


const files = ref<IUploadFile[]>([])
const { isLoading, pagination, recordsClients, recordsRegisterPublics, search } = toRefs(useClientExternalStore())
const { listProcedure, cleanPagination} = useClientExternalStore()
const { isSubmitAction, participants } = toRefs(useKardexExternalStore())
const { listParticipants, saveDocuments } = useKardexExternalStore()
const { saveObservation, getAllObservationById } = useTramiteStore();


const idModalParticpant = useGenerateKeyRandom()
const idModalServicioNotarial = useGenerateKeyRandom()
const idModalServicioRegistral = useGenerateKeyRandom()
const idModalDocumentTestimonio = useGenerateKeyRandom()
const idModalUploadFileDocument = useGenerateKeyRandom()
const idModalDocuments = useGenerateKeyRandom()
const idModalEstadoRegistral = useGenerateKeyRandom()

const fileSelected = ref<IUploadFile[]>([]);
const idSelected = ref<number>(0)
const keyUploadFile = ref<string>('')
const galeryComponentRef = ref<any>(null);
const idAddObservationModal = useGenerateKeyRandom()
const idViewObservationModal = useGenerateKeyRandom()
const isLoadingAllObservation = ref<boolean>(false)
const allObservations = ref<HistorialTramite[]>([]);
const isSaveObservation = ref<boolean>(false)
const kardexSelected = ref<string>('')
const emit = defineEmits(['onSelectedRow'])
const filesSelecteds = ref<IUploadFile[]>([])


const form_observacion = defineForm({
    observacion: field<string>(
        "",
        Yup.string()
            .required("es requerido")
            .max(500, "Máximo 500 caracteres")
            .nullable()
    ),
});

 


const onViewParticipant = async (payload) => {
    idSelected.value = payload.id
    useOpenModal(idModalParticpant)
    await listParticipants({
        kardex: payload.kardex,
        id: payload.id
    })

}
 
 
const onSelectedRowEstadoRegistral = (id: number) => {
    idSelected.value = id
    emit('onSelectedRow', id)
    useOpenModal(idModalEstadoRegistral)
}
const onSelectedRowNotarial = (id: number) => {
    idSelected.value = id
    emit('onSelectedRow', id)
    useOpenModal(idModalServicioNotarial)
}

const onSelectedRowRegistral = (id: number) => {
    idSelected.value = id
    emit('onSelectedRow', id)
    useOpenModal(idModalServicioRegistral)
}





const onSaveDocuments = async () => {
    if (files.value.length) {
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
                listProcedure()
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
    files.value = []
    keyUploadFile.value = useGenerateKeyRandom()
    idSelected.value = payload.id
    useOpenModal(idModalDocumentTestimonio)
}

const onUploadFileDocument = (payload) => {
    files.value = []
    keyUploadFile.value = useGenerateKeyRandom()
    idSelected.value = payload.id
    useOpenModal(idModalUploadFileDocument)
}


const onViewRegistral = () => {
    useOpenModal(idModalServicioRegistral)
}

const getStatus = (status: string) => {
    switch (status) {
        case '4':
            return "Concluido"
        case '5':
            return "Calificado"
        case '6':
            return "Ingresado"
        case '1':
            return "Ingresado"

    }
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

const onViewDocuments = (paylaod) => {
    filesSelecteds.value = paylaod.files
    useOpenModal(idModalDocuments)
}



const cleanDataObservation = () => {
    kardexSelected.value = ''
    form_observacion.observacion.$value = ''
}

const filter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination()
    await listProcedure();
}



onMounted(() => {
    listProcedure()
})
</script>

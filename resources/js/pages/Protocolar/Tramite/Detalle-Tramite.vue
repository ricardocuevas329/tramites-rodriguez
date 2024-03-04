<template>
    <div class="grid gap-2 my-4 border p-4">
        <div class="flex items-center justify-between">
            <p>Detalle</p>
        </div>
    </div>
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

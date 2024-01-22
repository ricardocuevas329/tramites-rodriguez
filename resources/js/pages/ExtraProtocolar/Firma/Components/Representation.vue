<template>
    <Modal :id="idModal">
        <Title>
            <BtnBack @click="useCloseModal()"/>
            EN REPRESENTACION DE
        </Title>
        <ScrollView>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <InputSelect
                    :items="TipoDocumentsCompanies"
                    label="Documento"
                    v-model="form.id_tipo_documento.$value"
                    :validate-error="isSubmit"
                    :error-message="form.id_tipo_documento.$error?.message"
                    label-data="s_abrev"
                    value-data="s_codigo"
                    id="representation.id_tipo_documento"
                    @input="onFocusInput('representation.s_num_doc')"
                />

                <Row>
                    <TextInputNumber
                        label="Numero"
                        v-model="form.s_num_doc.$value"
                        id="representation.s_num_doc"
                        :validate-error="isSubmit"
                        :error-message="form.s_num_doc.$error?.message"
                        @keyup.enter="onFocusInput('representation.s_paterno')"
                        @onClear="onCleanClient()"
                    />
                    <ToolTip text="Buscar Participante">
                        <button :disabled="isSubmitFindByDocument" @click="onFindByDocument()"
                                class="btn btn-sm btn-circle mt-6 ">
                            <MagnifyingGlassIcon/>
                        </button>
                    </ToolTip>
                </Row>
            </div>


            <div class="mx-2 mb-2 font-mono border rounded border-primary p-2" v-if="company && form.s_cliente.$value">
                Nombre: <span class="  badge badge-sm badge-md badge-ghost badge-primary">{{
                    company?.nombre_compuesto
                }}</span>
                <br>
                N° Documento: <span class="badge badge-sm badge-md badge-ghost badge-primary">{{
                    company?.s_num_doc
                }}</span>
                <br>
                Partida: <span class="badge badge-sm badge-md badge-ghost badge-primary">{{
                    form.s_partida.$value
                }}</span>
                <br>
                Registro de: <span class="badge badge-sm badge-md badge-ghost badge-primary">{{
                    form.s_registro.$value
                }}</span>
                <br>
                Oficina Registral: <span class="badge badge-sm badge-md badge-ghost badge-primary">{{
                    form.s_oficina.$value
                }}</span>
            </div>

            <TextArea
                label="Observacion"
                v-model="form.s_observacion.$value"
                id="representation.s_observacion"
                :validate-error="isSubmit"
                :error-message="form.s_observacion.$error?.message"
            />
        </ScrollView>
        <Center>
            <BtnSave :loading="isSubmitRepresentation" :disabled="isSubmitRepresentation" @click="onSubmit"
                     class="btn   btn-md btn-primary" text="Guardar">
                <template v-slot:icon>
                    <ContentSave class="w-4"/>
                </template>
            </BtnSave>
        </Center>
    </Modal>
</template>
<script setup lang="ts">
import {useCloseModal} from "@/hooks/useUtils";
import {BtnBack, BtnSave, Center, InputSelect, Modal, Row, ScrollView, Title} from "@/components";
import ContentSave from "vue-material-design-icons/ContentSave.vue";
import {onMounted, type PropType, ref, toRefs} from "vue";
import ToolTip from "@/components/ToolTip.vue";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import {useTipoDocumentoStore} from "@/store/tipo-documento";
import {defineForm, field, isValidForm} from "vue-yup-form";
import * as Yup from "yup";
import {useEmpresaStore} from "@/store/empresa";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import type {Empresa, Firma} from "@/models/types";
import TextInputNumber from "@/components/TextInputNumber.vue";
import TextArea from "@/components/TextArea.vue";
import {useFirmaStore} from "@/store/firma";
import {notify} from "@kyvg/vue3-notification";


const {saveSignaturePresentation, getSignatureRepresentationById} = useFirmaStore()

const props = defineProps({
    idModal: {
        required: true,
        type: String,
    },
    signature: {
        default: {},
        required: true,
        type: Object as PropType<Firma>,
    }
})

const {signature} = toRefs(props)

const isSubmit = ref<boolean>(false);
const isSubmitFindByDocument = ref<boolean>(false);
const {TipoDocumentsCompanies} = toRefs(useTipoDocumentoStore());
const {findEmpresaDocument} = useEmpresaStore();
const {onFocusInput} = useInputsEvents()
const company = ref<Empresa | null>();
const isSubmitRepresentation = ref<boolean>(false);

const form = defineForm({
    id_tipo_documento: field<string | null>("", Yup.string().required("es requerido").max(10, "Maximo 10 caracteres").nullable()),
    s_num_doc: field<number | null>(null, Yup.number().required("es requerido").transform((value) => Number.isNaN(value) ? null : value)
        .positive("Numero no Válido").nullable()),
    s_partida: field<number | null>(null, Yup.number().transform((value) => Number.isNaN(value) ? null : value)
        .positive("Numero no Válido").nullable()),
    s_registro: field<string | null>("", Yup.string().nullable()),
    s_oficina: field<string | null>("", Yup.string().nullable()),
    s_observacion: field<string | null>("", Yup.string().max(250, "Maximo 250 caracteres").nullable()),
    s_cliente: field<string | null>("", Yup.string().required("es requerido").nullable()),

})

const onFindByDocument = async () => {
    let id_doc = form.id_tipo_documento.$value
    let num_doc = form.s_num_doc.$value
    if (id_doc && num_doc) {

        try {
            isSubmitFindByDocument.value = true
            const {status, Empresa, message} = await findEmpresaDocument(id_doc, num_doc)
            if (status) {
                setEmpresaInfo(Empresa)
            }
        } catch (e) {
            setEmpresaInfo({})
        } finally {
            setTimeout(() => {
                isSubmitFindByDocument.value = false
            }, 1300)
        }
    }
}

const onSubmit = async () => {
    isSubmit.value = true
    if (!form.s_cliente.$value) {
        await onFindByDocument()
    }

    if (isValidForm(form)) {
        try {
            isSubmitRepresentation.value = true
            const {status, message} = await saveSignaturePresentation({
                s_representado: signature.value?.s_codigo,
                s_cliente: form.s_cliente.$value,
                s_observacion: form.s_observacion.$value,
            })
            if (status) {
                notify({
                    title: message,
                    type: 'success'
                })
                getSignatureRepresentationById(signature.value.s_codigo)
                onCleanForm()
                useCloseModal()
            }

        } catch (e) {

        } finally {
            setTimeout(() => {
                isSubmitRepresentation.value = false
            }, 1200)
        }

    }
}

const onCleanForm = () => {
    form.id_tipo_documento.$value = ""
    form.s_num_doc.$value = null
    form.s_partida.$value = null
    form.s_registro.$value = ""
    form.s_oficina.$value = ""
    form.s_observacion.$value = ""
    form.s_cliente.$value = ""
    onCleanClient()
}

const setEmpresaInfo = (payload: Empresa) => {
    company.value = payload
    form.s_cliente.$value = payload.s_codigo
    form.s_partida.$value = payload.s_partida ? parseInt(payload.s_partida) : null
    form.s_oficina.$value = payload?.oficina_registral?.s_nombre
    form.s_registro.$value = payload?.estado?.s_desc
}

const onCleanClient = () => {
    company.value = null
    form.s_cliente.$value = ''
}

onMounted(() => {
    onCleanForm()
})

</script>

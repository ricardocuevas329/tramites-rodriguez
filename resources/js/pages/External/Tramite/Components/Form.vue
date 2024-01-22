<script setup lang="ts">
import {ref, toRefs} from "vue";
import {useTipoDocumentoExternalStore} from "@/store/external/tipo-documento.external";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as Yup from "yup";
import {RegExps, validateMaxDigits} from "@/utils/Regexs";
import LabelError from "@/components/LabelError.vue";
import {useClientExternalStore} from "@/store/external/client.external";
import ArrowLeft from "vue-material-design-icons/ArrowLeft.vue"
import {Head, BtnSave} from "@/components";
import TabView from 'primevue/tabview';
import TabPanel from 'primevue/tabpanel';
import { DocumentForm } from './Index'


const {isLoading} = toRefs(useClientExternalStore())
const {TipoDocumentos} = toRefs(useTipoDocumentoExternalStore())
const submitForm = ref<boolean>(false)
const refDocumentForm = ref<any>(null)

const form = defineForm({
    tipo_documento: field<string | number | null | undefined>(
        "",
        Yup.string()
            .required("requerido")
            .max(50, "Máximo 50 caracteres")
            .nullable()
    ),
    numero_documento: field<number | null | undefined>(
        null,
        Yup.number()
            .required("requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("maxDigits", "Máximo 11 dígitos permitidos.", value => {
                return validateMaxDigits(value, 11)
            })
            .positive("Numero no Válido")
            .nullable()
    ),
    apellido_materno: field<string | null | undefined>(
        "",
        Yup.string()
            .matches(RegExps.compositeName, {
                excludeEmptyString: true,
                message: "Apellido no válido",
            })
            .min(3, "Minimo 3")
            .max(100, "Máximo 100 caracteres")
            .nullable()
    ),
    apellido_paterno: field<string | null | undefined>(
        "",
        Yup.string()
            .required("requerido")
            .matches(RegExps.compositeName, {
                excludeEmptyString: true,
                message: "Apellido no válido",
            })
            .min(3, "Minimo 3")
            .max(100, "Máximo 100 Caracteres")
            .nullable()
    ),

    nombres: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, {
                excludeEmptyString: true,
                message: "Nombre no válido",
            })
            .min(3, "minimo 3")
            .max(70, "máximo 70 caracteres")
            .nullable()
    ),


});

const emit = defineEmits(["onSubmit"])

const onSubmit = () => {
    submitForm.value = true
    if (isValidForm(form)) {
        let formData = {
            documents: refDocumentForm.value.files,
            ...toObject(form)
        }
        emit("onSubmit", formData)
    }
}
</script>

<template>
    <div class="my-4">
        <Head>
            <template v-slot:start>
                  <span @click="$router.back()" class="text-primary btn btn-circle btn-ghost btn-md"><ArrowLeft/></span>
            </template>
            <template v-slot:center>
                <h3 class="text-primary">NUEVO REGISTRO</h3>
            </template>
        </Head>
        <div>
            <TabView>
                <TabPanel  header="Completar Datos">
                    <div class="grid text-xs relative grid-cols-2 md:grid-col-2 mx-4 md:mx-8 gap-2  ">
                        <label class="">Tipo Documento
                            <LabelError v-if="form.tipo_documento.$errorMessages.length && submitForm" full>
                                *{{ form.tipo_documento.$error?.message }}
                            </LabelError>
                        </label>
                        <select v-model="form.tipo_documento.$value" v-if="TipoDocumentos.length"
                                class="input  select input-primary">
                            <option v-for="(item, i) in TipoDocumentos" :key="i" :value="item.s_codigo"> {{ item.s_abrev }}</option>
                        </select>
                        <label for="">Numero Documento
                            <LabelError v-if="form.numero_documento.$errorMessages.length && submitForm" full>
                                *{{ form.numero_documento.$error?.message }}
                            </LabelError>
                        </label>
                        <input v-model="form.numero_documento.$value" type="number" class="input input-primary">
                        <label for="">AP. Paterno
                            <LabelError v-if="form.apellido_materno.$errorMessages.length && submitForm " full>
                                *{{ form.apellido_materno.$error?.message }}
                            </LabelError>
                        </label>
                        <input v-model="form.apellido_materno.$value" class="input input-primary">
                        <label for="">AP. Materno
                            <LabelError v-if="form.apellido_paterno.$errorMessages.length && submitForm" full>
                                *{{ form.apellido_paterno.$error?.message }}
                            </LabelError>
                        </label>
                        <input v-model="form.apellido_paterno.$value" class="input input-primary">
                        <label for="">Nombres
                            <LabelError v-if="form.nombres.$errorMessages.length && submitForm" full>
                                *{{ form.nombres.$error?.message }}
                            </LabelError>
                        </label>
                        <input v-model="form.nombres.$value" class="input input-primary">
                    </div>
                </TabPanel>
                <TabPanel header="Documentos">
                   <DocumentForm  ref="refDocumentForm"/>
                </TabPanel>

            </TabView>
        </div>


        <div class="text-center my-4">
            <btn-save @click="onSubmit" :disabled="isLoading"  :loading="isLoading"/>
        </div>
    </div>
</template>


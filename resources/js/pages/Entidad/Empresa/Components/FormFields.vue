<template>
    <div>
        <ScrollView>
            <TextInput
                label="Nombres"
                v-model="form.s_nombre.$value"
                :error-message="isSubmit && form.s_nombre.$error?.message"
            />

            <div class="grid grid-cols-1 md:grid-cols-2">
                <InputSelect
                    :items="TipoDocumentsCompanies"
                    label="Tipo Documento"
                    v-model="form.s_tip_doc.$value"
                    :error-message="isSubmit && form.s_tip_doc.$error?.message"
                    label-data="s_abrev"
                    value-data="s_codigo"
                />
                <TextInput
                    label="Documento"
                    v-model="form.s_num_doc.$value"
                    :error-message="isSubmit && form.s_num_doc.$error?.message"
                />
            </div>

            <TextInput
                label="Dirección"
                v-model="form.s_direccion.$value"
                :error-message="isSubmit && form.s_direccion.$error?.message"
            />

            <TextInput type="email"
                label="Correo"
                v-model="form.s_email.$value"
                :error-message="isSubmit && form.s_email.$error?.message"
            />


        </ScrollView>
        <Center>
            <BtnSave :disabled="disabled" @click="onSubmit" />
        </Center>
    </div>
</template>
<script setup lang="ts">
import {
    BtnSave,
    Center,
    ScrollView,
    TextInput,
    InputSelect,
Row,
} from "../../../../components";
import * as Yup from "yup";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { RegExps } from "../../../../utils/Regexs";
import { type PropType, toRefs, watchEffect, ref } from 'vue';
import { useTipoDocumentoStore } from "../../../../store/tipo-documento";
import type { Empresa } from "@/models/types";

const isSubmit = ref<string>('');


const {TipoDocumentsCompanies} = toRefs(useTipoDocumentoStore());

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Empresa>,
    },
});



const form = defineForm({
    s_nombre: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(200, "máximo 200 caracteres")
    ),

    s_tip_doc: field<string | null | undefined>(
        "",
             Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres")
    ),
    s_num_doc: field<string | null | undefined>(
        "",
            Yup.string()
            .required("es requerido")
            .matches(RegExps.isNumeric, "Documento no válido")
            .min(8, "minimo 8")
            .max(12, "máximo 12 caracteres")
    ),
    s_direccion: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(4, "minimo 4")
            .max(150, "máximo 150 caracteres")
    ),
    s_email: field<string | null | undefined>(
        "",
        Yup.string()
            .email("Email inVálido")
            .max(100, "máximo 100 caracteres")
            .nullable()
    ),


});


const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    isSubmit.value = 'submit'
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: Empresa) => {
    form.s_nombre.$value = data.s_nombre;
    form.s_direccion.$value = data.s_direccion;
    form.s_email.$value = data.s_email;
    form.s_tip_doc.$value = data.s_tip_doc
    form.s_num_doc.$value = data.s_num_doc


 };

watchEffect(() => {

    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

<template>
    <div>
        <ScrollView>

            <div class="grid grid-cols-1 md:grid-cols-2">
            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :error-message="form.s_nombre.$error?.message"
            />

            <TextInput
                label="Abreviatura"
                v-model="form.s_abrev.$value"
                :error-message="form.s_abrev.$error?.message"
            />
            </div>

            <TextInput
                label="Impresora"
                v-model="form.s_impresora.$value"
                :error-message="form.s_impresora.$error?.message"
            />

            <TextInput
                label="Serie"
                v-model="form.s_serie.$value"
                :error-message="form.s_serie.$error?.message"
            />

            <TextInput
                label="Tipo Comprobante"
                v-model="form.id_tipo_comprobante.$value"
                :error-message="form.id_tipo_comprobante.$error?.message"
                type="number"
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
} from "../../../../components";
import * as Yup from "yup";
import { defineForm , field, isValidForm, toObject } from "vue-yup-form";
import {toRefs, watchEffect } from "vue";
import type { PropType } from "vue";
import type {  DocumentoVenta } from "@/models/types";
import { RegExps } from '../../../../utils/Regexs';

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<DocumentoVenta>,
    },
});

const form = defineForm({
    s_nombre: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2")
            .max(50, "máximo 50 caracteres")
    ),
    s_abrev: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1 caracteres")
            .max(6, "máximo 6 caracteres")
    ),
    s_serie: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1 caracteres")
            .max(7, "máximo 7 caracteres")
    ),
    s_impresora: field<string| null | undefined>(
        "",
        Yup.string()
            //.required("es requerido")
            //.min(1, "minimo 1")
            .max(100, "máximo 100 caracteres")
            .nullable()
    ),
    id_tipo_comprobante: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(
                RegExps.isNumeric,
                {
                    excludeEmptyString: true,
                    message: "No válido",
                })
            .min(1, "minimo 1")
            .max(10, "máximo 10 caracteres")
    ),


});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (payload: DocumentoVenta) => {
        if(payload){
        form.s_nombre.$value = payload.s_nombre;
        form.s_abrev.$value = payload.s_abrev;
        form.s_impresora.$value = payload.s_impresora;
        form.s_serie.$value = payload.s_serie;
        form.id_tipo_comprobante.$value = payload.id_tipo_comprobante?.toString();
  }


};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

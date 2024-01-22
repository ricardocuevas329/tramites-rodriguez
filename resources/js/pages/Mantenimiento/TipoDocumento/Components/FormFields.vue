<template>
    <div>
        <ScrollView>
            <div class="grid grid-cols-1 md:grid-cols-2">
            <TextInput
                label="SBS"
                v-model="form.s_codigo_sbs.$value"
                :is-danger="!!form.s_codigo_sbs.$error"
                :error-message="form.s_codigo_sbs.$error?.message"
            />

            <TextInput
                label="CNL"
                v-model="form.s_cod_cnl.$value"
                :is-danger="!!form.s_cod_cnl.$error"
                :error-message="form.s_cod_cnl.$error?.message"
            />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :is-danger="!!form.s_nombre.$error"
                :error-message="form.s_nombre.$error?.message"
            />

            <TextInput
                label="ABREVIATURA"
                v-model="form.s_abrev.$value"
                :is-danger="!!form.s_abrev.$error"
                :error-message="form.s_abrev.$error?.message"
            />
            </div>

            <TextInput
                label="DIGITOS"
                type="text"
                :maxLength="3"
                v-model="form.i_digitos.$value"
                :is-danger="!!form.i_digitos.$error"
                :error-message="form.i_digitos.$error?.message"
            />

            <TextInput
                label="TIPO FE"
                v-model="form.s_tipoFe.$value"
                :is-danger="!!form.s_tipoFe.$error"
                :error-message="form.s_tipoFe.$error?.message"
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
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { RegExps } from "../../../../utils/Regexs";
import { type PropType, toRefs, watchEffect } from "vue";
import type { TipoDocumento } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<TipoDocumento>,
    },
});

const form   = defineForm({
    s_codigo_sbs: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(2, "máximo 2 caracteres")
    ),
    s_cod_cnl: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(2, "máximo 2 caracteres")
    ),
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
            .min(2, "minimo 2 caracteres")
            .max(7, "máximo 7 caracteres")
    ),
    i_digitos: field<number | null | undefined>(
        0,
        Yup.string()
            .matches(RegExps.isNumeric, {
                excludeEmptyString: true,
                message: "Numero no válido",
            })
            .max(10, "maximo 10 digitos")
            .nullable()
    ),
    s_tipoFe: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(1, "máximo 1 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: TipoDocumento) => {
        form.s_codigo_sbs.$value = data.s_codigo_sbs;
        form.s_cod_cnl.$value = data.s_cod_cnl;
        form.s_nombre.$value = data.s_nombre;
        form.s_abrev.$value = data.s_abrev;
        form.i_digitos.$value = data.i_digitos;
        form.s_tipoFe.$value = data.s_tipoFe;
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

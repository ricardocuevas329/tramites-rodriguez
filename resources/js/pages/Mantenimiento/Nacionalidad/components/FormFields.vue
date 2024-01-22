<template>
    <div>
        <ScrollView>
            <TextInput label="País" v-model="form.s_pais.$value"
                :error-message="form.s_pais.$error?.message" />

            <TextInput label="Gentilicio" v-model="form.s_gentilicio.$value"
                :error-message="form.s_gentilicio.$error?.message" />

            <TextInput label="Codigo SBS" v-model="form.s_codigo_sbs.$value"
                :error-message="form.s_codigo_sbs.$error?.message" />

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
import { type PropType, toRefs, watchEffect } from "vue";
import type { Nacionalidad } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Nacionalidad>,
    },
});

const form = defineForm({
    s_pais: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(50, "máximo 50 caracteres")
            .nullable()

    ),

    s_codigo_sbs: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(3, "máximo 3 caracteres")
            .nullable()
    ),

    s_gentilicio: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(50, "máximo 50 caracteres")
            .nullable()

    ),

});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: Nacionalidad) => {
    form.s_pais.$value = data.s_pais ;
    form.s_codigo_sbs.$value = data.s_codigo_sbs;
    form.s_gentilicio.$value = data.s_gentilicio;
   };

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

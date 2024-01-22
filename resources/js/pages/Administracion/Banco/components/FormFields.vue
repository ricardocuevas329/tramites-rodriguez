<template>
    <div>
        <ScrollView :distance="40">
            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :error-message="form.s_nombre.$error?.message"
                :validateError="isSubmit"
            />

            <TextInput
                label="PDT"
                v-model="form.s_cod_pdt.$value"
                :error-message="form.s_cod_pdt.$error?.message"
                :validateError="isSubmit"
            />

            <TextInput
                label="CNL"
                v-model="form.s_cod_cnl.$value"
                :validateError="isSubmit"
                :error-message="form.s_cod_cnl.$error?.message"
            />

            <TextInput
                label="ABREVIATURA"
                v-model="form.s_abrev.$value"
                :validateError="isSubmit"
                :error-message="form.s_abrev.$error?.message"
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
} from "@/components";
import * as Yup from "yup";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import {type PropType, ref, toRefs, watchEffect} from "vue";
import type { Banco } from "@/models/types";

const isSubmit = ref<boolean>(false)
const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Banco>,
    },
});

const form = defineForm({

    s_abrev: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2 caracteres")
            .max(5, "máximo 5 caracteres")
    ),
    s_cod_cnl: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1 caracteres")
            .max(5, "máximo 5 caracteres")
    ),
    s_cod_pdt: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1 caracteres")
            .max(5, "máximo 5 caracteres")
    ),
    s_nombre: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(50, "máximo 50 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    isSubmit.value = true
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: Banco) => {
    form.s_cod_pdt.$value = data.s_cod_pdt;
    form.s_cod_cnl.$value = data.s_cod_cnl;
    form.s_nombre.$value = data.s_nombre;
    form.s_abrev.$value = data.s_abrev;
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

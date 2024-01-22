<template>
    <div>
        <ScrollView>
            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :is-danger="!!form.s_nombre.$error"
                :error-message="form.s_nombre.$error?.message"
            />
            <TextInput
                label="Descripcion"
                v-model="form.s_descripcion.$value"
                :is-danger="!!form.s_descripcion.$error"
                :error-message="form.s_descripcion.$error?.message"
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
import { type PropType, toRefs, watchEffect } from "vue";
import type { Bien } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Bien>,
    },
});

const form = defineForm({
    s_nombre: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3 caracteres")
            .max(60, "máximo 60")
    ),
    s_descripcion: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(250, "máximo 250 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: Bien) => {
    form.s_nombre.$value = data.s_nombre;
    form.s_descripcion.$value = data.descripcion;
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

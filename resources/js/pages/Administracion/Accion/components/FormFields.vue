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
            <TextInput
                label="Codigo Personal"
                v-model="form.s_codper.$value"
                :is-danger="!!form.s_codper.$error"
                :error-message="form.s_codper.$error?.message"
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
import type { PropType } from "vue";
import { toRefs, watchEffect } from "vue";
import type { Accion } from "../../../../models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Accion>,
    },
});

const form = defineForm({
    s_nombre: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2")
            .max(50, "máximo 50 caracteres")
    ),
    s_descripcion: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2 caracteres")
            .max(100, "máximo 100 caracteres")
    ),
    s_codper: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(4, "minimo 4 caracteres")
            .max(4, "máximo 4 caracteres")
    ),


});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: Accion) => {
    form.s_nombre.$value = data.s_nombre;
    form.s_descripcion.$value = data.s_descripcion;
    form.s_codper.$value = data.s_codper;
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

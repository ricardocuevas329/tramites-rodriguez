<template>
    <div>
        <ScrollView>
            <TextInput
                label="Nombre"
                v-model="form.nombre.$value"
                :is-danger="!!form.nombre.$error"
                :error-message="form.nombre.$error?.message"
            />

            <TextInput
                label="CNL"
                v-model="form.id_cnl.$value"
                :is-danger="!!form.id_cnl.$error"
                :error-message="form.id_cnl.$error?.message"
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
import type { Condicion } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Condicion>,
    },
});

const form = defineForm({
    nombre: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3 caracteres")
            .max(60, "máximo 60 caracteres").nullable()
    ),
    id_cnl: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(4, "máximo 4 caracteres").nullable()
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: Condicion) => {
    form.nombre.$value = data.nombre;
    form.id_cnl.$value = data.id_cnl;
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

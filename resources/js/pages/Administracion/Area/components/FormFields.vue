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
                v-model="form.s_descarea.$value"
                :is-danger="!!form.s_descarea.$error"
                :error-message="form.s_descarea.$error?.message"
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
import type { Area } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Area>,
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
    s_descarea: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2 caracteres")
            .max(7, "máximo 7 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: Area) => {
    form.s_nombre.$value = data.s_nombre;
    form.s_descarea.$value = data.s_descarea;
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

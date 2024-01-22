<template>
    <div>
        <ScrollView>



            <TextInput
                label="Codigo PDT"
                v-model="form.s_codigo_pdt.$value"
                :error-message="form.s_codigo_pdt.$error?.message"
            />

            <TextInput
                label="Codigo SBS"
                v-model="form.s_codigo_sbs.$value"
                :error-message="form.s_codigo_sbs.$error?.message"
            />

            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :error-message="form.s_nombre.$error?.message"
            />

            <TextInput
                label="Descripcion"
                type="text"
                v-model="form.s_descripcion.$value"
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
import { defineForm , field, isValidForm, toObject } from "vue-yup-form";
import {toRefs, watchEffect } from "vue";
import type { PropType } from "vue";
import type {  ModoPago } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<ModoPago>,
    },
});

const form = defineForm({

    s_codigo_pdt: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(5, "máximo 5 caracteres")
    ),

    s_codigo_sbs: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(2, "máximo 2 caracteres")
    ),

    s_nombre: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(120, "máximo 120 caracteres")
    ),

    s_descripcion: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(150, "máximo 150 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (payload: ModoPago) => {
        if(payload){
        form.s_codigo_pdt.$value = payload.s_codigo_pdt;
        form.s_codigo_sbs.$value = payload.s_codigo_sbs;
        form.s_nombre.$value = payload.s_nombre;
        form.s_descripcion.$value = payload.s_descripcion;
  }


};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

<template>
    <div>
        <ScrollView>

            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :error-message="form.s_nombre.$error?.message"
            />

            <TextInput
                label="Descripcion"
                v-model="form.s_descripcion.$value"
                :error-message="form.s_descripcion.$error?.message"
            />

            <TextInput
                label="Codigo Contable"
                v-model="form.s_contable.$value"
                :error-message="form.s_contable.$error?.message"
            />

            <TextInput
                label="Tipo"
                type="text"
                :maxLength="200"
                v-model="form.s_tipo.$value"
                :error-message="form.s_tipo.$error?.message"
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
import type {  BancoDeposito } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<BancoDeposito>,
    },
});

const form = defineForm({

    s_nombre: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2")
            .max(80, "máximo 80 caracteres")
    ),
    s_contable: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(5, "minimo 5 caracteres")
            .max(10, "máximo 10 caracteres")
    ),

    s_tipo: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(1, "máximo 1 caracteres")
    ),

    s_descripcion: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(100, "máximo 100 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (payload: BancoDeposito) => {
        if(payload){
        form.s_contable.$value = payload.s_contable;
        form.s_nombre.$value = payload.s_nombre;
        form.s_tipo.$value = payload.s_tipo;
        form.s_descripcion.$value = payload.s_descripcion;

  }


};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

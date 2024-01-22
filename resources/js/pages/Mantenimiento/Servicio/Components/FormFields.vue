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
                label="Generico"
                v-model="form.s_generico.$value"
                :error-message="form.s_generico.$error?.message"
            />

            <TextInput
                label="Formato"
                type="number"
                :maxLength="10"
                v-model="form.i_formato.$value"
                :error-message="form.i_formato.$error?.message"
            />

            <TextInput
                label="Rapidos"
                type="number"
                :maxLength="10"
                v-model="form.i_rapidos.$value"
                :error-message="form.i_rapidos.$error?.message"
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
import type { Servicio } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Servicio>,
    },
});

const form = defineForm({

    s_nombre: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2")
            .max(100, "máximo 100 caracteres")
    ),

    s_descripcion: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(100, "máximo 100 caracteres")
    ),
    s_generico: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(5, "máximo 5 caracteres")
    ),

    i_formato: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(10, "máximo 10 caracteres")
    ),

    i_rapidos: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
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

const init = (payload: Servicio) => {
        if(payload){
        form.s_nombre.$value = payload.s_nombre;
        form.s_descripcion.$value = payload.s_descripcion;
        form.s_generico.$value = payload.s_generico;
        form.i_formato.$value = payload.i_formato;
        form.i_rapidos.$value = payload.i_rapidos;

  }


};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

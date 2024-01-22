<template>
    <div>
        <ScrollView>



            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :error-message="form.s_nombre.$error?.message"
            />

            <TextInput
                label="ABREVIATURA"
                v-model="form.s_abrev.$value"
                :error-message="form.s_abrev.$error?.message"
            />

            <TextInput
                label="Observacion"
                type="text"
                :maxLength="200"
                v-model="form.s_observacion.$value"
                :error-message="form.s_observacion.$error?.message"
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
import type {  Unidad } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Unidad>,
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
    s_abrev: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1 caracteres")
            .max(10, "máximo 10 caracteres")
    ),

    s_observacion: field<string| null | undefined>(
        "",
        Yup.string()
           // .required("es requerido")
            //.min(3, "minimo 3")
            .max(200, "máximo 200 caracteres")
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

const init = (payload: Unidad) => {
        if(payload){
        // form.i_estado = payload.i_estado;
        form.s_abrev.$value = payload.s_abrev;
        form.s_nombre.$value = payload.s_nombre;
        form.s_observacion.$value = payload.s_observacion;
  }


};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

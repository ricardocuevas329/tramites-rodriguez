<template>
    <div>
        <ScrollView>


            <div class="grid grid-cols-1 md:grid-cols-2">
            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :error-message="form.s_nombre.$error?.message"
            />

            <TextInput
                label="Codigo SG"
                v-model="form.s_codigo_sg.$value"
                :error-message="form.s_codigo_sg.$error?.message"
            />
            </div>

            <TextInput
                label="Tipo PDT"
                v-model="form.s_tipo_pdt.$value"
                :error-message="form.s_tipo_pdt.$error?.message"
            />
          <div class="grid grid-cols-1 md:grid-cols-2">
            <TextInput
                label="Color"
                type="color"
                v-model="form.s_color.$value"
                :error-message="form.s_color.$error?.message"
            />

            <TextInput
                label="Clase"
                type="text"
                v-model="form.s_clase.$value"
                :error-message="form.s_clase.$error?.message"
            />
          </div>

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
import type {  TipoCompareciente } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<TipoCompareciente>,
    },
});

const form = defineForm({

    s_nombre: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2")
            .max(255, "máximo 255 caracteres")
    ),
    s_codigo_sg: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(50, "máximo 50 caracteres")
    ),

    s_tipo_pdt: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(50, "máximo 50 caracteres")
    ),

    s_color: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(255, "máximo 255 caracteres")
    ),

    s_clase: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
            .max(11, "máximo 11 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (payload: TipoCompareciente) => {
        if(payload){
        form.s_nombre.$value = payload.s_nombre;
        form.s_codigo_sg.$value = payload.s_codigo_sg;
        form.s_tipo_pdt.$value = payload.s_tipo_pdt;
        form.s_color.$value = payload.s_color;
        form.s_clase.$value = payload.s_clase;
  }


};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

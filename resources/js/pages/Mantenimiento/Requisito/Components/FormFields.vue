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
import type {  Requisito } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Requisito>,
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
            .max(200, "máximo 200 caracteres")
    ),

});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (payload: Requisito) => {
        if(payload){
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

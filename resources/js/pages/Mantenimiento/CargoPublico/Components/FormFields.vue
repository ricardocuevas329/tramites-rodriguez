<template>
    <div>
        <ScrollView>

            <TextInput label="Codigo" v-model="form.codigo.$value"
                :error-message="form.codigo.$error?.message" />

            <TextInput label="Descripcion" v-model="form.descripcion.$value"
                :error-message="form.descripcion.$error?.message" />

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
    InputSelect,
    ScrollView,
    TextInput,
} from "../../../../components";
import * as Yup from "yup";
import { defineForm , field, isValidForm, toObject } from "vue-yup-form";
import {toRefs, watchEffect } from "vue";
import type { PropType } from "vue";
import type {  CargoPublico } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<CargoPublico>,
    },
});

const form = defineForm({
    codigo: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(3, "máximo 3 caracteres")
    ),

    descripcion: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(255, "máximo 255 caracteres")

    ),

});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: CargoPublico) => {
    form.codigo.$value = data.codigo;
    form.descripcion.$value = data.descripcion;
   };

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

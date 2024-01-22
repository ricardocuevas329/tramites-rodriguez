<template>
    <div>
        <ScrollView>

            <TextInput label="Pais" v-model="form.s_pais.$value"
                :error-message="form.s_pais.$error?.message" />

            <TextInput label="Gentilicio Femenino" v-model="form.s_gentilicio_f.$value"
                :error-message="form.s_gentilicio_f.$error?.message" />

                <TextInput label="Gentilicio Masculino" v-model="form.s_gentilicio_m.$value"
                :error-message="form.s_gentilicio_m.$error?.message" />
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
import type { Pais } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Pais>,
    },
});

const form = defineForm({
    s_pais: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(100, "máximo 100 caracteres")
    ),

    s_gentilicio_f: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(100, "máximo 100 caracteres")

    ),
    s_gentilicio_m: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
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

const init = (data: Pais) => {
    form.s_pais.$value = data.s_pais;
    form.s_gentilicio_m.$value = data.s_gentilicio_m;
    form.s_gentilicio_f.$value = data.s_gentilicio_f;
   };

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

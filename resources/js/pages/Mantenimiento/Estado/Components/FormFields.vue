<template>
    <div>
        <ScrollView>

            <TextInput
                label="Codigo SBS"
                v-model="form.s_codigo_sbs.$value"
                :error-message="form.s_codigo_sbs.$error?.message"
            />

            <TextInputNumber
                label="Tipo"
                v-model="form.s_tipo.$value"
                :error-message="form.s_tipo.$error?.message"
            />

            <TextInput
                label="Descripción"
                type="text"
                :maxLength="250"
                v-model="form.s_desc.$value"
                :error-message="form.s_desc.$error?.message"
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
    TextInputNumber
} from "../../../../components";
import * as Yup from "yup";
import { defineForm , field, isValidForm, toObject } from "vue-yup-form";
import {toRefs, watchEffect } from "vue";
import type { PropType } from "vue";
import type {  Estado } from "@/models/types";
import {validateMaxDigits, validateMinDigits} from "@/utils/Regexs";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Estado>,
    },
});

const form = defineForm({

    s_codigo_sbs: field<string| null | undefined>(
        "",
        Yup.string()
            .max(5, "máximo 5 caracteres")
            .nullable()
    ),
    s_tipo: field<number|null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)

            .test("maxDigits", "Máximo de 5 dígitos permitidos.", value => {
                return validateMaxDigits(value, 5)
            })
            .positive("Numero no Válido")
            .nullable()
    ),
    s_desc: field<string| null | undefined>(
        "",
        Yup.string()
            .nullable()
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

const init = (payload: Estado) => {
        if(payload){
        form.s_codigo_sbs.$value = payload.s_codigo_sbs;
        form.s_tipo.$value = payload.s_tipo;
        form.s_desc.$value = payload.s_desc;
  }


};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

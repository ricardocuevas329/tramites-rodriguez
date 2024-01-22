<template>
    <div>
        <ScrollView>

            <TextInput
                label="Nombre"
                v-model="form.s_nombre.$value"
                :error-message="form.s_nombre.$error?.message"
            />

            <TextInput
                label="Codigo SBS"
                v-model="form.s_codigo_sbs.$value"
                :error-message="form.s_codigo_sbs.$error?.message"
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
import type { ZonaRegistral } from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<ZonaRegistral>,
    },
});

const form = defineForm({

    s_nombre: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2")
            .max(50, "máximo 50 caracteres")
    ),
    s_codigo_sbs: field<string| null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1 caracteres")
            .max(2, "máximo 2 caracteres")
    ),


});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (payload: ZonaRegistral) => {
        if(payload){
        form.s_codigo_sbs.$value = payload.s_codigo_sbs;
        form.s_nombre.$value = payload.s_nombre;
  }
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

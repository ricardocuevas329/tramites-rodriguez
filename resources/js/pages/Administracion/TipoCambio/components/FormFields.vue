<template>
    <div>
        <ScrollView :distance="40">
            <TextInput
                label="COMPRA"
                v-model="form.de_compra.$value"
                :validateError="isSubmit"
                :error-message="form.de_compra.$error?.message"
            />

            <TextInput
                label="VENTA"
                v-model="form.de_venta.$value"
                :validateError="isSubmit"
                :error-message="form.de_venta.$error?.message"
            />


        </ScrollView>
        <Center>
            <BtnSave :disabled="disabled" @click="onSubmit"/>
        </Center>
    </div>
</template>
<script setup lang="ts">
import {BtnSave, Center, ScrollView, TextInput,} from "../../../../components";
import * as Yup from "yup";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import {type PropType, ref, toRefs, watchEffect} from "vue";
import {RegExps} from "../../../../utils/Regexs";
import type {TipoCambio} from "@/models/types";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<TipoCambio>,
    },
});

const isSubmit = ref<boolean>(false)
const form = defineForm({


    de_venta: field<string | null | undefined>(
        null,
        Yup.string()
            .required("es requerido")
            .matches(RegExps.isDecimal, "valor inválido")
            .min(2, "minimo 2 caracteres")
            .max(4, "máximo 4 caracteres")
    ),
    de_compra: field<string | null | undefined>(
        null,
        Yup.string()
            .required("es requerido")
            .matches(RegExps.isDecimal, "valor inválido")
            .min(2, "minimo 2")
            .max(4, "máximo 4 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    isSubmit.value = true
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const {formValues} = toRefs(props);

const init = (data: TipoCambio) => {
    form.de_venta.$value = data.de_venta?.toString();
    form.de_compra.$value = data.de_compra?.toString();
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

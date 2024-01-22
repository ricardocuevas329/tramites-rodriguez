<template>
    <div>
        <ScrollView>

            <TextInput label="Nombres" v-model="form.s_nombres.$value"
                :error-message="form.s_nombres.$error?.message" />

            <TextInput label="Apellido Paterno" v-model="form.s_paterno.$value"
                :error-message="form.s_paterno.$error?.message" />

            <TextInput label="Apellido Materno" v-model="form.s_materno.$value"
                :error-message="form.s_materno.$error?.message" />
            <div class="grid grid-cols-1 md:grid-cols-2">
            <InputSelect :items="SexoItems" label="Sexo"
                v-model="form.s_sexo.$value"
                :error-message="form.s_sexo.$error?.message" />
            <TextInput label="Telefono" type="number" v-model="form.s_telefono.$value"
                 :error-message="form.s_telefono.$error?.message" />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
            <TextInput label="CAL" v-model="form.s_cal.$value"
                :error-message="form.s_cal.$error?.message" />

            <TextInput label="Colegio" v-model="form.s_colegio.$value"
                :error-message="form.s_colegio.$error?.message" />
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
    InputSelect,
    ScrollView,
    TextInput,
} from "../../../../components";
import * as Yup from "yup";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { RegExps } from "../../../../utils/Regexs";
import { type PropType, toRefs, watchEffect } from "vue";
import type { Abogado } from "@/models/types";
import { SexoItems } from "@/services/SexoService";

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Abogado>,
    },
});

const form = defineForm({
    s_nombres: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Nombre no válido")
            .min(3, "minimo 3")
            .max(70, "máximo 70 caracteres")
    ),

    s_paterno: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .min(3, "minimo 3 caracteres")
            .max(50, "máximo 50 caracteres")
    ),
    s_materno: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .min(3, "minimo 3")
            .max(50, "máximo 50 caracteres")
    ),
    s_sexo: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(10, "máximo 10 caracteres")
    ),
    s_telefono: field<string | null | undefined>(
        "",
        Yup.string()
            .matches(RegExps.isNumeric, {
                excludeEmptyString: true,
                message: "Telefono no válido"
            })
            .max(9, "máximo 9 caracteres")
            .nullable()

    ),

    s_cal: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(10, "máximo 10 caracteres")
    ),

    s_colegio: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(20, "máximo 20 caracteres")
    ),

});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (data: Abogado) => {
    form.s_nombres.$value = data.s_nombres;
    form.s_paterno.$value = data.s_paterno;
    form.s_materno.$value = data.s_materno;
    form.s_sexo.$value = data.s_sexo;
    form.s_cal.$value = data.s_cal;
    form.s_colegio.$value = data.s_colegio;
    form.s_telefono.$value = data.s_telefono

};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

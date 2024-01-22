<template>
    <div>
        <ScrollView>
            <div class="grid grid-cols-1 md:grid-cols-2">
            <InputSelect
                :items="TipoDocumentos"
                label="Tipo Documento"
                v-model="form.s_tipodoc.$value"
                :validate-error="isSubmit"
                :error-message="form.s_tipodoc.$error?.message"
                label-data="s_abrev"
                value-data="s_codigo"
            />
            <TextInput
                label="Numero"
                :validate-error="isSubmit"
                v-model="form.s_numdoc.$value"
                :error-message="form.s_numdoc.$error?.message"
            />
            </div>

            <TextInput
                label="Apellido Paterno"
                :validate-error="isSubmit"
                v-model="form.s_paterno.$value"
                :error-message="form.s_paterno.$error?.message"
            />

            <TextInput
                label="Apellido Materno"
                type="text"
                :maxLength="200"
                :validate-error="isSubmit"
                v-model="form.s_materno.$value"
                :error-message="form.s_materno.$error?.message"
            />

            <TextInput
                label="Nombres"
                type="text"
                :maxLength="200"
                :validate-error="isSubmit"
                v-model="form.s_nombres.$value"
                :error-message="form.s_nombres.$error?.message"
            />
            <div class="grid grid-cols-1 md:grid-cols-2">
            <TextInput
                label="Cargo"
                type="text"
                :maxLength="200"
                :validate-error="isSubmit"
                v-model="form.s_cargo.$value"
                :error-message="form.s_cargo.$error?.message"
            />

            <InputSelect
                label="Sexo"
                :items="SexoItems"
                :validate-error="isSubmit"
                v-model="form.s_sexo.$value"
                :error-message="form.s_sexo.$error?.message"
            />
            </div>
            <TextInput
                label="Telefono"
                type="text"
                :maxLength="20"
                :validate-error="isSubmit"
                v-model="form.s_telefonos.$value"
                :error-message="form.s_telefonos.$error?.message"
            />

            <TextInput
                label="Observacion"
                type="text"
                :maxLength="255"
                :validate-error="isSubmit"
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
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { toRefs, watchEffect, ref } from "vue";
import type { PropType } from "vue";
import type { Notario } from "@/models/types";
import { InputSelect } from "../../../../components";
import { useTipoDocumentoStore } from "../../../../store/tipo-documento";
import { RegExps } from '../../../../utils/Regexs';
import { SexoItems } from '@/services/SexoService'


const { TipoDocumentos } = toRefs(useTipoDocumentoStore());

const isSubmit = ref<boolean>(false);
const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Notario>,
    },
});

const form = defineForm({
    s_tipodoc: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(2, "minimo 2")
            .max(80, "máximo 80 caracteres")
    ),
    s_numdoc: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(
                RegExps.isNumeric,
                {
                    excludeEmptyString: true,
                    message: "Documento no válido",
                })
            .min(5, "minimo 5 caracteres")
            .max(10, "máximo 10 caracteres")
    ),

    s_paterno: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(
                RegExps.compositeName,
                {
                    excludeEmptyString: true,
                    message: "Apellido Paterno no válido",
                })
            .min(2, "minimo 2")
            .max(50, "máximo 50 caracteres")
    ),

    s_materno: field<string | null | undefined>(
        "",
        Yup.string()
        .matches(
                RegExps.compositeName,
                {
                    excludeEmptyString: true,
                    message: "Apellido Materno no válido",
                })
        .nullable()
        .max(50, "máximo 50 caracteres")
    ),

    s_nombres: field<string | null | undefined>(
        "",
        Yup.string()
        .matches(
                RegExps.compositeName,
                {
                    excludeEmptyString: true,
                    message: "Nombres no válido",
                })
        .nullable().min(2, "mínmo 2 caracteres").max(100, "máximo 100 caracteres")
    ),

    s_cargo: field<string | null | undefined>(
        "",
        Yup.string().nullable().max(200, "máximo 200 caracteres")
    ),

    s_sexo: field<string | null | undefined>(
        "",
        Yup.string().nullable().max(1, "máximo 1 caracteres")
    ),

    s_telefonos: field<string | null | undefined>(
        "",
        Yup.string().nullable().max(60, "máximo 60 caracteres")
    ),

    s_observacion: field<string | null | undefined>(
        "",
        Yup.string().nullable().max(250, "máximo 250 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    isSubmit.value = true;
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};
const { formValues } = toRefs(props);

const init = (payload: Notario) => {
    if (payload) {
        form.s_tipodoc.$value = payload.s_tipodoc;
        form.s_numdoc.$value = payload.s_numdoc;
        form.s_paterno.$value = payload.s_paterno;
        form.s_materno.$value = payload.s_materno;
        form.s_nombres.$value = payload.s_nombres;
        form.s_cargo.$value = payload.s_cargo;
        form.s_sexo.$value = payload.s_sexo;
        form.s_telefonos.$value = payload.s_telefonos;
        form.s_observacion.$value = payload.s_observacion;
    }
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

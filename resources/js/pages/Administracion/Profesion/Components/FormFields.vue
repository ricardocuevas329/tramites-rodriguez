<template>
    <div>
        <ScrollView>

            <TextInput label="SBS" v-model="form.s_codigo_sbs.$value" :validateError="isSubmit"
                       :error-message="form.s_codigo_sbs.$error?.message"/>

            <TextInput label="Nombre Masculino" v-model="form.s_nombre.$value" :validateError="isSubmit"
                       :error-message="form.s_nombre.$error?.message"/>

            <TextInput label="Nombre Femenino" v-model="form.s_nombref.$value" :validateError="isSubmit"
                       :error-message="form.s_nombref.$error?.message"/>

            <InputSelect :items="[{ id: '1', label: 'Profesion' }, { id: '0', label: 'Ocupacion' }]" label="Tipo"
                         v-model="form.i_tipo.$value" :validateError="isSubmit"
                         :error-message="form.i_tipo.$error?.message"/>

            <TextInput label="Descripcion" v-model="form.s_descripcion.$value" :validateError="isSubmit"
                       :error-message="form.s_descripcion.$error?.message"/>

        </ScrollView>
        <Center>
            <BtnSave :disabled="disabled" @click="onSubmit"/>
        </Center>
    </div>
</template>
<script setup lang="ts">
import {BtnSave, Center, InputSelect, ScrollView, TextInput,} from "../../../../components";
import * as Yup from "yup";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import {RegExps} from "../../../../utils/Regexs";
import {type PropType, ref, toRefs, watchEffect} from "vue";
import {type Profesion} from '../../../../models/types';

const isSubmit = ref<boolean>(false)
const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Profesion>,
    },
});

const form = defineForm({
    s_codigo_sbs: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(5, "máximo 5 caracteres")
    ),

    s_nombre: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Nombre no válido")
            .min(3, "minimo 3 caracteres")
            .max(50, "máximo 50 caracteres")
    ),
    s_nombref: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Nombre no válido")
            .min(3, "minimo 3")
            .max(50, "máximo 50 caracteres")
    ),
    i_tipo: field<number | null | undefined>(
        null,
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(2, "máximo 2 caracteres")
    ),
    s_descripcion: field<string | null | undefined>(
        "",
        Yup.string()
            .min(0, "minimo 0")
            .max(50, "máximo 50 caracteres")
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

const init = (data: Profesion) => {
    form.s_codigo_sbs.$value = data.s_codigo_sbs;
    form.s_nombre.$value = data.s_nombre;
    form.s_nombref.$value = data.s_nombref;
    form.i_tipo.$value = data.i_tipo;
    form.s_descripcion.$value = data.s_descripcion;
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

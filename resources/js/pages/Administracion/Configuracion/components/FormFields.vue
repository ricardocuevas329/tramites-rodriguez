<template>
    <div>
        <form id="formid" enctype="multipart/form-data">

            <ScrollView>

                <TextInput
                    label="Nombre"
                    v-model="form.s_empresa.$value"
                    :error-message="form.s_empresa.$error?.message"
                />

                <TextInput
                    label="Direccion"
                    v-model="form.s_direccion.$value"
                    :error-message="form.s_direccion.$error?.message"
                />

                <TextInput
                    label="Descripcion"
                    v-model="form.s_descripcion.$value"
                    :error-message="form.s_descripcion.$error?.message"
                />

                <LabelError v-if="form.s_ruta_logo?.$error?.message">
                    {{ form.s_ruta_logo?.$error?.message }}
                </LabelError>
                <UploaderFiles :files="[]"  :maxFiles="1" :multiple="false" maxFileSize="15MB"
                               maxTotalFileSize="15MB" @getFiles="getFiles" accept="image/*"
                               label="Arrastra o Agrega tu Logo"/>
            </ScrollView>
            <Center>
                <BtnSave :loading="isLoading" :disabled="disabled || isLoading" @click.prevent="onSubmit"/>
            </Center>
        </form>
    </div>
</template>
<script setup lang="ts">
import {
    BtnSave,
    Center,
    ScrollView,
    TextInput, UploaderFiles, LabelError
} from "../../../../components";
import * as Yup from "yup";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import {type PropType, toRefs, watchEffect, ref} from 'vue';
import type {Configuracion} from "@/models/types";
import type {IUploadFile} from "@/models/components/upload-file.interface";
const isLoading = ref<boolean>(false)
const base64 = ref<string | undefined | null>(null)
const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Configuracion>,
    },
});

const form = defineForm({
    s_empresa: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3 caracteres")
            .max(60, "máximo 60 caracteres")
    ),
    s_direccion: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(255, "máximo 255 caracteres")
    ),
    s_ruta_logo: field<string | null | undefined>(
        '',
        Yup.string()
            //.required("es requerido")
            .nullable()
    ),
    s_descripcion: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3 caracteres")
            .max(250, "máximo 250 caracteres")
    ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    if (isValidForm(form)) {
        emit("onSubmit", {file: base64.value, ...toObject(form)});
    }
};
const {formValues} = toRefs(props);

const init = (data: Configuracion) => {
    form.s_empresa.$value = data.s_empresa;
    form.s_direccion.$value = data.s_direccion;
    form.s_descripcion.$value = data.s_descripcion;
    form.s_ruta_logo.$value = data.s_ruta_logo;
};


const getFiles = (files: IUploadFile[]) => {
    isLoading.value = true
   setTimeout(()=>{
       base64.value = files.value[0].base64
       form.s_ruta_logo.$value = files.value[0].name
       isLoading.value = false
   },1300)
}

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }

});


</script>

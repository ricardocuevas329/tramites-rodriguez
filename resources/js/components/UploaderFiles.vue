<template>
    <FilePond v-bind:files="myFiles" ref="pond" class="my-pond" :label-idle="label" :allow-multiple="multiple"
              accept="image/*, application/pdf, .docx, .xlsx" v-on:init="handleFilePondInit"
              @addfilestart="handleFilePondAddFile"
              @addfile="handleFilePondAddFileLoad" v-on:activatefile="handleSelectedFile" v-on:addfile="addFiles"
              :maxFileSize="'12MB'" :maxTotalFileSize="'48MB'" :maxFiles="maxFiles" :allowFileSizeValidation="true"
              labelMaxFileSize="El tamaño máximo del archivo es {filesize}"
              labelMaxTotalFileSizeExceeded="Tamaño total máximo superado"
              labelMaxFileSizeExceeded="Archivo es demasiado grande"
              labelMaxTotalFileSize="El tamaño máximo permitido del archivo es {filesize}"
              labelInvalidField="Archivo no permitido"
              :allowFileEncode="true" :server="serverConfig" :allowPaste="true" v-on:removefile="removeFile"
              :beforeRemoveFile="beforeRemoveFile" :dropValidation="true" :processfilestart="onProcessFile"/>
</template>

<script setup lang="ts">
import axios from "axios";
import {type PropType, ref} from 'vue';
import vueFilePond from 'vue-filepond';
import FilePondPluginFileValidateType
    from 'filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.esm.js';
import FilePondPluginImagePreview from 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.esm.js';
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size';
import 'filepond/dist/filepond.min.css';
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css';
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {Center} from '@/components'
import {notify} from "@kyvg/vue3-notification";
import {createBase64ImageFromFile} from "../utils/functions.js"

defineOptions({
    name: 'UploaderFiles',
    inheritAttrs: false,
    customOptions: {},
})

const {
    infoUpload,
    label,
    multiple,
    accept,
    maxFileSize,
    maxTotalFileSize,
    files,
    endPointDelete,
    documentType
} = defineProps({
    infoUpload: {
        default: '',
        required: false,
        type: String,
    },
    label: {
        default: 'Agrega o Arrastra los Archivos',
        required: false,
        type: String,
    },
    multiple: {
        default: true,
        required: false,
        type: Boolean,
    },
    accept: {
        default: 'image/jpeg, image/png',
        type: String,
        required: true,
    },
    maxFileSize: {
        default: '12MB',
        type: String,
    },
    maxTotalFileSize: {
        default: '48MB',
        type: String,
    },
    files: {
        default: [],
        type: Object as PropType<IUploadFile[]>,
        required: false
    },
    maxFiles: {
        required: false,
        default: 10,
        type: Number,
    },
    endPointDelete: {
        default: '',
        type: String,
        required: false
    },
    documentType: {
        default: '',
        type: String,
        required: false,
    },
});
const myFiles = ref<IUploadFile[]>(files);
const fileSelecteds = ref<IUploadFile[]>([]);
const myFilesSize = ref(0);
const emit = defineEmits(['getFiles', 'deleteFile', 'selectFile']);
const pond = ref(null);

const FilePond = vueFilePond(
    FilePondPluginFileValidateType,
    FilePondPluginImagePreview,
    FilePondPluginFileValidateSize,
);
const handleFilePondAddFile = () => {
    //myFilesSize.value = fileSelecteds.value.length
    //emit('getFiles', fileSelecteds.value);
};

const handleFilePondInit = () => {
    fileSelecteds.value = myFiles.value
    myFilesSize.value = fileSelecteds.value.length
};
const handleFilePondAddFileLoad = () => {
    myFilesSize.value = fileSelecteds.value.length
    if (multiple) {
        emit('getFiles', fileSelecteds.value);
    } else {
        emit('getFiles', fileSelecteds);
    }

}
const addFiles = async (error, file) => {
    if (error?.main) return
    if (file) {
        if (file.file?.id_primary) return
        const dataFile = await createBase64ImageFromFile(file.file)
        fileSelecteds.value.push({
            name: file.file.name,
            size: file.file.size,
            type: file.file.type,
            base64: dataFile,
            documentType: documentType
        });
    }
};

const removeFile = (error, file) => {
    fileSelecteds.value = fileSelecteds.value.filter(item => item.name !== file?.file?.name);
    handleFilePondAddFileLoad();
};

const serverConfig = {
    process: '',
};

const handleSelectedFile = (e) => {
    emit('selectFile', e);
}

const beforeRemoveFile = async (file) => {
    if (file?.file?.id_primary) {
        const confirmed = await promptConfirmation();
        if (!confirmed) {
            throw new Error('');
        }

        try {
            await deleteFileFromServer(file?.file?.id_primary);
            emit('deleteFile', file?.file);
            return true
        } catch (error) {
            console.error('Error al eliminar el archivo:', error);
            return false;
        }
    } else {
        return true
    }
};

const promptConfirmation = async () => {
    return new Promise((resolve) => {
        const confirmed = window.confirm('¿Estás seguro de que deseas eliminar este archivo?');
        resolve(confirmed);
    });
};

const deleteFileFromServer = async (id_primary) => {
    try {
        if (id_primary) {
            const {status, data} = await axios.delete(`${endPointDelete}${id_primary}`);
            if (status === 200) {
                if (data?.message) {
                    notify({
                        title: data.message,
                        type: 'success'
                    })
                }
                return true
            }
        }
    } catch (error) {
        throw new Error('Error al eliminar el archivo en el servidor');
    }
};

function onProcessFile(error, file) {
    console.log('file processed', {error, file})
}

const components = {
    FilePond,
};
</script>

<style>
.filepond--credits {
    display: none;
}

.filepond--file-action-button {
    cursor: pointer;
}

.filepond--panel-root {
    background: oklch(var(--b2));
}

.filepond--item-panel {
    background: oklch(var(--p));
}

.filepond--drop-label {
    cursor: pointer;
}

.filepond--file {
    cursor: pointer;
}
</style>

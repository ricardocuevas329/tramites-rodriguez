<template>

  <ScrollView>
    <UploaderFiles :files="formValues.files"
                   endPointDelete="/api/permission-travel/document/" :maxFiles="MAX_TOTAL_FILES"
                   maxFileSize="50MB"
                   maxTotalFileSize="200MB" @deleteFile="onDeleteFile" @getFiles="onGetFiles"
                   accept="image/* , application/pdf"
                   label="Arrastra o Agrega DNI/Partida/Pago de Multas/etc"/>
  </ScrollView>
</template>
<script setup lang="ts">
import {ScrollView, UploaderFiles} from "@/components";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {type PropType} from "vue";
import type {PermisoViaje} from "@/models/types";

const emit = defineEmits(["onGetFiles", "onDeleteFile"]);
const props = defineProps({
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<PermisoViaje>,
  },
});
const {formValues} = props
const MAX_TOTAL_FILES = 4

const onGetFiles = (docs: IUploadFile[]) => {
  emit('onGetFiles', docs)
}

const onDeleteFile = (doc: IUploadFile) => {
  emit('onDeleteFile', doc)
}


</script>

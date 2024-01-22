<template>

  <ScrollView>
    <UploaderFiles :files="formValues.files"
                   endPointDelete="/api/book/document/" :maxFiles="MAX_TOTAL_FILES"
                   maxFileSize="15MB"
                   maxTotalFileSize="60MB" @deleteFile="onDeleteFile" @getFiles="onGetFiles"
                   accept="image/* , application/pdf"
                   label="Arrastra so Agrega Documentos"/>
  </ScrollView>
</template>
<script setup lang="ts">
import {ScrollView, UploaderFiles} from "@/components";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {type PropType} from "vue";
import type {Libro} from "@/models/types";

const emit = defineEmits(["onGetFiles", "onDeleteFile"]);
const props = defineProps({
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<Libro>,
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

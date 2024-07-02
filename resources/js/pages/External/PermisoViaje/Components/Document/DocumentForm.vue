<template>

  <ScrollView>
    <UploaderFiles :files="formValues.files" endPointDelete="/api/permiso-viaje/document/" :maxFiles="4"   maxFileSize="50MB"
                   maxTotalFileSize="200MB" @getFiles="getFiles" accept="image/* , application/pdf"
                   label="Arrastra o Agrega DNI/Partida/Pago de Multas/etc"/>
  </ScrollView>
</template>
<script setup lang="ts">
import {ScrollView, UploaderFiles} from "@/components";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {type PropType} from "vue";
import type {IPermisoViajeExternalFormModel} from "@/pages/External/PermisoViaje/Interfaces/typevieaje.interface";

const emit = defineEmits(["onGetFiles"]);
const props = defineProps({
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<IPermisoViajeExternalFormModel>,
  },
});
const {formValues} = props

const getFiles = (files: IUploadFile[]) => {
  emit('onGetFiles', files)
}
</script>

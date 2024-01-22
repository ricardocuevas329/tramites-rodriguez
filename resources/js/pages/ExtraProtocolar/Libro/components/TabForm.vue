<template>
  <Tab ref="tabComponentRef" :tabs="tabOptions" :icons="tabIcons">

    <template v-slot:DatosDelUsuario>
      <DatosUsuarioForm ref="DatosUsuarioFormRef" :formValues="formData"/>
    </template>
    <template v-slot:DetallesDeLosLibrosALegalizar>
      <LibrosLegalizarForm ref="LibrosLegalizarFormRef" :formValues="formData"/>
    </template>
    <template v-slot:Observaciones>
      <ObservacionesForm :total="LibrosLegalizarFormRef?.total" ref="ObservacionesFormRef" :formValues="formData"/>
    </template>
      <template v-slot:Documentos>
          <DocumentForm :formValues="formValues" :key="keyDocumentForm" @onDeleteFile="onDeleteFile"
                        @onGetFiles="onGetFiles"/>
          <DocumentList :files="formValues?.files" @onDeleteFile="onDeleteFile"/>
      </template>
  </Tab>
  <Center>
    <BtnSave :disabled="isSubmit || DatosUsuarioFormRef?.isSubmitFindByDocument" :loading="isSubmit"  @click="onSubmitSave()"/>
  </Center>
</template>
<script setup lang="ts">
import {type PropType, ref, toRefs, watchEffect} from "vue";
import {DatosUsuarioForm, LibrosLegalizarForm, ObservacionesForm} from "@/pages/ExtraProtocolar/Libro/components";
import {BtnSave, Center, Tab} from "@/components";
import type {IFormFieldLibro, ITypeTab} from "@/pages/ExtraProtocolar/Libro/Interfaces/libro.interface";
import {BookOpenIcon, ChatBubbleLeftIcon, InformationCircleIcon, DocumentIcon} from "@heroicons/vue/20/solid";
import type {PermisoViaje} from "@/models/types";
import {isValidForm, toObject} from "vue-yup-form";
import {notify} from "@kyvg/vue3-notification";
import {useLibroStore} from "@/store/libro";
import {DocumentForm, DocumentList} from "@/pages/ExtraProtocolar/Libro/Components";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {useGenerateKeyRandom} from "@/hooks/useUtils";

const {isSubmit} = toRefs(useLibroStore());
const tabComponentRef = ref<any>(null);
const DatosUsuarioFormRef = ref<any>(null);
const LibrosLegalizarFormRef = ref<any>(null);
const ObservacionesFormRef = ref<any>(null);

const props = defineProps({
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<IFormFieldLibro>,
  },
})
const {formValues} = toRefs(props);
const formData = ref<IFormFieldLibro>()
const keyDocumentForm = ref<string>();

const emit = defineEmits(["onSubmit"]);

const tabOptions = ref<ITypeTab[]>([
  "DatosDelUsuario",
  "DetallesDeLosLibrosALegalizar",
  "Observaciones",
  "Documentos"
]);

const tabIcons = [
  InformationCircleIcon,
  BookOpenIcon,
  ChatBubbleLeftIcon,
    DocumentIcon
]

const onSubmitSave = () => {

  DatosUsuarioFormRef.value?.onSubmit()
  if (!isValidForm(DatosUsuarioFormRef.value.form)) {
    tabComponentRef.value.selectedTab = 1
    setTimeout(() => {
      DatosUsuarioFormRef.value?.onValidateFocus()
    }, 400)
    return
  }

  if (LibrosLegalizarFormRef.value.librosLegalizados?.length == 0) {
    notify({
      title: "Atención",
      text: "Agregue libros!",
      type: "warn"
    })
    tabComponentRef.value.selectedTab = 2
    return
  }

  if (!isValidForm(ObservacionesFormRef.value.form)) {
    tabComponentRef.value.selectedTab = 3
    return
  }


  let formData = {
    ...toObject(DatosUsuarioFormRef.value.form),
    ...toObject(ObservacionesFormRef.value.form),
    libros_legalizados: LibrosLegalizarFormRef.value.librosLegalizados
  }
  emit('onSubmit', formData)


}


const onSubmit = (form?: PermisoViaje) => {
  emit("onSubmit", form)
}

const onGetFiles = (files: IUploadFile[]) => {
    DatosUsuarioFormRef.value.form.files.$value = files
}

const onDeleteFile = (file: IUploadFile) => {
    const indexDeleteFile = formValues.value?.files.findIndex(item => item.id === file?.id_primary);
    if (indexDeleteFile !== -1) {
        formValues.value?.files.splice(indexDeleteFile, 1);
        keyDocumentForm.value = useGenerateKeyRandom()
    }
}

watchEffect(() => {
  if (formValues.value) {
    if(formValues.value.isEdit){
      formData.value = formValues.value
    }
  }
});

</script>

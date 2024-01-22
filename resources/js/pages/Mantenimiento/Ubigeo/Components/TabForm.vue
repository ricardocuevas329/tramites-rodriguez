<template>
  <Tab ref="tabComponentRef" :tabs="tabOptions" :icons="tabIcons">
    <template v-slot:Departamento>
      <Departamento
          @onSubmit="onSubmit"
          ref="formFieldComponentRef"
      />
    </template>
    <template v-slot:Provincia>
      <Provincia  />
    </template>
    <template v-slot:Distrito>
      <Distrito   />
    </template>
  </Tab>

</template>
<script setup lang="ts">
import {type PropType, ref, toRefs} from "vue";
import {Departamento, Provincia, Distrito} from "@/pages/Mantenimiento/Ubigeo/Components/Index"
import {BtnSave, Center, Tab} from "@/components";
import { DocumentCheckIcon, InformationCircleIcon, UsersIcon} from "@heroicons/vue/20/solid";
import type {PermisoViaje} from "@/models/types";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {usePermisoViajeStore} from "@/store/permiso-viaje";
import {useGenerateKeyRandom} from "@/hooks/useUtils";
import type {ITabForm} from "@/pages/Mantenimiento/Ubigeo/Interfaces/tabform.interface";

const {isSubmit} = toRefs(usePermisoViajeStore());
const keyDocumentForm = ref<string>();
const tabComponentRef = ref<any>(null);
const formFieldComponentRef = ref<any>(null);

const props = defineProps({
  formValues: {
    require: true,
    type: Object as PropType<PermisoViaje>,
  },
})
const {formValues} = props
const emit = defineEmits(["onSubmit"]);

const tabOptions = ref<ITabForm[]>([
  "Departamento",
  "Provincia",
  "Distrito",
]);

const tabIcons = [
  InformationCircleIcon,
  UsersIcon,
  UsersIcon,
  DocumentCheckIcon,
]

const onValidateOnSubmit = () => {
  if (formFieldComponentRef.value?.onValidateFocus()) {
    tabComponentRef.value.selectedTab = 1
    setTimeout(() => {
      formFieldComponentRef.value?.onValidateFocus()
    }, 400)
  }
  formFieldComponentRef.value?.onSubmit()
}

const onGetFiles = (files: IUploadFile[]) => {
  formFieldComponentRef.value.form.files.$value = files
}

const onDeleteFile = (file: IUploadFile) => {
  const indexDeleteFile = formValues?.files.findIndex(item => item.id === file?.id_primary);
  if (indexDeleteFile !== -1) {
    formValues?.files.splice(indexDeleteFile, 1);
    keyDocumentForm.value = useGenerateKeyRandom()
  }
}

const onSubmit = (form?: PermisoViaje) => {
  emit("onSubmit", form)
}

</script>

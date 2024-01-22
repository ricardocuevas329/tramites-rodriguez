<template>
  <Tab ref="tabComponentRef" :tabs="tabOptions" :icons="tabIcons">
    <template v-slot:DatosGenerales>
      <FormFields
          :formValues="formValues"
          :disabled="isSubmit"
          @onSubmit="onSubmit"
          ref="formFieldComponentRef"
      />
    </template>
    <template v-slot:Participantes>
      <ParticipantForm :formValues="formValues"/>
    </template>
    <template v-slot:Acompañantes>
      <AcompananteForm :formValues="formValues"/>
    </template>
    <template v-slot:Documentos>
      <DocumentForm :formValues="formValues" :key="keyDocumentForm" @onDeleteFile="onDeleteFile"
                    @onGetFiles="onGetFiles"/>
      <DocumentList :files="formValues?.files" @onDeleteFile="onDeleteFile"/>
    </template>
  </Tab>
  <Center>
    <BtnSave :disabled="isSubmit"  :loading="isSubmit" @click="onValidateOnSubmit()"/>
  </Center>
</template>
<script setup lang="ts">
import {type PropType, ref, toRefs} from "vue";
import {
  AcompananteForm,
  DocumentForm,
  DocumentList,
  FormFields,
  ParticipantForm,
  PaymentForm
} from "@/pages/ExtraProtocolar/PermisoViaje/Components";
import {BtnSave, Center, Tab} from "@/components";
import type {ITypeTab} from "@/pages/ExtraProtocolar/PermisoViaje/Interfaces/typevieaje.interface";
import {CreditCardIcon, DocumentCheckIcon, InformationCircleIcon, UsersIcon} from "@heroicons/vue/20/solid";
import type {PermisoViaje} from "@/models/types";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {usePermisoViajeStore} from "@/store/permiso-viaje";
import {useGenerateKeyRandom} from "@/hooks/useUtils";

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

const tabOptions = ref<ITypeTab[]>([
  "DatosGenerales",
  "Participantes",
  "Acompañantes",
  "Documentos"
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

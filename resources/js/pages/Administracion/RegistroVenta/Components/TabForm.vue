<template>
  <div class="">
    <Tab ref="tabComponentRef" :tabs="tabOptions" :icons="tabIcons">
      <template v-slot:Compra>
        <purchaseForm
            :formValues="formValues"
            :disabled="isSubmit"
            @onSubmit="onSubmit"
            ref="purchaseFormComponentRef"
        />
      </template>
      <template v-slot:Facturado>
        <billedForm
            :formValues="formValues"
            :disabled="isSubmit"
            @onSubmit="onSubmit"
            ref="billedFormComponentRef"
        />
      </template>
      <template v-slot:DetalleDeServicios>
        <detailServiceForm
            :formValues="formValues"
            :disabled="isSubmit"
            @onSubmit="onSubmit"
            ref="detailServiceFormComponentRef"

        />
      </template>
    </Tab>
  </div>
  <span v-if="total" class="mx-2 badge badge-xs badge-outline p-2"> Presupuesto  Total: {{ total }} </span>
  <span v-if="total" class="mx-2 badge badge-xs badge-outline mt-1 p-2"> Devolución: 0 </span>

  <Center>
    <BtnSave :disabled="isSubmit" :loading="isSubmit" @click="onValidateOnSubmit()"/>
  </Center>
</template>
<script setup lang="ts">
import {computed, type PropType, ref, toRefs} from "vue";
import {BtnSave, Center, Tab} from "@/components";
import {CreditCardIcon} from "@heroicons/vue/20/solid";
import type {Kardex, PermisoViaje} from "@/models/types";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {useGenerateKeyRandom} from "@/hooks/useUtils";
import {detailServiceForm, purchaseForm, billedForm} from './Index'
import History from "vue-material-design-icons/History.vue"
import {useKardexStore} from "@/store/kardex";
import type { ITabFormTab } from '../Interfaces/tab-form.interface';
import Sale from 'vue-material-design-icons/Sale.vue';
import { isValidForm, toObject } from 'vue-yup-form';


const {isSubmit} = toRefs(useKardexStore());

const keyDocumentForm = ref<string>();
const tabComponentRef = ref<any>(null);
const purchaseFormComponentRef = ref<any>(null);
const billedFormComponentRef = ref<any>(null);
const detailServiceFormComponentRef = ref<any>(null);


const props = defineProps({
  formValues: {
    require: true,
    type: Object as PropType<PermisoViaje>,
  },
})
const {formValues} = props
const emit = defineEmits(["onSubmit"]);

const tabOptions = ref<ITabFormTab[]>([
  "Compra",
  "Facturado",
  "DetalleDeServicios",
]);

const tabIcons = [
Sale,
  CreditCardIcon,
  History,
]

const onValidateOnSubmit = async () => {
  if (!isValidForm(purchaseFormComponentRef.value.form)) {
    tabComponentRef.value.selectedTab = 1
    return purchaseFormComponentRef.value?.onSubmit()
  }
  if (!isValidForm(billedFormComponentRef.value.form)) {
    tabComponentRef.value.selectedTab = 2
    return billedFormComponentRef.value?.onSubmit()
  }
  

  if (detailServiceFormComponentRef.value.form.length == 0) {
    tabComponentRef.value.selectedTab = 3
    return detailServiceFormComponentRef.value?.onSubmit()
  }
 
 
  let form = {
    sales:  toObject(purchaseFormComponentRef.value.form),
    invoice: toObject(billedFormComponentRef.value.form),
    detail_services: detailServiceFormComponentRef.value.form
  }

  emit('onSubmit', form)
}

const onGetFiles = (files: IUploadFile[]) => {
  purchaseFormComponentRef.value.form.files.$value = files
}

const onDeleteFile = (file: IUploadFile) => {
  const indexDeleteFile = formValues?.files.findIndex(item => item.id === file?.id_primary);
  if (indexDeleteFile !== -1) {
    formValues?.files.splice(indexDeleteFile, 1);
    keyDocumentForm.value = useGenerateKeyRandom()
  }
}

const total = computed(() => {
  if (purchaseFormComponentRef.value?.total || billedFormComponentRef.value?.total) {
    return purchaseFormComponentRef.value?.total + billedFormComponentRef.value?.total
  }
  return 0

})

const onSubmit = (form?: Kardex) => {
  emit("onSubmit", form)
}

</script>

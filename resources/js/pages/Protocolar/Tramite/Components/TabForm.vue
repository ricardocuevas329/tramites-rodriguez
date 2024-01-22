<template>
  <div class="">
    <div class="my-2 ">
      <span v-tooltip="'Registro'" class="btn btn-circle"><i class="pi pi-user-plus"></i></span>
      <span v-tooltip="'Compareciente'" class="btn btn-circle"><i class="pi pi-user"></i></span>
      <span v-tooltip="'Escritura'" class="btn btn-circle"><i class="pi pi-book"></i></span>
      <span v-tooltip="'Bienes'" class="btn btn-circle"><i class="pi pi-dollar"></i></span>
      <span v-tooltip="'Registros Públicos'" class="btn btn-circle"><i class="pi pi-list"></i></span>
      <span v-tooltip="'Entregas'" class="btn btn-circle"><i class="pi pi-id-card"></i></span>
      <span v-tooltip="'Protesto'" class="btn btn-circle"><i class="pi pi-file"></i></span>
      <span v-tooltip="'Medio de Pago'" class="btn btn-circle"><i class="pi pi-wallet"></i></span>
      <span v-tooltip="'Presupuesto'" class="btn btn-circle"><i class="pi pi-credit-card"></i></span>
      <span v-tooltip="'Toma de Firma'" class="btn btn-circle"><i class="pi pi-pencil"></i></span>
    </div>

    <Tab ref="tabComponentRef" :tabs="tabOptions" :icons="tabIcons">
      <template v-slot:PresupuestoNotarial>
        <NotarialBudgetForm
            :formValues="formValues"
            :disabled="isSubmit"
            @onSubmit="onSubmit"
            ref="notarialBudgetFormComponentRef"
        />
      </template>
      <template v-slot:PresupuestoRegistral>
        <RegisterBudgetForm
            :formValues="formValues"
            :disabled="isSubmit"
            @onSubmit="onSubmit"
            ref="registerBudgetFormComponentRef"
        />
      </template>
      <template v-slot:HistorialDelTrámite>
        <HistoryForm
            :formValues="formValues"
            :disabled="isSubmit"
            @onSubmit="onSubmit"
            ref="historyBudgetFormComponentRef"

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
import {CreditCardIcon, InformationCircleIcon} from "@heroicons/vue/20/solid";
import type {Kardex, PermisoViaje} from "@/models/types";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {useGenerateKeyRandom} from "@/hooks/useUtils";
import type {ITabFormTab} from "@/pages/Protocolar/Kardex/Interfaces/tab-form.interface";
import {HistoryForm, NotarialBudgetForm, RegisterBudgetForm} from './Index'
import History from "vue-material-design-icons/History.vue"
import {useKardexStore} from "@/store/kardex";


const {isSubmit} = toRefs(useKardexStore());

const keyDocumentForm = ref<string>();
const tabComponentRef = ref<any>(null);
const notarialBudgetFormComponentRef = ref<any>(null);
const registerBudgetFormComponentRef = ref<any>(null);
const historyBudgetFormComponentRef = ref<any>(null);


const props = defineProps({
  formValues: {
    require: true,
    type: Object as PropType<PermisoViaje>,
  },
})
const {formValues} = props
const emit = defineEmits(["onSubmit"]);

const tabOptions = ref<ITabFormTab[]>([
  "PresupuestoNotarial",
  "PresupuestoRegistral",
  "HistorialDelTrámite",
]);

const tabIcons = [
  InformationCircleIcon,
  CreditCardIcon,
  History,
]

const onValidateOnSubmit = async () => {
  if (notarialBudgetFormComponentRef.value?.notaries.length == 0) {
    tabComponentRef.value.selectedTab = 1
    return notarialBudgetFormComponentRef.value?.onSubmit()
  }

  if (registerBudgetFormComponentRef.value?.registers.length == 0) {
    tabComponentRef.value.selectedTab = 2
    return registerBudgetFormComponentRef.value?.onSubmit()
  }

  if (historyBudgetFormComponentRef.value?.histories.length == 0) {
    tabComponentRef.value.selectedTab = 3
    return historyBudgetFormComponentRef.value?.onSubmit()
  }


  let form = {
    presupuesto_notarial: notarialBudgetFormComponentRef.value?.notaries,
    presupuesto_registral: registerBudgetFormComponentRef.value?.registers,
    historial_tramite: historyBudgetFormComponentRef.value?.histories

  }

  emit('onSubmit', form)
}

const onGetFiles = (files: IUploadFile[]) => {
  notarialBudgetFormComponentRef.value.form.files.$value = files
}

const onDeleteFile = (file: IUploadFile) => {
  const indexDeleteFile = formValues?.files.findIndex(item => item.id === file?.id_primary);
  if (indexDeleteFile !== -1) {
    formValues?.files.splice(indexDeleteFile, 1);
    keyDocumentForm.value = useGenerateKeyRandom()
  }
}

const total = computed(() => {
  if (notarialBudgetFormComponentRef.value?.total || registerBudgetFormComponentRef.value?.total) {
    return notarialBudgetFormComponentRef.value?.total + registerBudgetFormComponentRef.value?.total
  }
  return 0

})

const onSubmit = (form?: Kardex) => {
  emit("onSubmit", form)
}

</script>

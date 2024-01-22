<template>
  <Tab ref="tabCartasRef" :tabs="tapOptions" :icons="tabIcons">
    <template v-slot:Remitente>
      <Remitter  ref="remitterComponentRef" :tabCartasRef="tabCartasRef" :formValues="formValues" />
    </template>
    <template v-slot:Facturado>
      <Voucher  ref="voucherComponentRef"  :tabCartasRef="tabCartasRef" :formValues="formValues" />
    </template>
    <template v-slot:Destinatario>
      <Receiver :tabCartasRef="tabCartasRef" :formValues="formValues" />
    </template>
    <template v-slot:Observaciones>
      <Observation :tabCartasRef="tabCartasRef" :formValues="formValues" />
    </template>
    <template v-slot:Resumen>
      <Resume ref="resumeComponentRef"
        :tabCartasRef="tabCartasRef"
        :formValues="formValues"
        @onSubmit="onSubmit"
        :disabled="isSubmit"
      />
    </template>
  </Tab>
</template>
<script setup lang="ts">
import {onMounted, type PropType, ref} from "vue";
import {Tab,} from "../../../../components";
import {
  ChatBubbleOvalLeftEllipsisIcon,
  CreditCardIcon,
  DocumentCheckIcon,
  UserCircleIcon,
} from "@heroicons/vue/20/solid";

import type {ITypeOptionTabs} from "../Interfaces/tabNames.interface";
import {Observation, Receiver, Remitter, Resume, Voucher} from "../Components";
import type {ICartaFormStore} from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";
import {toObject, isValidForm} from "vue-yup-form";
import {notify} from "@kyvg/vue3-notification";


const props = defineProps({
  formValues: {
    require: true,
    type: Object as PropType<ICartaFormStore>,
  },
  isSubmit: {
    require: true,
    type: Boolean
  }
})
const {formValues} = props;
const emit = defineEmits(["onSubmit"]);
const tabCartasRef = ref<any>(null);
const tapOptions = ref<ITypeOptionTabs[]>([
  "Remitente",
  "Facturado",
  "Destinatario",
  "Observaciones",
  "Resumen",
]);
const voucherComponentRef = ref<any>(null);
const remitterComponentRef = ref<any>(null);
const resumeComponentRef  = ref<any>(null);
const tabIcons = [
  UserCircleIcon,
  CreditCardIcon,
  UserCircleIcon,
  ChatBubbleOvalLeftEllipsisIcon,
  DocumentCheckIcon,
];

const onSubmit = (form: ICartaFormStore) => {
  /* validate Remitter */
  if(!isValidForm(remitterComponentRef.value.form)){
    notify({
      title: "Completa los campos requeridos!",
      text: "Selecciona Remitente y Referente",
      type: "warn"
    })
   setTimeout(()=>{
     remitterComponentRef.value.onValidateFocus()
   }, 500)
   return tabCartasRef.value.selectedTab = 1
  }
  /* validate Voucher */
  if(!isValidForm(voucherComponentRef.value.form)){
    notify({
      title: "Completa los campos requeridos!",
      text: "Seleccione Facturado y complete Correo y Telefono",
      type: "warn"
    })
    setTimeout(()=>{
      voucherComponentRef.value.onValidateFocus()
    }, 500)
    return tabCartasRef.value.selectedTab = 2
  }

  form.formRemitente = toObject(remitterComponentRef.value.form)
  let voucherForm = toObject(voucherComponentRef.value.form)

  emit("onSubmit", { ...voucherForm, ...form })
}

onMounted(() => {
});
</script>

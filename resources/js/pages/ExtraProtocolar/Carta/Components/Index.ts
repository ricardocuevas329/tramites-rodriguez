import {defineAsyncComponent} from 'vue'
export const FormFields = defineAsyncComponent(() => import('./FormFields.vue'))
export const TabForm = defineAsyncComponent(() => import ('./TabForm.vue'))
export const Remitter = defineAsyncComponent(() => import('./Remitter/Remitter.vue'))
export const Voucher = defineAsyncComponent(() => import('./Voucher/Voucher.vue'))
export const Receiver = defineAsyncComponent(() => import('./Receiver/Receiver.vue'))
export const Observation = defineAsyncComponent(() => import('./Observation/Observation.vue'))
export const Resume = defineAsyncComponent(() => import('./Resume/Resume.vue'))
export const ObservationEdit = defineAsyncComponent(() => import('./Observation.vue'))

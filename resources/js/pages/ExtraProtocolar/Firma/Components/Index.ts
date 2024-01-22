import {defineAsyncComponent} from 'vue'
export const FormFields = defineAsyncComponent(() => import ('./FormFields.vue'))
export const UploadFirma = defineAsyncComponent(() => import ('./UploadFirma.vue'))
export const Representation = defineAsyncComponent(() => import ('./Representation.vue'))


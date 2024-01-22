import {defineAsyncComponent} from 'vue'

export const DatosUsuarioForm = defineAsyncComponent(() => import ('./DatosUsuario/DatosUsuarioForm.vue'))
export const TabForm = defineAsyncComponent(() => import ('./TabForm.vue'))
export const LibrosLegalizarForm = defineAsyncComponent(() => import ('./LibroLegalizar/LibrosLegalizarForm.vue'))
export const ObservacionesForm = defineAsyncComponent(() => import ('./Observaciones/ObservacionesForm.vue'))
export const Delivery = defineAsyncComponent(() => import ('./Options/Delivery.vue'))
export const Payment = defineAsyncComponent(() => import ('./Options/Payment.vue'))
export const Report = defineAsyncComponent(() => import ('./Options/Report.vue'))
export const Observation = defineAsyncComponent(() => import ('./Options/Observation.vue'))
export const DocumentList = defineAsyncComponent(() => import ('./Document/DocumentList.vue'))
export const DocumentForm = defineAsyncComponent(() => import ('./Document/DocumentForm.vue'))
export const DateOpening = defineAsyncComponent(() => import ('./Options/DateOpening.vue'))


import {defineAsyncComponent} from 'vue'
export const Departamento = defineAsyncComponent(() => import('./Departamento.vue'))
export const Distrito = defineAsyncComponent(() => import('./Distrito.vue'))
export const Provincia = defineAsyncComponent(() => import('./Provincia.vue'))
export const TabForm = defineAsyncComponent(() => import('./TabForm.vue'))


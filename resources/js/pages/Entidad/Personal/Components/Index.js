import {defineAsyncComponent} from 'vue'
export const FormFields = defineAsyncComponent(() => import('./FormFields.vue'))
export const Permisos = defineAsyncComponent(() => import('./Permisos.vue'))
export const Roles = defineAsyncComponent(() => import('./Roles.vue'))


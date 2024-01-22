import {defineAsyncComponent} from 'vue'
export const FormFields = defineAsyncComponent(() => import('./FormFields.vue'))
export const Comparecientes = defineAsyncComponent(() => import('./Comparecientes.vue'))
export const TableList = defineAsyncComponent(() => import('./TableList.vue'))
export const AddCliente = defineAsyncComponent(() => import("../../../Entidad/Cliente/Add-Cliente.vue"));
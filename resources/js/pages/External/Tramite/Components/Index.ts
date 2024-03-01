import { defineAsyncComponent } from "vue";

export const Form = defineAsyncComponent(() => import('./Form.vue'))
export const DocumentForm = defineAsyncComponent(() => import('./DocumentForm.vue'))
export const DocumentFormDetalle = defineAsyncComponent(() => import('./DocumentFormDetalle.vue'))
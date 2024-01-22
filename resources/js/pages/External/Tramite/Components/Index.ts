import {defineAsyncComponent} from "vue";

export const Form = defineAsyncComponent(() => import ('./Form.vue'))
export const DocumentForm = defineAsyncComponent(() => import ('./DocumentForm.vue'))

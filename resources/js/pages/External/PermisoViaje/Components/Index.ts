import {defineAsyncComponent} from 'vue'

export const FormFields = defineAsyncComponent(() => import ('./FormFields.vue'))
export const Participant = defineAsyncComponent(() => import ('./Participant/Form.vue'))
export const ParticipantTableList = defineAsyncComponent(() => import ('./Participant/ParticipantTableList.vue'))
export const TabForm = defineAsyncComponent(() => import ('./TabForm.vue'))
export const ParticipantForm = defineAsyncComponent(() => import ('./Participant/ParticipantForm.vue'))
export const DocumentForm = defineAsyncComponent(() => import ('./Document/DocumentForm.vue'))


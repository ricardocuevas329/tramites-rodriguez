import {defineAsyncComponent} from 'vue'

export const FormFields = defineAsyncComponent(() => import ('./FormFields.vue'))
export const Participant = defineAsyncComponent(() => import ('./Participant/Form.vue'))
export const AddCliente = defineAsyncComponent(() => import ("../../../Entidad/Cliente/Add-Cliente.vue"));
export const ParticipantTableList = defineAsyncComponent(() => import ('./Participant/ParticipantTableList.vue'))
export const ClientTableList = defineAsyncComponent(() => import ('./Acompanante/AcompananteTableList.vue'))
export const TabForm = defineAsyncComponent(() => import ('./TabForm.vue'))
export const ParticipantForm = defineAsyncComponent(() => import ('./Participant/ParticipantForm.vue'))
export const AcompananteForm = defineAsyncComponent(() => import ('./Acompanante/AcompananteForm.vue'))
export const DocumentForm = defineAsyncComponent(() => import ('./Document/DocumentForm.vue'))
export const PaymentForm = defineAsyncComponent(() => import ('./Payment/PaymentForm.vue'))
export const DocumentList = defineAsyncComponent(() => import ('./Document/DocumentList.vue'))

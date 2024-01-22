<template>
    <ModalRouterPage>
      <Form @onSubmit="onSubmit"   />
    </ModalRouterPage>
</template>
<script setup lang="ts">
import Form from './Components/Form.vue'
import ModalRouterPage from "@/components/ModalRouterPage.vue";
import {useTipoDocumentoExternalStore} from "@/store/external/tipo-documento.external";
import {onMounted,toRefs} from "vue";
import {useClientExternalStore} from "@/store/external/client.external";
import {notify} from "@kyvg/vue3-notification";
import {useRouter} from "vue-router";

const { listarTipoDocumentosActivos } = useTipoDocumentoExternalStore()
const {  saveClient, listProcedure } = useClientExternalStore()
const {  isLoading } = toRefs(useClientExternalStore())



const router = useRouter()

const onSubmit = async(form) => {
  try{
    isLoading.value = true
    const { status , message} = await saveClient(form)
    if(status){
      notify({
        title: message,
        type: 'success'
      })
      listProcedure()
      router.push('/home')
    }
  }catch (e) {
    isLoading.value = false
  } finally {
    isLoading.value = false
  }

}

onMounted(()=>{
    listarTipoDocumentosActivos()
})

</script>

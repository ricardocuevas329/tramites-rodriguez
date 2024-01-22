<template>
    <Card>
        <Title>
           <BtnBack @click="$router.push(configExtraProtocolar._COPIAS_CERTIFICADAS_.listar.path)" />
            Nueva Copia Certificada
        </Title>

      <FormFields :disabled="isLoading" @onSubmit="onSubmit"/>


    </Card>
</template>
<script setup lang="ts">
import {
    BtnBack,

    Card,
    Title
} from '../../../components';
import {FormFields} from './Components'

import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import type {CopiaCertificada} from "@/models/types";
import {useCertifiedCopyStore} from "@/store/certified-copy";
import {notify} from "@kyvg/vue3-notification";
import {ref} from "vue";
import {useRouter} from "vue-router";

const { saveCertifiedCopy, listCertifiedCopies } = useCertifiedCopyStore()
const isLoading = ref<boolean>(false);
const router = useRouter()


const onSubmit = async(form: CopiaCertificada) => {
  try{
    isLoading.value = true
    const { status,message, CopiaCertificada } = await saveCertifiedCopy(form)
    if(status){
      notify({
        title: message,
        type: 'success'
      })
      await listCertifiedCopies()
      await router.push(configExtraProtocolar._COPIAS_CERTIFICADAS_.listar.path)
    }

  }catch (e) {

  } finally {
   setTimeout(()=>{
     isLoading.value = false
   }, 1200)
  }
}
</script>

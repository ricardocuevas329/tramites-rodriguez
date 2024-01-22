<template>
  <Card>
    <Title>
      <BtnBack @click="$router.push(configExtraProtocolar._COPIAS_CERTIFICADAS_.listar.path)" />
      Editar Copia Certificada
    </Title>
    <FormFields  v-show="isReady" :disabled="isLoading" :formValues="copies" @onSubmit="onSubmit"/>
    <Skeleton v-if="!isReady" :tipo="2" />
  </Card>
</template>
<script setup lang="ts">
import {
    BtnBack,
    Card, Skeleton,
    Title
} from '../../../components';
import {FormFields} from './Components'

import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import type {CopiaCertificada} from "@/models/types";
import {useCertifiedCopyStore} from "@/store/certified-copy";
import {notify} from "@kyvg/vue3-notification";
import {ref, onMounted, watch} from "vue";
import {useRoute, useRouter} from "vue-router";

const { updateCertifiedCopy, listCertifiedCopies, findCertifiedCopyById } = useCertifiedCopyStore()
const isLoading = ref<boolean>(false);
const isReady = ref<boolean>(false);
const router = useRouter()
const route = useRoute()
const copies = ref<CopiaCertificada>();

const firma_cod = ref<string>('');

const onGetById = async(id) => {
   try {
     const { CopiaCertificada, status  } = await findCertifiedCopyById(id)
     if(status){
       copies.value = CopiaCertificada
       isReady.value = true
     }
   } catch (e) {
     await router.push(configExtraProtocolar._COPIAS_CERTIFICADAS_.listar.name)
   }
}

const onSubmit = async(form: CopiaCertificada) => {
  try{
    isLoading.value = true
    const { status,message, CopiaCertificada } = await updateCertifiedCopy(firma_cod.value, form)
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

onMounted(() => {
  firma_cod.value = route.params.id.toString()
  onGetById(firma_cod.value);

  watch(
      () => route.params.id,
      (newId, oldId) => {
        if (newId && newId != oldId) {
          firma_cod.value = newId.toString()
          onGetById(firma_cod.value);
        }
      }
  )
});

</script>

<template>
  <Card>
    <Title>
      <BtnBack @click="$router.push(configExtraProtocolar._FIRMA_.listar.path)" />
      Nueva Firma Registrada
    </Title>

     <FormFields  :isSubmitForm="isSubmitForm" @onSubmit="onSubmit" />

  </Card>
</template>
<script setup lang="ts">
import {
    BtnBack,
    Card,
    Title,
} from '../../../components';
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import {useTipoDocumentoStore} from "@/store/tipo-documento";
import {onMounted, ref} from "vue";
import {useFirmaStore} from "@/store/firma";
import {notify} from "@kyvg/vue3-notification";
import {useRouter} from "vue-router";
import {FormFields} from "./Components";
const {getDocumentClient} = useTipoDocumentoStore()
const {saveRegistroFirma, listarRegistroFirmas} = useFirmaStore();

const router = useRouter()
const isSubmitForm = ref<boolean>(false)

const onSubmit = async (form) => {

    isSubmitForm.value = true
    try {
      const {status, message} = await saveRegistroFirma(form)
      if (status) {
        notify({
          title: message,
          type: 'success'
        })
        await listarRegistroFirmas()
        await router.push(configExtraProtocolar._FIRMA_.listar.path)
      }
    } catch (e) {

    } finally {
      isSubmitForm.value = false
    }
  }


onMounted(() => {
  getDocumentClient()
})

</script>

<template>
  <Card>
    <Title>
      <BtnBack @click="$router.push(configProtocolar._TRAMITE_.listar.path)"/>
      Nuevo Kardex
    </Title>
    <TabForm @onSubmit="onSubmit"/>
  </Card>
</template>
<script setup lang="ts">
import {BtnBack, Card, Title} from '../../../components';
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";
import {TabForm} from './Components'
import {toRefs} from "vue";
import {useKardexStore} from "@/store/kardex";
import {notify} from "@kyvg/vue3-notification";
import {useRouter} from "vue-router";

const {isSubmit} = toRefs(useKardexStore());
const {saveKardex} = useKardexStore();
const router = useRouter()

const onSubmit = async (form) => {
  try{
    isSubmit.value = true
    const {Kardex, message, status} = await saveKardex(form)
    if (status) {
      notify({
        title: message,
        type: 'success'
      })
      await router.push(configProtocolar._TRAMITE_.listar.path)
    }
  }catch (e) {

  } finally {
    isSubmit.value = false
  }
}


</script>

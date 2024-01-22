<template>
  <Card>
    <Title>
      <BtnBack @click="$router.push(configAdministracion._REGISTRO_VENTA_.listar.path)"/>
      Editar Registro de Venta
    </Title>
    <TabForm @onSubmit="onSubmit"/>
  </Card>
</template>
<script setup lang="ts">
import {BtnBack, Card, Title} from '../../../components';

import {notify} from "@kyvg/vue3-notification";
import {useRoute} from "vue-router";
import {useKardexStore} from "@/store/kardex";
import {onMounted, ref} from "vue";
import type {Kardex as IKardex} from "@/models/types";
import {configAdministracion} from "@/router/Administracion/AdministracionConfig";
import {TabForm} from "./Components/Index"
const {saveKardex, findKardexById} = useKardexStore()
const route = useRoute()
const formValues = ref<IKardex>()
const id = route.params.id

const onSubmit = async (form) => {
  const {Kardex, message, status} = await saveKardex(form)
  if (status) {
    notify({
      title: message,
      type: 'success'
    })
  }
}


const onGetKardex = async() => {
  const { status, Kardex } = await findKardexById(id)
  if(status){
    formValues.value = Kardex
  }
}

onMounted(()=>{
  onGetKardex()
})

</script>

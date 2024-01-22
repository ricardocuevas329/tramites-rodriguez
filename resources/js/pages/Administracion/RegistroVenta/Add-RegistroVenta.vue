<template>
  <Card>
    <Title>
      <BtnBack @click="$router.push(configAdministracion._REGISTRO_VENTA_.listar.path)"/>
     Nuevo Registro de Venta
    </Title>
    <TabForm @onSubmit="onSubmit"/>
  </Card>
</template>
<script setup lang="ts">
import {BtnBack, Card, Title} from '../../../components';
import {toRefs} from "vue";
import {useKardexStore} from "@/store/kardex";
import {notify} from "@kyvg/vue3-notification";
import {useRouter} from "vue-router";
import {configAdministracion} from "@/router/Administracion/AdministracionConfig";
import {TabForm} from "./Components/Index"
import { useRegistroVentaStore } from '../../../store/registro-venta';

const {isSubmit} = toRefs(useKardexStore());
const {saveRegistrationSale, listRegistrationSale} = useRegistroVentaStore();
const router = useRouter()

const onSubmit = async (form) => {
  try {
    isSubmit.value = true
    const {message, status} = await saveRegistrationSale(form)
    if (status) {
      notify({
        title: message,
        type: 'success'
      })
      await router.push(configAdministracion._REGISTRO_VENTA_.listar.path)
      await listRegistrationSale()
    }
  } catch (e) {

  } finally {
    isSubmit.value = false
  }
}


</script>

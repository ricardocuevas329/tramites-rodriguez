<template>
  <ModalRouterPage>
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack @click="router.push(configAdministracion._REGISTRO_DEPOSITO_.listar.path)"/>
        </template>
        <template v-slot:center>
          <TitleTable>NUEVO REGISTRO DEPOSITO</TitleTable>
        </template>
      </Head>
      <div>
        <FormFields :disabled="isSubmit" @onSubmit="onSubmit"/>
      </div>

    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">

import {useRouter} from "vue-router";
import {BtnBack, Content, Head, ModalRouterPage, TitleTable} from "../../../components";
import {notify} from "@kyvg/vue3-notification";
import {ref} from "vue";
import FormFields from "./Components/FormFields.vue";
import {configAdministracion} from "@/router/Administracion/AdministracionConfig";
import type {RegistroDeposito} from "@/models/types";
import {useRegistroDepositoStore} from "@/store/registro-deposito";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const {listRegistroDeposito, saveRegistroDeposito} = useRegistroDepositoStore();


const onSubmit = async (form: RegistroDeposito) => {
  try {
    isSubmit.value = true;
    const {status, message} = await saveRegistroDeposito(form);
    if (status) {
      notify({
        title: "Exito",
        text: message,
      });
      await listRegistroDeposito();
      await router.push(configAdministracion._REGISTRO_DEPOSITO_.listar.path);
    }
  } catch (error) {

  } finally {
    setTimeout(() => {
      isSubmit.value = false;
    }, 1300);
  }
};
</script>

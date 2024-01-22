<template>
  <ModalRouterPage :is-component="false">
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack @click="router.back()"/>
        </template>
        <template v-slot:center>
          <TitleTable>DILIGENCIA CARTA REGISTRADA</TitleTable>
        </template>
      </Head>

      <div class=" ">
        <ViewDiligencia :formValues="formValues"/>
      </div>
    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import {useRoute, useRouter} from "vue-router";
import {BtnBack, Content, Head, ModalRouterPage, TitleTable, ViewDiligencia} from "../../../components";
import {onMounted, ref} from "vue";
import type {DiligenciaCarta} from "@/models/types";
import {configExtraProtocolar} from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import {useCartaStore} from "../../../store/carta";

const route = useRoute();
const router = useRouter();
const id = route.params.id.toString();
const formValues = ref<DiligenciaCarta>();
const {findDiligenciaCartaById} = useCartaStore();
const getDiligenciaCarta = async () => {
  try {
    const {status, DiligenciaCarta} = await findDiligenciaCartaById(id);
    if (status) {
      formValues.value = DiligenciaCarta;
    }
  } catch (error) {
    await router.push(configExtraProtocolar._CARTA_.listar.path);
  }
};

onMounted(() => {
  getDiligenciaCarta();
});
</script>

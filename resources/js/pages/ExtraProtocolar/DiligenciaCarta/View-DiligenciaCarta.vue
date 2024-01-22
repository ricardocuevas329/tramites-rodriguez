<template>
  <ModalRouterPage :is-component="true">
    <Container>
      <Card>
    <div class="flex">
      <BtnBack @click="router.push(configExtraProtocolar._DILIGENCIA_CARTA_.listar.path)"/>
      <TitleTable class="mx-1 mt-2">DILIGENCIA CARTA REGISTRADA </TitleTable>
    </div>
      <ViewDiligencia :formValues="formValues"/>
      </Card>
    </Container>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import {useRoute, useRouter} from "vue-router";
import {BtnBack, Card, Container, ModalRouterPage, TitleTable, ViewDiligencia} from "../../../components";
import {onMounted, ref, watch} from "vue";
import type {DiligenciaCarta} from "@/models/types";
import {configExtraProtocolar} from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import {useDiligenciaCartaStore} from "@/store/diligencia-carta";

const route = useRoute();
const router = useRouter();
const formValues = ref<DiligenciaCarta>();
const {findDiligenciaCartaById} = useDiligenciaCartaStore()
const getDiligenciaCarta = async (id: string) => {
  try {
    const {status, DiligenciaCarta} = await findDiligenciaCartaById(id);
    if (status) {
      formValues.value = DiligenciaCarta;
    }
  } catch (error) {
    await router.push(configExtraProtocolar._DILIGENCIA_CARTA_.listar.path);
  }
};

onMounted(() => {
  getDiligenciaCarta(route.params.id.toString());

  watch(
      () => route.params.id,
      (newId, oldId) => {
        if(newId && newId != oldId){
          getDiligenciaCarta(newId.toString());
        }
      }
  )
});
</script>

<template>
  <ModalRouterPage>
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack @click="router.push(configExtraProtocolar._CARTA_.listar.path)" />
        </template>
        <template v-slot:center>
          <TitleTable>EDITAR PERMISO DE VIAJE</TitleTable>
        </template>
      </Head>

      <FormFields v-if="isReady" :formValues="formValues" :disabled="isSubmit" />

      <Skeleton v-if="!isReady" :tipo="2" />
    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import { useRoute, useRouter } from "vue-router";
import { Content, TitleTable, Head, ModalRouterPage, BtnBack } from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref, onMounted } from "vue";
import { FormFields } from "./Components";
import { configExtraProtocolar } from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import type { Carta } from "@/models/types";
import { Skeleton } from "../../../components";
import { useCartaStore } from "../../../store/carta";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Carta>();
const isReady = ref<boolean>(false);

const id = route.params.id.toString();

const { findCartaById, listarCarta } = useCartaStore();
/*
const onSubmit = async (form: Carta) => {
    try {
        isSubmit.value = true;
        const { status, message } = await updatePermisoViaje(id, form);

        if (status) {
            router.push(configExtraProtocolar._PERMISO_VIAJE_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarCarta();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};*/

const findById = async () => {
  try {
    const { status, Carta } = await findCartaById(id);
    if (status) {
      formValues.value = Carta;
      isReady.value = status;
    }
  } catch (error) {
    router.push(configExtraProtocolar._PERMISO_VIAJE_.listar.path);
  }
};

onMounted(() => {
  findById();
});
</script>

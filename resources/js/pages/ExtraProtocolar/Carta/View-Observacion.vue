<template>
  <ModalRouterPage :is-component="useComponent">
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack @click="router.back()" />
        </template>
        <template v-slot:center>
          <TitleTable>OBSERVACIÓN DE CARTAS</TitleTable>
        </template>
      </Head>

      <div class="pb-10 py-4 px-4">
        <ObservationEdit
          :formValues="formValues"
          @onSubmit="onSubmit"
          :disabled="isSubmit"
        />
      </div>
    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import { useRouter, useRoute } from "vue-router";
import { notify } from "@kyvg/vue3-notification";
import { Content, TitleTable, Head, ModalRouterPage, BtnBack } from "../../../components";
import { ref, onMounted } from "vue";
import type { Carta } from "@/models/types";
import { configExtraProtocolar } from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import { useCartaStore } from "../../../store/carta";
import { ObservationEdit } from "./Components";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const id = route.params.id.toString();
const formValues = ref<Carta>();
const { listarCarta, findCartaById, updateObservation } = useCartaStore();
const { redirect } = defineProps({
  useComponent: {
    type: Boolean,
    default: false,
    required: false,
  },
  redirect: {
    type: Boolean,
    default: true,
    required: false,
  },
});
const getCarta = async () => {
  try {
    const { status, Carta } = await findCartaById(id);
    if (status) {
      formValues.value = Carta;
    }
  } catch (error) {
    router.push(configExtraProtocolar._CARTA_.listar.path);
  }
};

const onSubmit = async (form: Carta) => {
  try {
    isSubmit.value = true;
    const rpta = updateObservation(id, form);
    rpta.then(async (res) => {
      if (res.status) {
        router.push(configExtraProtocolar._CARTA_.listar.path);
        notify({
          title: "Exito",
          text: res.message,
        });
        await listarCarta();
      }
    });
  } catch (error) {
  } finally {
    setTimeout(() => {
      isSubmit.value = false;
    }, 1300);
  }
};

onMounted(() => {
  getCarta();
});
</script>

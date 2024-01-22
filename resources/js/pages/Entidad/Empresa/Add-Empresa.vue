<template>
  <ModalRouterPage :is-component="useComponent">
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack @click="router.back()" />
        </template>
        <template v-slot:center>
          <TitleTable>NUEVA EMPRESA</TitleTable>
        </template>
      </Head>

      <div class="pb-10 py-4 px-4">
        <FormFields :key="cleanFormField" :disabled="isSubmit" @onSubmit="onSubmit" />
      </div>
    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import {
  Content,
  TitleTable,
  Head,
  ModalRouterPage,
  BtnBack,
} from "../../../components";
import { FormFields } from "./Components/Index.js";
import { notify } from "@kyvg/vue3-notification";
import { ref } from "vue";
import { useEmpresaStore } from "../../../store/empresa";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { Empresa } from "@/models/types";
import { useGenerateKeyRandom } from "../../../hooks/useUtils";

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
const router = useRouter();
const cleanFormField = ref<string>("");
const isSubmit = ref<boolean>(false);
const { saveEmpresa, listarEmpresa } = useEmpresaStore();

const onSubmit = async (form: Empresa) => {
  try {
    isSubmit.value = true;
    const rpta = saveEmpresa(form);
    rpta.then(async (res) => {
      if (res.status) {
        if (redirect) {
          router.push(configEntidad._EMPRESA_.listar.path);
        } else {
          router.back();
        }
        notify({
          title: "Exito",
          text: res.message,
        });
        cleanFormField.value = useGenerateKeyRandom();

        await listarEmpresa();
      }
    });
  } catch (error) {
  } finally {
    setTimeout(() => {
      isSubmit.value = false;
    }, 1300);
  }
};
</script>

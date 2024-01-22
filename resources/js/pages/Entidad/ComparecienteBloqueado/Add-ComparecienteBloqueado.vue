<template>
  <ModalRouterPage>
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack
            @click="
              router.push(
                configEntidad._COMPARECIENTE_BLOQUEADO_.listar.path
              )
            "
          />
        </template>
        <template v-slot:center>
          <TitleTable>NUEVO COMPARECIENTE BLOQUEADO</TitleTable>
        </template>
      </Head>
      <div class="pb-10 py-4 px-4">
        <Tab :tabs="options">
            <template v-slot:Registro>
                <FormFields
                :disabled="isSubmit"
                @onSubmit="onSubmit"
                :formValues="formValues"
                />
            </template>
            <template v-slot:Comparecientes>
                <Comparecientes
                :formValues="formValues"
                @onSubmit="onSubmit"
                :disabled="isSubmit"
                />
            </template>
        </Tab>
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
  Tab,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref } from "vue";
import { FormFields, Comparecientes } from "./Components";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { ComparecienteBloqueado } from "@/models/types";
import { useComparecienteBloqueadoStore } from "../../../store/compareciente-bloqueado";
import type { ItypeOptionComparecienteBloqueado } from "../../../models/forms/ComparecienteBloqueado";
import type { ICustomComparecienteBloqueado } from './Interface/compareciente.interface';

const router = useRouter();
const isSubmit = ref<boolean>(false);



/* @ts-ignore */
const formValues = ref<ICustomComparecienteBloqueado>({
    s_referencia: null,
    s_numero: "",
    s_condicion: null,
    s_observacion: "",
    s_ruta: "",
    comparecientes: [],
    file: null
});

const { listarComparecienteBloqueado, saveComparecienteBloqueado } =
  useComparecienteBloqueadoStore();
const options = ref<ItypeOptionComparecienteBloqueado[]>(["Registro","Comparecientes"]);

const onSubmit = async (form: ComparecienteBloqueado) => {
  try {
    isSubmit.value = true;
    if(form.comparecientes.length === 0){
      return notify({
        type:'warn',
        title: "Ups!",
        text: "Agrega al menos 1 Compareciente!",
      });
    }
    const { status, message } = await saveComparecienteBloqueado(form);
    if (status) {
      router.push(configEntidad._COMPARECIENTE_BLOQUEADO_.listar.path);
      notify({
        title: "Exito",
        text: message,
      });
      await listarComparecienteBloqueado();
    }
  } catch (error) {
    console.log(error)
  } finally {
    setTimeout(() => {
      isSubmit.value = false;
    }, 1300);
  }
};

</script>

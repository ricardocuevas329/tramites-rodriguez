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
          <TitleTable>EDITAR COMPARECIENTE BLOQUEADO</TitleTable>
        </template>
      </Head>
      <div class="pb-10 py-4 px-4">
        <Tab :tabs="options">
            <template v-slot:Registro>
                <FormFields
                @onDeleteFile="onDeleteFile"
                :disabled="isSubmit"
                @onSubmit="onSubmit"
                :formValues="formValues"
                />
            </template>
            <template v-slot:Comparecientes>
                <Comparecientes
                :formValues="formValues"
                :disabled="isSubmit"
                @onSubmit="onSubmit"
                />
            </template>
        </Tab>
      </div>

    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import { useRoute, useRouter } from "vue-router";
import {
  Content,
  TitleTable,
  Head,
  ModalRouterPage,
  BtnBack,
  Tab,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref, onMounted } from "vue";
import { FormFields, Comparecientes } from "./Components";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { ComparecienteBloqueado } from "@/models/types";
import { useComparecienteBloqueadoStore } from "../../../store/compareciente-bloqueado";
import type { ItypeOptionComparecienteBloqueado } from "../../../models/forms/ComparecienteBloqueado";
import type { ICustomComparecienteBloqueado } from './Interface/compareciente.interface';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<ICustomComparecienteBloqueado>();
const id = route.params.id.toString();
const options = ref<ItypeOptionComparecienteBloqueado[]>(["Registro","Comparecientes"]);

const {
  listarComparecienteBloqueado,
  updateComparecienteBloqueado,
  findComparecienteBloqueadoById,
  destroyFileComparecienteBloqueado,
} = useComparecienteBloqueadoStore();

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
    const { status, message } = await updateComparecienteBloqueado(id, form);
      if (status) {
        router.push(configEntidad._COMPARECIENTE_BLOQUEADO_.listar.path);
        notify({
          title: "Exito",
          text: message,
        });
        await listarComparecienteBloqueado();
      }
  } catch (error) {
  } finally {
    setTimeout(() => {
      isSubmit.value = false;
    }, 1300);
  }
};


const onDeleteFile = async () => {
    if(!confirm("¿Realmente desea eliminar este Archivo?")) return
  try {
    const {  status, message } = await destroyFileComparecienteBloqueado(id);
      if (status) {
        if (formValues.value?.s_ruta) {
            formValues.value.s_ruta = "";
            notify({
            title: "Exito",
            text: message,
            });
        }
      }

  } catch (error) {
  } finally {
  }
};

const getComparecienteBloqueado = async () => {
  try {
    const { status, ComparecienteBloqueado } =
      await findComparecienteBloqueadoById(id.toString());
    if (status) {
      formValues.value = ComparecienteBloqueado;
    }
  } catch (error) {
    router.push(configEntidad._COMPARECIENTE_BLOQUEADO_.listar.path);
  }
};

onMounted(() => {
  getComparecienteBloqueado();
});
</script>

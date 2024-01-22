<template>
  <ModalRouterPage>
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack
              @click="
                            router.push(
                                configAdministracion._REGISTRO_DEPOSITO_.listar.path
                            )
                        "
          />
        </template>
        <template v-slot:center>
          <TitleTable>EDITAR REGISTRO DEPOSITO</TitleTable>
        </template>
      </Head>
      <div>
        <FormFields
            v-show="isReady"
            :disabled="isSubmit"
            @onSubmit="onSubmit"
            :formValues="formValues"
        />
        <Skeleton v-if="!isReady" :tipo="2" />
      </div>
    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import {useRoute, useRouter} from "vue-router";
import {BtnBack, Content, Head, ModalRouterPage, Skeleton, TitleTable} from "@/components";
import {notify} from "@kyvg/vue3-notification";
import {onMounted, ref} from "vue";
import FormFields from "./Components/FormFields.vue";
import {configAdministracion} from "@/router/Administracion/AdministracionConfig";
import type {RegistroDeposito} from "@/models/types";
import {useRegistroDepositoStore} from "@/store/registro-deposito";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const isReady = ref<boolean>(false);
const formValues = ref<RegistroDeposito>();
const id = route.params.id.toString();
const {listRegistroDeposito, updateRegistroDeposito, findRegistroDepositoById} = useRegistroDepositoStore();

const onSubmit = async (form: RegistroDeposito) => {
  try {
    isSubmit.value = true;
    const {message, status} = await updateRegistroDeposito(id, form);
    if (status) {
      await router.push(configAdministracion._REGISTRO_DEPOSITO_.listar.path);
      notify({
        title: "Exito",
        text: message,
      });
      await listRegistroDeposito();
    }

  } catch (error) {
  } finally {
    setTimeout(() => {
      isSubmit.value = false;
    }, 1300);
  }
};

const getRegistroDeposito = async () => {
  try{
    const {RegistroDeposito, status} = await findRegistroDepositoById(id);
    if (status) {
      formValues.value = RegistroDeposito;
      isReady.value = true
    }
  }catch (e) {
    isReady.value = false
  } finally {
  }
};

onMounted(() => {
  getRegistroDeposito();
})
</script>

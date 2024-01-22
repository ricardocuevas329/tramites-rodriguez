<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(configExtraProtocolar._PERMISO_VIAJE_.listar.path)
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR PERMISO DE VIAJE</TitleTable>
                </template>
            </Head>
          <TabForm v-if="isReady" :formValues="formValues"   @onSubmit="onSubmit"/>
          <Skeleton v-if="!isReady" :tipo="2" />
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
} from "@/components";
import { notify } from "@kyvg/vue3-notification";
import {ref, onMounted, toRefs} from "vue";
import {TabForm} from "./Components";
import { configExtraProtocolar } from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import type { PermisoViaje } from "@/models/types";
import { Skeleton } from "@/components";
import { usePermisoViajeStore } from '@/store/permiso-viaje';

const route = useRoute();
const router = useRouter();


const formValues = ref<PermisoViaje>();
const isReady = ref<boolean>(false);
const id = route.params.id.toString();
const { findPermisoViajeById, updatePermisoViaje, listarPermisoViaje } = usePermisoViajeStore();
const { isSubmit } = toRefs(usePermisoViajeStore());



const onSubmit = async (form: PermisoViaje) => {
    try {
        isSubmit.value = true;
        const { status, message } = await updatePermisoViaje(id, form);

        if (status) {
            await router.push(configExtraProtocolar._PERMISO_VIAJE_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarPermisoViaje();
        }
    } catch (error) {
      isSubmit.value = false;
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const findById = async () => {
    try {
        const { status, PermisoViaje } = await findPermisoViajeById(id);
        if (status) {
            formValues.value = PermisoViaje;
            isReady.value = status
        }
    } catch (error) {
       await router.push(configExtraProtocolar._PERMISO_VIAJE_.listar.path);
    }
};

onMounted(() => {
    findById();

});
</script>

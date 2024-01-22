<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configAdministracion._CONFIGURACION_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>AGREGAR CONFIGURACION</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields :disabled="isSubmit" @onSubmit="onSubmit" />
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
import { notify } from "@kyvg/vue3-notification";
import { ref } from "vue";
import { useConfiguracionStore } from "../../../store/configuracion";
import FormFields from "./components/FormFields.vue";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Configuracion } from "@/models/types";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const {saveConfiguracion, listarConfiguracion} = useConfiguracionStore();

const onSubmit = async (form: Configuracion) => {
    try {
        isSubmit.value = true;
        const rpta =  saveConfiguracion(form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configAdministracion._CONFIGURACION_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await  listarConfiguracion();
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

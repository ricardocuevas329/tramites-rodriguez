<template>
    <ModalRouterPage >
        <Content>
            <Head>
            <template v-slot:start>
                <BtnBack @click="router.push(configAdministracion._PROFESION_.listar.path)" />
            </template>
            <template v-slot:center>
                <TitleTable>NUEVA PROFESIÓN</TitleTable>
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
import { Content, TitleTable, Head, ModalRouterPage, BtnBack } from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref } from "vue";
import FormFields from "./Components/FormFields.vue";
import { useProfesionStore } from '../../../store/profesion';
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Profesion } from "@/models/types";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarProfesion, saveProfesion } = useProfesionStore();


const onSubmit = async (form: Profesion) => {
    try {
        isSubmit.value = true;
        const rpta = saveProfesion(form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configAdministracion._PROFESION_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarProfesion();
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

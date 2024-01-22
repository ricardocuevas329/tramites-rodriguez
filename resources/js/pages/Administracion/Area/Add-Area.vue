<template>
    <ModalRouterPage>
        <Content>

            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configAdministracion._AREAS_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVA AREA</TitleTable>
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
import FormFields from "./components/FormFields.vue";
import { useAreaStore } from '../../../store/area';
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Area } from "@/models/types";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { saveArea, listarAreas } = useAreaStore();

const onSubmit = async (form: Area) => {
    try {
        isSubmit.value = true;
        const rpta = saveArea(form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configAdministracion._AREAS_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarAreas();
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

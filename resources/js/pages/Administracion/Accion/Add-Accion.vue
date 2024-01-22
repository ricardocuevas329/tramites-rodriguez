<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configAdministracion._ACCION_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVA ACCION</TitleTable>
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
import FormFields from "./components/FormFields.vue";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import { useAccionStore } from "../../../store/accion";
import type { Accion } from "../../../models/types";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarAccion, saveAccion } = useAccionStore();

const onSubmit = async (form: Accion) => {
    try {
        isSubmit.value = true;
        const { message, status } = await saveAccion(form);

        if (status) {
            router.push(configAdministracion._ACCION_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarAccion();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

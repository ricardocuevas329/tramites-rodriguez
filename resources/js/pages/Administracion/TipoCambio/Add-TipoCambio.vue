<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configAdministracion._TIPOCAMBIO_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO TIPO DE CAMBIO</TitleTable>
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
import FormFields from "./components/FormFields.vue";
import { ref } from "vue";
import { useTipoCambioStore } from "../../../store/tipo-cambio";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { TipoCambio } from "@/models/types";

const router = useRouter();
const {listarTipoCambio, saveTipoCambio} = useTipoCambioStore();
const isSubmit = ref<boolean>(false);

const onSubmit = async (form: TipoCambio) => {
    try {
        isSubmit.value = true;
        const rpta = saveTipoCambio(form);
        rpta.then((res) => {
            if (res.status) {
                notify({
                    title: "Exito",
                    text: res.message,
                });
                listarTipoCambio();
                router.push(configAdministracion._TIPOCAMBIO_.listar.path);
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

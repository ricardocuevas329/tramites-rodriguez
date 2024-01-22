<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._MODO_PAGO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO MODO PAGO</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields :disabled="isSubmit" @onSubmit="onSubmit"  />
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
import FormFields from "./Components/FormFields.vue";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { ModoPago } from '../../../models/types';
import { useModoPagoStore } from '../../../store/modo-pago';

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarModoPago, saveModoPago } = useModoPagoStore();

const onSubmit = async (form: ModoPago) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveModoPago(form);
        if (status) {
            router.push(configMantenimiento._MODO_PAGO_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarModoPago();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

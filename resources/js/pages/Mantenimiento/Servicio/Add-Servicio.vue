<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._SERVICIO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO SERVICIO</TitleTable>
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
import type { Servicio } from '../../../models/types';
import { useServicioStore } from '../../../store/servicio';

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarServicio, saveServicio } = useServicioStore();

const onSubmit = async (form: Servicio) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveServicio(form);
        if (status) {
            router.push(configMantenimiento._SERVICIO_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarServicio();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._UNIDADES_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVA UNIDAD DE MEDIDA</TitleTable>
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
import FormFields from "./Components/FormFields.vue";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { Unidad } from "@/models/types";
import { useUnidadStore } from '../../../store/unidad';

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarUnidad, saveUnidad } = useUnidadStore();

const onSubmit = async (form: Unidad) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveUnidad(form);
        if (status) {
            router.push(configMantenimiento._UNIDADES_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarUnidad();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

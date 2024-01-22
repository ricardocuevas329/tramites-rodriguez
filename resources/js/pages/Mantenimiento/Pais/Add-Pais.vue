<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._PAIS_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO PAIS</TitleTable>
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
import type { Pais } from "../../../models/types";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import { usePaisStore } from '../../../store/pais';
const router = useRouter();
const isSubmit = ref<boolean>(false);
const { savePais, listarPais } = usePaisStore();

const onSubmit = async (form: Pais) => {
    try {
        isSubmit.value = true;
        const { status, message } = await savePais(form);
        if (status) {
            router.push(configMantenimiento._PAIS_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarPais();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

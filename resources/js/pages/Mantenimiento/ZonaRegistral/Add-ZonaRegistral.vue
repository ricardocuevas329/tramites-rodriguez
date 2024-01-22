<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._ZONA_REGISTRAL_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVA ZONA REGISTRAL</TitleTable>
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
import type { ZonaRegistral } from '../../../models/types';
import { useZonaRegistralStore } from '../../../store/zona-registral';

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarZonaRegistral, saveZonaRegistral } = useZonaRegistralStore();

const onSubmit = async (form: ZonaRegistral) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveZonaRegistral(form);
        if (status) {
            router.push(configMantenimiento._ZONA_REGISTRAL_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarZonaRegistral();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

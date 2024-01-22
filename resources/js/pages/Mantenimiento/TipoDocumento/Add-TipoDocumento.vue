<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._TIPO_DOCUMENTO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO TIPO DOCUMENTO</TitleTable>
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
import { useTipoDocumentoStore } from "../../../store/tipo-documento";
import FormFields from "./Components/FormFields.vue";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { TipoDocumento } from "@/models/types";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarTipoDocumento, saveTipoDocumento } = useTipoDocumentoStore();

const onSubmit = async (form: TipoDocumento) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveTipoDocumento(form);
        if (status) {
            router.push(configMantenimiento._TIPO_DOCUMENTO_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarTipoDocumento();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

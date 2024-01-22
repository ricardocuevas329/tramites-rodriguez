<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._DOCUMENTO_VENTA_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO DOCUMENTO VENTA</TitleTable>
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
import type { DocumentoVenta } from '../../../models/types';
import { useDocumentoVentaStore } from '../../../store/documento-venta';

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarDocumentoVenta, saveDocumentoVenta } = useDocumentoVentaStore();

const onSubmit = async (form: DocumentoVenta) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveDocumentoVenta(form);
        if (status) {
            router.push(configMantenimiento._DOCUMENTO_VENTA_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarDocumentoVenta();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

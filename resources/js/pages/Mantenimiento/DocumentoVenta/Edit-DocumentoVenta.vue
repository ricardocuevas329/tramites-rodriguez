<template>
    <ModalRouterPage>
        <Content>

            <Head>
                <template v-slot:start>
                    <BtnBack @click="
                        router.push(
                            configMantenimiento._DOCUMENTO_VENTA_.listar.path
                        )
                        " />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR DOCUMENTO VENTA</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields v-if="formValues?.s_codigo" :disabled="isSubmit" @onSubmit="onSubmit" :formValues="formValues" />
                <Skeleton v-if="!formValues?.s_codigo" :tipo="2" />
            </div>
        </Content>
    </ModalRouterPage>
</template>

<script setup lang="ts">
import { useRoute, useRouter } from "vue-router";
import {
    Content,
    TitleTable,
    Head,
    ModalRouterPage,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref, onMounted } from "vue";
import FormFields from "./Components/FormFields.vue";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import { BtnBack, Skeleton } from '../../../components';
import type { DocumentoVenta } from '../../../models/types';
import { useDocumentoVentaStore } from '../../../store/documento-venta';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<DocumentoVenta>();
const id = route.params.id.toString();
const { listarDocumentoVenta, updateDocumentoVenta, findDocumentoVentaById } = useDocumentoVentaStore();


const onSubmit = async (form: DocumentoVenta) => {
    try {
        isSubmit.value = true;
        const rpta = updateDocumentoVenta(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._DOCUMENTO_VENTA_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarDocumentoVenta();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getDocumentoVenta = async () => {
    try {
        const { status, DocumentoVenta } = await findDocumentoVentaById(id);
        if (status) {
            formValues.value = DocumentoVenta;
        }
    } catch (error) {
        router.push(configMantenimiento._DOCUMENTO_VENTA_.listar.path);

    }


};

onMounted(() => {
    getDocumentoVenta();
});
</script>

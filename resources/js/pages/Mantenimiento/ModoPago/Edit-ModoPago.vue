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
                    <TitleTable>EDITAR MODO PAGO</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields
                    :disabled="isSubmit"
                    @onSubmit="onSubmit"
                    :formValues="formValues"
                />
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
import { BtnBack } from "../../../components";
import type { ModoPago } from '../../../models/types';
import { useModoPagoStore } from '../../../store/modo-pago';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<ModoPago>();
const id = route.params.id.toString();
const { listarModoPago, updateModoPago, findModoPagoById} = useModoPagoStore();


const onSubmit = async (form: ModoPago) => {
    try {
        isSubmit.value = true;
        const rpta = updateModoPago(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._MODO_PAGO_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarModoPago();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getModoPago = async () => {
    const { status,  ModoPago} = await findModoPagoById(
        id.toString()
    );
    if (status) {
        formValues.value = ModoPago;
    }
};

onMounted(() => {
    getModoPago();
});
</script>

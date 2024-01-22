<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configAdministracion._TIPOCAMBIO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR BANCO</TitleTable>
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
    BtnBack,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import FormFields from "./components/FormFields.vue";
import { ref } from "vue";
import { useTipoCambioStore } from "../../../store/tipo-cambio";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { TipoCambio } from "@/models/types";

const route = useRoute();
const router = useRouter();
const id = route.params.id.toString();
const { listarTipoCambio, updateTipoCambio, findTipoCambioById } = useTipoCambioStore();
const isSubmit = ref<boolean>(false);
const formValues = ref<TipoCambio>();

const onSubmit = async (form: TipoCambio) => {
    try {
        isSubmit.value = true;
        const rpta = updateTipoCambio(id.toString(), form);
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

const getTipoCambio = async () => {
    const { TipoCambio, status } = await findTipoCambioById(id.toString());
    if (status) {
        const data = TipoCambio;
        formValues.value = data;
    }
};

getTipoCambio();
</script>

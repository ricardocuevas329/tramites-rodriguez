<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configAdministracion._ACCION_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR ACCION</TitleTable>
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
import { ref, onMounted } from "vue";
import type { Accion } from "../../../models/types";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import { useAccionStore } from "../../../store/accion";
import FormFields from "./components/FormFields.vue";

const { listarAccion, findAccionById, updateAccion } = useAccionStore();
const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Accion>();
const id = route.params.id.toString();

const onSubmit = async (form: Accion) => {
    try {
        isSubmit.value = true;
        const { message, status } = await updateAccion(id.toString(), form);

        if (status) {
            router.push(configAdministracion._ACCION_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarAccion();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getAccion = async () => {
    const { status, accion } = await findAccionById(id.toString());
    if (status) {
        formValues.value = accion;
    }
};

onMounted(() => {
    getAccion();
});
</script>

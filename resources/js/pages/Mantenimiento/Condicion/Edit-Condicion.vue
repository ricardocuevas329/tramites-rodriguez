<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._CONDICION_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR CONDICION </TitleTable>
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
import { useCondicionStore } from "../../../store/condicion";

import { ref, onMounted, defineAsyncComponent } from "vue";
import type { Condicion } from "@/models/types";
import {configMantenimiento} from "@/router/Mantenimiento/MantenimientoConfig";

const FormFields = defineAsyncComponent(() =>
    import("./components/FormFields.vue")
);

const route = useRoute();
const router = useRouter();
const id = route.params.id.toString();
const { listarCondicion, updateCondicion, findCondicionById } =
    useCondicionStore();

const isSubmit = ref<boolean>(false);
const formValues = ref<Condicion>();

const onSubmit = async (form: Condicion) => {
    try {
        isSubmit.value = true;
        const { status, message } = await updateCondicion(id, form);

        if (status) {
            notify({
                title: "Exito",
                text: message,
            });
            await listarCondicion();
            await router.push(configMantenimiento._CONDICION_.listar.path);
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getCondicion = async () => {
    const { Condicion, status } = await findCondicionById(id.toString());
    if (status) {
        const data = Condicion;
        formValues.value = data;
    }
};

onMounted(() => {
    getCondicion();
});
</script>

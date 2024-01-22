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
                    <TitleTable>NUEVA CONDICION</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields :disabled="isSubmit" @OnSubmit="onSubmit" />
            </div>
        </Content>
    </ModalRouterPage>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import { useCondicionStore } from "../../../store/condicion";
import {
    Content,
    TitleTable,
    Head,
    ModalRouterPage,
    BtnBack,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref, defineAsyncComponent } from "vue";
import type { Condicion } from "@/models/types";
import {configMantenimiento} from "@/router/Mantenimiento/MantenimientoConfig";


const FormFields = defineAsyncComponent(() =>
    import("./components/FormFields.vue")
);

const router = useRouter();

const { saveCondicion, listarCondicion } = useCondicionStore();
const isSubmit = ref<boolean>(false);

const onSubmit = async (form: Condicion) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveCondicion(form);
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
</script>

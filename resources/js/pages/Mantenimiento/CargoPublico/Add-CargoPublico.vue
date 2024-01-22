<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._CARGO_PUBLICO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO CARGO PÚBLICO</TitleTable>
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
import { ref, defineAsyncComponent } from "vue";
const FormFields = defineAsyncComponent(() =>
    import("./Components/FormFields.vue")
);

import { useCargoPublicoStore } from "../../../store/cargo-publico";
import type { CargoPublico } from "../../../models/types";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { saveCargoPublico, listarCargoPublico } = useCargoPublicoStore();

const onSubmit = async (form: CargoPublico) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveCargoPublico(form);
        if (status) {
            router.push(configMantenimiento._CARGO_PUBLICO_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarCargoPublico();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

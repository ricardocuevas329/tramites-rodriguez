<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._CARGO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO CARGO</TitleTable>
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
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { Cargo } from "@/models/types";
import { useCargoStore } from '../../../store/cargo';
import {defineAsyncComponent} from "vue";

const FormFields = defineAsyncComponent(() =>
    import("./Components/FormFields.vue")
);

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarCargo, saveCargo } = useCargoStore();

const onSubmit = async (form: Cargo) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveCargo(form);
        if (status) {
            router.push(configMantenimiento._CARGO_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarCargo();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._NACIONALIDAD_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVA NACIONALIDAD</TitleTable>
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
import FormFields from "./components/FormFields.vue";
import type { Nacionalidad } from "@/models/types";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import { useNacionalidadStore } from '../../../store/nacionalidad';
const router = useRouter();
const isSubmit = ref<boolean>(false);
const { saveNacionalidad, listarNacionalidad} = useNacionalidadStore();

const onSubmit = async (form: Nacionalidad) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveNacionalidad(form);
        if (status) {
            router.push(configMantenimiento._NACIONALIDAD_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarNacionalidad();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

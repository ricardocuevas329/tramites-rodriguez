<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._SERVICIO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR SERVICIO</TitleTable>
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
import type { Servicio } from '../../../models/types';
import { useServicioStore } from '../../../store/servicio';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Servicio>();
const id = route.params.id.toString();
const { listarServicio, updateServicio, findServicioById} = useServicioStore();


const onSubmit = async (form: Servicio) => {
    try {
        isSubmit.value = true;
        const rpta = updateServicio(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._SERVICIO_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarServicio();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getServicio = async () => {
    try {
        const { status,  Servicio} = await findServicioById(
        id.toString()
    );
    if (status) {
        formValues.value = Servicio;
    }
    } catch (error) {
        router.push(configMantenimiento._SERVICIO_.listar.path);
    }
};

onMounted(() => {
    getServicio();
});
</script>

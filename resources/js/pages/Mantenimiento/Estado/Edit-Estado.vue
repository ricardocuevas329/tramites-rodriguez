<template>
    <ModalRouterPage>
        <Content>

            <Head>
                <template v-slot:start>
                    <BtnBack @click="
                        router.push(
                            configMantenimiento._ESTADO_.listar.path
                        )
                        " />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR ESTADO</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields  v-if="formValues?.i_codigo"  :disabled="isSubmit" @onSubmit="onSubmit" :formValues="formValues" />
                <Skeleton v-if="!formValues?.i_codigo" :tipo="2" />
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
import type { Estado } from '../../../models/types';
import { useEstadoStore } from '../../../store/estado';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Estado>();
const id = route.params.id.toString();
const { listarEstado, updateEstado, findEstadoById } = useEstadoStore();


const onSubmit = async (form: Estado) => {
    try {
        isSubmit.value = true;
        const rpta = updateEstado(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._ESTADO_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarEstado();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getEstado = async () => {
    try {
        const { status, Estado } = await findEstadoById(id);
        if (status) {
            formValues.value = Estado;
        }
    } catch (error) {
        router.push(configMantenimiento._ESTADO_.listar.path);

    }


};

onMounted(() => {
    getEstado();
});
</script>

<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configAdministracion._CONFIGURACION_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>MODIFICAR CONFIGURACION</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields :disabled="isSubmit" @on-submit="onSubmit" :form-values="formValues" />
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
import { ref, onMounted } from 'vue';
import FormFields from "./components/FormFields.vue";
import { useConfiguracionStore } from "../../../store/configuracion";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Configuracion } from "@/models/types";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Configuracion>();

const id = route.params.id?.toString();
const {findConfiguracionById, updateConfiguracion, listarConfiguracion} = useConfiguracionStore();

const onSubmit = async (form: Configuracion) => {
    try {
        isSubmit.value = true;
        const rpta = updateConfiguracion(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarConfiguracion();
                router.push(configAdministracion._CONFIGURACION_.listar.path);
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1000);
    }
};

const getConfiguracion = async () => {
    const { configuracion, status } = await findConfiguracionById(id);
        if (status) {
            if(configuracion.i_codigo){
                formValues.value = configuracion;
            }

        }
};

onMounted(() => {
    getConfiguracion();
})
</script>

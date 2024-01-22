<template>
    <ModalRouterPage>
        <Content>

            <Head>
                <template v-slot:start>
                    <BtnBack @click="
                        router.push(
                            configMantenimiento._ZONA_REGISTRAL_.listar.path
                        )
                        " />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR ZONA REGISTRAL</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields  v-if="formValues?.s_codigo" :disabled="isSubmit" @onSubmit="onSubmit" :formValues="formValues" />
                <Skeleton v-if="!formValues?.s_codigo" :tipo="2" />
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
import type { ZonaRegistral } from '../../../models/types';
import { useZonaRegistralStore } from '../../../store/zona-registral';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<ZonaRegistral>();
const id = route.params.id.toString();
const { listarZonaRegistral, updateZonaRegistral, findZonaRegistralById } = useZonaRegistralStore();


const onSubmit = async (form: ZonaRegistral) => {
    try {
        isSubmit.value = true;
        const rpta = updateZonaRegistral(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._ZONA_REGISTRAL_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarZonaRegistral();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getZonaRegistral = async () => {
    try {
        const { status, ZonaRegistral } = await findZonaRegistralById(id);
        if (status) {
            formValues.value = ZonaRegistral;
        }
    } catch (error) {
        router.push(configMantenimiento._ZONA_REGISTRAL_.listar.path);

    }


};

onMounted(() => {
    getZonaRegistral();
});
</script>

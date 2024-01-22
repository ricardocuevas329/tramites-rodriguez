<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._UNIDADES_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR UNIDAD DE MEDIDA</TitleTable>
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
import type { Unidad } from "@/models/types";
import { useUnidadStore } from '../../../store/unidad';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Unidad>();
const id = route.params.id.toString();
console.log(id)
const { listarUnidad, updateUnidad, findUnidadById } = useUnidadStore();

const onSubmit = async (form: Unidad) => {
    try {
        isSubmit.value = true;
        const rpta = updateUnidad(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._UNIDADES_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarUnidad();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getUnidad = async () => {
   try {
    const { status,  Unidad} = await findUnidadById(
        id.toString()
    );
    if (status) {
        formValues.value = Unidad;
    }
   } catch (error) {
    router.push(configMantenimiento._UNIDADES_.listar.path);
   }
};

onMounted(() => {
    getUnidad();
});
</script>

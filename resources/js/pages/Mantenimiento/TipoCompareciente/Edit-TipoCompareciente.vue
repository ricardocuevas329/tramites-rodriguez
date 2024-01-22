<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._TIPO_COMPARECIENTE_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR TIPO COMPARECIENTE</TitleTable>
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
import type { TipoCompareciente } from '../../../models/types';
import { useTipoComparecienteStore } from '../../../store/tipo-compareciente';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<TipoCompareciente>();
const id = route.params.id.toString();
const { listarTipoCompareciente, updateTipoCompareciente, findTipoComparecienteById} = useTipoComparecienteStore();


const onSubmit = async (form: TipoCompareciente) => {
    try {
        isSubmit.value = true;
        const rpta = updateTipoCompareciente(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._TIPO_COMPARECIENTE_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarTipoCompareciente();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getTipoCompareciente = async () => {
    try {
        const { status,  TipoCompareciente} = await findTipoComparecienteById(
        id.toString()
    );
    if (status) {
        formValues.value = TipoCompareciente;
    }
    } catch (error) {
        router.push(configMantenimiento._TIPO_COMPARECIENTE_.listar.path);
    }

};

onMounted(() => {
    getTipoCompareciente();
});
</script>

<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._REQUISITO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR REQUISITO</TitleTable>
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
import type { Requisito } from "@/models/types";
import { useRequisitoStore } from '../../../store/requisito';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Requisito>();
const id = route.params.id.toString();
console.log(id)
const { listarRequisito, updateRequisito, findRequisitoById } = useRequisitoStore();

const onSubmit = async (form: Requisito) => {
    try {
        isSubmit.value = true;
        const rpta = updateRequisito(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._REQUISITO_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarRequisito();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getRequisito = async () => {
    const { status,  Requisito} = await findRequisitoById(
        id.toString()
    );
    if (status) {
        formValues.value = Requisito;
    }
};

onMounted(() => {
    getRequisito();
});
</script>

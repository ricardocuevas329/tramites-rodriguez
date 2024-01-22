<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configEntidad._NOTARIO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR NOTARIO</TitleTable>
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
import { configEntidad } from '../../../router/Entidad/EntidadConfig';
import { BtnBack } from "../../../components";
import type { Notario } from '../../../models/types';
import { useNotarioStore } from '../../../store/notario';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Notario>();
const id = route.params.id.toString();
const { listarNotario, updateNotario, findNotarioById} = useNotarioStore();


const onSubmit = async (form: Notario) => {
    try {
        isSubmit.value = true;
        const rpta = updateNotario(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configEntidad._NOTARIO_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarNotario();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getNotario = async () => {
    const { status,  Notario} = await findNotarioById(
        id.toString()
    );
    if (status) {
        formValues.value = Notario;
    }
};

onMounted(() => {
    getNotario();
});
</script>

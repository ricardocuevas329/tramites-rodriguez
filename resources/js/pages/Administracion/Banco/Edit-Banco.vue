<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configAdministracion._BANCO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR BANCO</TitleTable>
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
    BtnBack,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import FormFields from "./components/FormFields.vue";
import { ref, onMounted } from 'vue';
import { useBancoStore } from "../../../store/banco";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Banco } from "@/models/types";

const route = useRoute();
const router = useRouter();
const id = route.params.id.toString();
const { updateBanco, listarBancos, findBancoById } = useBancoStore();
const isSubmit = ref<boolean>(false);
const formValues = ref<Banco>();

const onSubmit = async (form: Banco) => {
    try {
        isSubmit.value = true;
        const rpta = updateBanco(id, form);
        rpta.then((res) => {
            if (res.status) {
                notify({
                    title: "Exito",
                    text: res.message,
                });
                listarBancos();
                router.push(configAdministracion._BANCO_.listar.path);
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getBanco = async () => {
    const { Banco, status } = await findBancoById(id);
    if (status) {
        const data = Banco;
        formValues.value = data;
    }
};

onMounted(() => {
    getBanco();
})
</script>

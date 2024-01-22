<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configAdministracion._BANCO_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO BANCO</TitleTable>
                </template>
            </Head>
            <div class="  pb-10 hide-scroll-bar py-4 px-4">
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
import FormFields from "./components/FormFields.vue";
import { ref } from 'vue';
import { useBancoStore } from "../../../store/banco";
import { configAdministracion } from "../../../router/Administracion/AdministracionConfig";
import type { Banco } from "@/models/types";

const router = useRouter();
const {saveBanco, listarBancos } = useBancoStore();
const isSubmit = ref<boolean>(false)

const onSubmit = async (form: Banco) => {
    try {
        console.log(form)
        isSubmit.value = true;
        const rpta = saveBanco(form);
        rpta.then((res) => {
            if (res.status) {
                notify({
                    title: "Exito",
                    text: res.message,
                });
                listarBancos();
                router.push(configAdministracion._BANCO_.listar.path)
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

</script>

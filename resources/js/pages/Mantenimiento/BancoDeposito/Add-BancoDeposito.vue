<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._BANCO_DEPOSITO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO BANCO DEPOSITO</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields :disabled="isSubmit" @onSubmit="onSubmit"  />
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
import {defineAsyncComponent, ref} from "vue";
const FormFields = defineAsyncComponent(() =>
    import("./Components/FormFields.vue")
);
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { BancoDeposito } from '../../../models/types';
import { useBancoDepositoStore } from '../../../store/banco-deposito';

const router = useRouter();
const isSubmit = ref<boolean>(false);
const { listarBancoDeposito, saveBancoDeposito } = useBancoDepositoStore();

const onSubmit = async (form: BancoDeposito) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveBancoDeposito(form);
        if (status) {
            router.push(configMantenimiento._BANCO_DEPOSITO_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarBancoDeposito();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

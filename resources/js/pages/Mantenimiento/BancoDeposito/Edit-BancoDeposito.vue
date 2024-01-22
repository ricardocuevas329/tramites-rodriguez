<template>
    <ModalRouterPage>
        <Content>

            <Head>
                <template v-slot:start>
                    <BtnBack @click="
                        router.push(
                            configMantenimiento._BANCO_DEPOSITO_.listar.path
                        )
                        " />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR BANCO DEPOSITO</TitleTable>
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
import {ref, onMounted, defineAsyncComponent} from "vue";
const FormFields = defineAsyncComponent(() =>
    import("./Components/FormFields.vue")
);
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import { BtnBack, Skeleton } from '../../../components';
import type { BancoDeposito } from '../../../models/types';
import { useBancoDepositoStore } from '../../../store/banco-deposito';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<BancoDeposito>();
const id = route.params.id.toString();
const { listarBancoDeposito, updateBancoDeposito, findBancoDepositoById } = useBancoDepositoStore();


const onSubmit = async (form: BancoDeposito) => {
    try {
        isSubmit.value = true;
        const rpta = updateBancoDeposito(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._BANCO_DEPOSITO_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarBancoDeposito();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getBancoDeposito = async () => {
    try {
        const { status, BancoDeposito } = await findBancoDepositoById(id);
        if (status) {
            formValues.value = BancoDeposito;
        }
    } catch (error) {
        router.push(configMantenimiento._BANCO_DEPOSITO_.listar.path);

    }


};

onMounted(() => {
    getBancoDeposito();
});
</script>

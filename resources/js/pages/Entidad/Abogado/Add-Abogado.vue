<template>
    <ModalRouterPage :is-component="useComponent">
        <Content>

            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configEntidad._ABOGADO_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO ABOGADO</TitleTable>
                </template>
            </Head>
            <div >
                <FormFields :key="cleanFormField" :disabled="isSubmit" @onSubmit="onSubmit" />
            </div>

        </Content>
    </ModalRouterPage>
</template>

<script setup lang="ts">

import { useRouter } from "vue-router";
import { Content, TitleTable, Head, ModalRouterPage, BtnBack } from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref } from "vue";
import FormFields from "./Components/FormFields.vue";
import { useAbogadoStore } from '../../../store/abogado';
import type { Abogado } from '../../../models/types';
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import { useGenerateKeyRandom } from '../../../hooks/useUtils';
const { redirect } =  defineProps({
 useComponent:{
    type: Boolean,
    default: false,
    required: false
 },
 redirect:{
    type: Boolean,
    default: true,
    required: false
 },
})
const router = useRouter();
const cleanFormField = ref<string>('');
const isSubmit = ref<boolean>(false);
const storeAbogado = useAbogadoStore();


const onSubmit = async (form: Abogado) => {
    try {
        isSubmit.value = true;
        const {status, message} = await storeAbogado.saveAbogado(form);
            if (status) {
                redirect && router.push(configEntidad._ABOGADO_.listar.path);
                notify({
                    title: "Exito",
                    text:  message,
                });
                cleanFormField.value = useGenerateKeyRandom()
                await storeAbogado.listarAbogado();
            }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

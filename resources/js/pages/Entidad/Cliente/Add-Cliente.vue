<template>
    <ModalRouterPage :is-component="useComponent">
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.back()
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>NUEVO CLIENTE</TitleTable>
                </template>
            </Head>


                <Tab :tabs="options">
                    <template v-slot:DatosGenerales>
                        <FormFields :key="cleanFormField" :disabled="isSubmit" @onSubmit="onSubmit" />
                    </template>
                </Tab>

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
import { ref } from 'vue';
import type { ITypeOptionCliente } from "../../../models/forms/Cliente";
import { useClienteStore } from "../../../store/cliente";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { Cliente } from "@/models/types";
import FormFields from "./Components/FormFields.vue";
import { Tab } from '../../../components';
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
const { saveCliente, listarCliente } = useClienteStore();
const options = ref<ITypeOptionCliente[]>(["DatosGenerales"]);
const onSubmit = async (form: Cliente) => {
    try {
        isSubmit.value = true;
        const { status, message } = await saveCliente(form);

        if (status) {
            if(redirect){
                router.push(configEntidad._CLIENTE_.listar.path);
            }else{
                router.back()
            }
            notify({
                title: "Bien Hecho!",
                text: message,
            });
            cleanFormField.value = useGenerateKeyRandom()
            await listarCliente();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};
</script>

<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configMantenimiento._PAIS_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR PAIS</TitleTable>
                </template>
            </Head>
            <div class="  pb-10 hide-scroll-bar py-4 px-4">
                <FormFields :disabled="isSubmit" @onSubmit="onSubmit" :formValues="formValues" />
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
import { ref, onMounted } from 'vue';
import FormFields from "./components/FormFields.vue";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { Pais } from "@/models/types";
import { usePaisStore } from '../../../store/pais';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false)
const formValues = ref<Pais>()
const id = route.params.id.toString()
const { updatePais, listarPais, findPaisById} = usePaisStore();

const onSubmit = async (form: Pais) => {
    try {

        isSubmit.value = true
        const {status, message} = await updatePais(id, form);

            if ( status) {
                router.push(configMantenimiento._PAIS_.listar.path)
                notify({
                    title: "Exito",
                    text: message,
                });
                await listarPais();

            }


    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false
        }, 1300);
    }
};


const getCargos = async() => {
   try {
    const { Pais, status } = await findPaisById(id);
        if (status) {
            formValues.value = Pais
        }
   } catch (error) {
    router.push(configMantenimiento._PAIS_.listar.path);
   }
}

onMounted(() => {
    getCargos()
})
</script>

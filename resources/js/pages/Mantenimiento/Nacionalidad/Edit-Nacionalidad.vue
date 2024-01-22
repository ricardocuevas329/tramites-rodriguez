<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configMantenimiento._NACIONALIDAD_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR NACIONALIDAD</TitleTable>
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
import type { Nacionalidad } from "@/models/types";
import { useNacionalidadStore } from '../../../store/nacionalidad';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false)
const formValues = ref<Nacionalidad>()
const id = route.params.id.toString()
const { updateNacionalidad, listarNacionalidad, findNacionalidadById} = useNacionalidadStore();

const onSubmit = async (form: Nacionalidad) => {
    try {

        isSubmit.value = true
        const {status, message} = await updateNacionalidad(id, form);

            if ( status) {
                router.push(configMantenimiento._NACIONALIDAD_.listar.path)
                notify({
                    title: "Exito",
                    text: message,
                });
                await listarNacionalidad();

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
        const { Nacionalidad, status } = await findNacionalidadById(id);
         if(status){
            formValues.value = Nacionalidad
         }
    } catch (error) {
        router.push(configMantenimiento._NACIONALIDAD_.listar.path)
    }



}

onMounted(() => {
    getCargos()
})
</script>

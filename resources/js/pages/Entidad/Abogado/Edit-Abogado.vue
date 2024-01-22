<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configEntidad._ABOGADO_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR ABOGADO</TitleTable>
                </template>
            </Head>
            <div class="  pb-10 hide-scroll-bar py-4 px-4">
                <FormFields :disabled="isSubmit" @onSubmit="onSubmit" v-if="formValues" :formValues="formValues" />
                <Skeleton v-if="!formValues" :tipo="2" />
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
import FormFields from "./Components/FormFields.vue";
import { useAbogadoStore } from '../../../store/abogado';
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { Abogado } from "@/models/types";
import { Skeleton } from '../../../components';

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false)
const formValues = ref<Abogado>()
const id = route.params.id.toString()
const { listarAbogado, findAbogadoById, updateAbogado } = useAbogadoStore();

const onSubmit = async (form: Abogado) => {
    try {

        isSubmit.value = true
        const { message, status } = await updateAbogado(id, form );
            if (status) {
                router.push(configEntidad._ABOGADO_.listar.path)
                notify({
                    title: "Exito",
                    text: message,
                });
                await  listarAbogado();
            }

    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false
        }, 1300);
    }
};


const getAbogado = async() => {
    const { abogado, status  } = await  findAbogadoById(id);
        if (status) {
            formValues.value = abogado
        }
}

onMounted(() => {
    getAbogado()
})

</script>

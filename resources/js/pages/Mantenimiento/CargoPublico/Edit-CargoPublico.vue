<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack @click="router.push(configMantenimiento._CARGO_PUBLICO_.listar.path)" />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR CARGO PÚBLICO</TitleTable>
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
import { ref, onMounted, defineAsyncComponent } from 'vue';

const FormFields = defineAsyncComponent(() =>
    import("./Components/FormFields.vue")
);
import { useCargoPublicoStore } from '../../../store/cargo-publico';
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { CargoPublico } from "@/models/types";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false)
const formValues = ref<CargoPublico>()
const id = route.params.id.toString()
const { updateCargoPublico, listarCargoPublico, findCargoPublicoById} = useCargoPublicoStore();

const onSubmit = async (form: CargoPublico) => {
    try {

        isSubmit.value = true
        const {status, message} = await updateCargoPublico(id, form);

            if ( status) {
                router.push(configMantenimiento._CARGO_PUBLICO_.listar.path)
                notify({
                    title: "Exito",
                    text: message,
                });
                await listarCargoPublico();

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
    const { CargoPublico, status } = await findCargoPublicoById(id);
        if (status) {
            formValues.value = CargoPublico
        }
   } catch (error) {
    router.push(configMantenimiento._CARGO_PUBLICO_.listar.path);
   }
}

onMounted(() => {
    getCargos()
})
</script>

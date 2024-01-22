<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._CARGO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR CARGO</TitleTable>
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
  BtnBack
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import {ref, onMounted, defineAsyncComponent} from "vue";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { Cargo } from "@/models/types";
import { useCargoStore } from '../../../store/cargo';

const FormFields = defineAsyncComponent(() =>
    import("./Components/FormFields.vue")
);

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Cargo>();
const id = route.params.id.toString();

const { listarCargo, updateCargo, findCargoById } = useCargoStore();

const onSubmit = async (form: Cargo) => {
    try {
        isSubmit.value = true;
        const rpta = updateCargo(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._CARGO_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarCargo();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getCargo = async () => {
    const { status,  Cargo} = await findCargoById(
        id.toString()
    );
    if (status) {
        formValues.value = Cargo;
    }
};

onMounted(() => {
    getCargo();
});
</script>

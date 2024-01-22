<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configAdministracion._BIENES_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR BIEN</TitleTable>
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
    BtnBack,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref, onMounted } from 'vue';
import { useBienStore } from "../../../store/bienes";
import FormFields from "./components/FormFields.vue";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Bien } from "@/models/types";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Bien>();

const id = route.params.id.toString();
const { listarBienes, findBienById, updateBien } = useBienStore();

const onSubmit = async (form: Bien) => {
    try {
        isSubmit.value = true;
        const rpta = updateBien(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarBienes();
                router.push(configAdministracion._BIENES_.listar.path);
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1000);
    }
};

const getBien = async () => {
    const { Bien, status } = await findBienById(id.toString());
    if (status) {
        const data = Bien;
        formValues.value = data;
    }
};

onMounted(() => {
    getBien();
})
</script>

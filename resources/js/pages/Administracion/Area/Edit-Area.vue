<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configAdministracion._AREAS_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR AREA</TitleTable>
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
import { ref } from "vue";
import FormFields from "./components/FormFields.vue";
import { useAreaStore } from "../../../store/area";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Area } from "@/models/types";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Area>();
const id = route.params.id;
const { listarAreas, findAreaById, updateArea } = useAreaStore();

const onSubmit = async (form: Area) => {
    try {
        isSubmit.value = true;
        const rpta = updateArea(id.toString(), form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configAdministracion._AREAS_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarAreas();
            }
        });
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getTipoDocumento = async () => {
    const { Area, status } = await findAreaById(id.toString());
    if (status) {
        formValues.value = Area;
    }
};

getTipoDocumento();
</script>

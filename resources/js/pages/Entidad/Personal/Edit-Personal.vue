<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(configEntidad._PERSONAL_.listar.path)
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR PERSONAL</TitleTable>
                </template>
            </Head>


            <Tab v-if="isReady" :tabs="options">
                    <template v-slot:DatosGenerales>
                        <FormFields
                            :formValues="formValues"
                            :disabled="isSubmit"
                            @onSubmit="onSubmit"

                        />
                    </template>
                    <template v-slot:Roles>
                        <Roles
                            :formValues="formValues"
                            :disabled="isSubmit"
                            @onSubmit="onSubmit"
                        />
                    </template>
                    <template v-slot:Permisos>
                        <Permisos
                            :formValues="formValues"
                            :disabled="isSubmit"
                            @onSubmit="onSubmit"
                        />
                    </template>
            </Tab>
            <Skeleton v-if="!isReady" :tipo="2" />
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
import { ref, onMounted } from "vue";
import { FormFields, Permisos, Roles } from "./Components";
import { usePersonalStore } from "../../../store/personal";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { User } from "@/models/types";
import { Skeleton, Tab } from '../../../components';
import type { ITypeOptionPersonal } from "../../../models/forms/Personal";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<User>();
const isReady = ref<boolean>(false);


const id = route.params.id.toString();
const options = ref<ITypeOptionPersonal[]>([
    "DatosGenerales",
    "Roles",
    "Permisos"
]);
const { findPersonalById, updatePersonal, listarPersonal } = usePersonalStore();

const onSubmit = async (form: User) => {
    try {
        isSubmit.value = true;
        const { status, message } = await updatePersonal(id, form);

        if (status) {
            router.push(configEntidad._PERSONAL_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarPersonal();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const findById = async () => {
    try {
        const { status, Personal } = await findPersonalById(id);
        if (status) {
            formValues.value = Personal;
            isReady.value = status
        }
    } catch (error) {
        router.push(configEntidad._PERSONAL_.listar.path);
    }
};

onMounted(() => {
    findById();

});
</script>

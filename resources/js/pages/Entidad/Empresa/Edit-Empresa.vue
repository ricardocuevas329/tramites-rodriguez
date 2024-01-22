<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configEntidad._EMPRESA_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR EMPRESA</TitleTable>
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
import { ref, onMounted } from "vue";
import FormFields from "./Components/FormFields.vue";
import { useEmpresaStore } from "../../../store/empresa";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { Empresa } from "@/models/types";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Empresa>();
const id = route.params.id.toString();
const { listarEmpresa, updateEmpresa, findEmpresaById } = useEmpresaStore();

const onSubmit = async (form: Empresa) => {
    try {
        isSubmit.value = true;
        const rpta = updateEmpresa(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configEntidad._EMPRESA_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarEmpresa();
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
   try {
    const { status, Empresa } = await findEmpresaById(id);
    if (status) {
        formValues.value = Empresa;
    }
   } catch (error) {
     router.push(configEntidad._EMPRESA_.listar.path);
   }
};

onMounted(() => {
    getTipoDocumento();
});
</script>

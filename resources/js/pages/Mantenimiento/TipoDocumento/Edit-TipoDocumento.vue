<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configMantenimiento._TIPO_DOCUMENTO_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR TIPO DOCUMENTO</TitleTable>
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
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref, onMounted } from "vue";
import { useTipoDocumentoStore } from "../../../store/tipo-documento";
import FormFields from "./Components/FormFields.vue";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import { BtnBack } from "../../../components";
import type { TipoDocumento } from "@/models/types";

const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<TipoDocumento>();
const id = route.params.id.toString();
const { listarTipoDocumento, updateTipoDocumento, findTipoDocumentoById } =
    useTipoDocumentoStore();

const onSubmit = async (form: TipoDocumento) => {
    try {
        isSubmit.value = true;
        const rpta = updateTipoDocumento(id, form);
        rpta.then(async (res) => {
            if (res.status) {
                router.push(configMantenimiento._TIPO_DOCUMENTO_.listar.path);
                notify({
                    title: "Exito",
                    text: res.message,
                });
                await listarTipoDocumento();
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
        const { status, TipoDocumento } = await findTipoDocumentoById(
        id.toString()
    );
    if (status) {
        formValues.value = TipoDocumento;
    }
    } catch (error) {
        router.push(configMantenimiento._TIPO_DOCUMENTO_.listar.path);
    }
};

onMounted(() => {
    getTipoDocumento();
});
</script>

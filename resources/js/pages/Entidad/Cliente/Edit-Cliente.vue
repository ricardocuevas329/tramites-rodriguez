<template>
    <ModalRouterPage>
        <Content>
            <Head>
                <template v-slot:start>
                    <BtnBack
                        @click="
                            router.push(
                                configEntidad._CLIENTE_.listar.path
                            )
                        "
                    />
                </template>
                <template v-slot:center>
                    <TitleTable>EDITAR CLIENTE</TitleTable>
                </template>
            </Head>
            <div class="pb-10 py-4 px-4">
                <Tab :tabs="options">
                    <template v-slot:DatosGenerales>
                        <FormFields :disabled="isSubmit"   :formValues="formValues" @onSubmit="onSubmit" />
                    </template>
                </Tab>
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
    Tab
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref, onMounted } from "vue";
import { useClienteStore } from "../../../store/cliente";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { Cliente } from "@/models/types";
import FormFields from "./Components/FormFields.vue";
import type { ITypeOptionCliente } from '../../../models/forms/Cliente';

const options = ref<ITypeOptionCliente[]>(["DatosGenerales"]);
const route = useRoute();
const router = useRouter();
const isSubmit = ref<boolean>(false);
const formValues = ref<Cliente>();
const id = route.params.id.toString();
const {updateCliente, listarCliente, findClienteById} = useClienteStore();
const onSubmit = async (form: Cliente) => {
    try {
        isSubmit.value = true;
        const { status, message } = await updateCliente(id, form);

        if (status) {
            router.push(configEntidad._CLIENTE_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await  listarCliente();
        }
    } catch (error) {
    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1300);
    }
};

const getCliente = async () => {
   try {
    const { status, Cliente  } = await findClienteById(id);
    if (status) {
        formValues.value = Cliente
    }
   } catch (error) {
    router.push(configEntidad._CLIENTE_.listar.path);
   }
};

onMounted(() => {
    getCliente();
});
</script>

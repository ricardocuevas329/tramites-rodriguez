<template>
    <Container>
        <Card>
            <!-- AddCliente Form -->
            <Modal id="cartas.registro_cliente">
                <AddCliente :use-component="true" :redirect="false"/>
            </Modal>

            <!-- AddCliente Form -->
            <Modal id="cartas.registro_empresa">
                <AddEmpresa :use-component="true" :redirect="false"/>
            </Modal>
            <Title
            >
                <BtnBack @click="$router.push(configExtraProtocolar._CARTA_.listar.path)"/>
                Registro de cartas a Lima
                <span v-if="pagination?.total">({{ pagination?.total }})</span>
            </Title>
            <TabForm :isSubmit="isSubmit" :formValues="formValues" @onSubmit="onSubmit"/>
        </Card>

        <RouterView/>
    </Container>
</template>

<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
import {notify} from "@kyvg/vue3-notification";
import {BtnBack, Card, Container, Modal, Title} from "../../../components";
import AddCliente from "@/pages/Entidad/Cliente/Add-Cliente.vue";
import AddEmpresa from "@/pages/Entidad/Empresa/Add-Empresa.vue";
import {useCartaStore} from "../../../store/carta";
import {TabForm} from "@/pages/ExtraProtocolar/Carta/Components";
import {useTipoDocumentoStore} from "@/store/tipo-documento";
import type {ICartaFormStore} from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";
import {router} from "../../../router/index";
import {configExtraProtocolar} from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";

const {isSubmit, pagination} = toRefs(useCartaStore());
const {getDocumentClient, getDocumentCompany} = useTipoDocumentoStore();
const {saveCarta, listarCarta} = useCartaStore();

const formValues = ref<ICartaFormStore>({
    s_remitente: null,
    s_empresa: null,
    s_referente: "",
    s_facturado: "",
    s_observacion: "",
    i_tipopago: false,
    i_delivery: false,
    i_bajopuerta: false,
    i_urgente: false,
    destinatarios: [],
    remitente: null,
    referente: null,
    destinatario: null,
    facturado_cliente: null,
    facturado_empresa: null,
    observacion: null,
    formRemitente: Object,
});

const onSubmit = async (formValues: ICartaFormStore) => {
    try {
        isSubmit.value = true;
        const {status, message} = await saveCarta(formValues);

        if (status) {
            await router.push(configExtraProtocolar._CARTA_.listar.path);
            notify({
                title: "Exito",
                text: message,
            });
            await listarCarta();
        }
    } catch (error) {

    } finally {
        setTimeout(() => {
            isSubmit.value = false;
        }, 1500);
    }
};

onMounted(() => {
    getDocumentClient();
    getDocumentCompany();
});
</script>

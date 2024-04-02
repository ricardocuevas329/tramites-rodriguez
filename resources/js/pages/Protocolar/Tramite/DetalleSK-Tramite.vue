<template>
    <Container>
        <Card>
            <div class="flex items-center justify-between">
                <router-link to="/Tramite" class="btn btn-sm align-left">
                    <i class="pi pi-arrow-circle-left text-lg cursor-pointer"></i>Mis Trámites
                </router-link>
                <a @click.native="refreshPage" class="btn btn-sm align-center">
                    Refrescar
                </a>
                <a role="button" class="btn btn-sm align-center">Trámite sin asignar Kardex: Solicitante - {{ solicitante }}</a>
            </div>
            <div style="margin-top: 5px;"></div>
            <details class="collapse">
                <summary class="text-md font-medium bg-blue flex items-center">
                    <span class="margin-spam">
                        <button class="btn btn-circle btn-xs btn-ghost bg-blue ">
                            <i class="pi pi-file-import text-lg bg-blue cursor-pointer"></i>
                        </button>
                    </span>
                    <span style="vertical-align: text-bottom;" class="ml-2 text-md">DOCUMENTOS - COORPORATIVO</span>
                </summary>
                <div class="collapse-content">
                    <DocumentFormDetalle :uploadFile="false" :documents="filesSelectedsExternal" />
                </div>
            </details>
        </Card>
    </Container>
</template>

<script setup lang="ts">
import { onMounted, ref, toRefs } from "vue";
import { Card, Container } from "@/components";
import { useTramiteStore } from "@/store/tramite";
import Button from "primevue/button";
import { DocumentFormDetalle } from '../../External/Tramite/Components';
import axios from "axios";
import { API_URL } from "@/config/enviroments";
import type { Kardex } from "@/models/types";
import type { IUploadFile } from "@/models/components/upload-file.interface";

const { search, pagination, isLoading } = toRefs(useTramiteStore());
const filesSelectedsExternal = ref<IUploadFile[]>([]);
const documentoValue = ref<string>('');
const solicitante = ref<string>('');
const TramiteResults = ref<Kardex[]>([]);
const apiResourceTramite = API_URL + "/api/tramite";

const refreshPage = () => {
    window.location.reload();
};

const onViewDocumentsExternal = (payload) => {
    filesSelectedsExternal.value = payload.files;
};

async function listTramite(documento: string) {
    try {
        isLoading.value = true;
        const page = pagination.value?.current_page || 1;
        const searchFilter = documento;
        const response = await axios.get(`${apiResourceTramite}?page=${page.toString()}&search=${searchFilter}`);
        TramiteResults.value = response.data.data;
        pagination.value = response.data.meta;
        solicitante.value = TramiteResults.value[0]?.nombre_compuesto || '';
    } catch (error) {
        console.error('Error al obtener la lista de trámites:', error);
    } finally {
        isLoading.value = false;
    }
}

onMounted(async () => {
    try {
        documentoValue.value = window.location.pathname.split('/')[4];
        await listTramite(documentoValue.value);
        onViewDocumentsExternal(TramiteResults.value[0]);
    } catch (error) {
        console.error('Error en la función onMounted:', error);
    }
});
</script>

<style scoped>
.bg-blue {
    background-color: #006aa6;
    color: white;
}

.margin-spam {
    margin-right: 5px;
    margin-left: 10px;
}
</style>

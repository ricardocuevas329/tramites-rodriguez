<template>
    <Container>
        <Card v-if="isLoadingDetail">
            <Skeleton :tipo="2"/>
        </Card>
        <Card v-else>
            <div v-if="detailTramite?.id">
                <div class="flex items-center justify-between">
                    <router-link to="/Tramite" class="btn btn-sm align-left">
                        <i class="pi pi-arrow-circle-left text-lg cursor-pointer"></i>Mis Trámites
                    </router-link>
                    <a @click.native="refreshPage" class="btn btn-sm align-center">
                        Refrescar
                    </a>
                    <a role="button" class="btn btn-sm align-center">Trámite sin asignar Kardex: Solicitante - {{ detailTramite?.nombre_compuesto }}</a>
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
                        <DocumentFormDetalle :uploadFile="false" :documents="detailTramite?.files" />
                    </div>
                </details>
            </div>
             <div v-else>
                 <p>No se encontraron resultados</p>
             </div>
        </Card>
    </Container>
</template>

<script setup lang="ts">
import { onMounted, ref, toRefs } from "vue";
import { Card, Container, Skeleton } from "@/components";
import { useTramiteStore } from "@/store/tramite";
import Button from "primevue/button";
import { DocumentFormDetalle } from '../../External/Tramite/Components';
import {useRoute} from "vue-router";
const { search, pagination, isLoading } = toRefs(useTramiteStore());
const {isLoadingDetail, detailTramite} = toRefs(useTramiteStore());
const {getDetail} = useTramiteStore();
const route = useRoute();
const tramite_id = ref<string>('');


const refreshPage = () => {
    window.location.reload();
};



onMounted(async () => {

    if (route.params?.id) {
        tramite_id.value = route.params?.id?.toString()
        await getDetail(tramite_id.value)

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

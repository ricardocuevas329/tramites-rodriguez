import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "@/models/Pagination";
import type {PermisoViaje, PermisoViajeDocument, PermisoViajeExternal} from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import { useDownloadFile } from "@/hooks/useUtils";
import {API_URL} from "@/config/enviroments";

const idStore = "PermisoViajeStore";
const apiResource = API_URL+"/api/permission-travel";

export const usePermisoViajeStore = defineStore(idStore, () => {
    const PermisoViajes = ref<PermisoViaje[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit =  ref<boolean>(false);
    const PermisoViajesExternal = ref<PermisoViajeExternal[]>([]);
    const isLoadingExternal = ref<boolean>(false);
    const paginationExternal = ref<Pagination>();

    async function listarPermisoViaje() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value  ?? ''
            const {
                data: { data, meta },
            }: ResponseList<PermisoViaje> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                PermisoViajes.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function listarPermisoViajeExternal() {
        try {
            isLoadingExternal.value = true;
            let current_page = paginationExternal.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value  ?? ''
             const {
                data: { data, meta },
            }: ResponseList<PermisoViajeExternal> = await axios.get(
                 `${apiResource}-external?page=${page.toString()}&search=${searchFilter}`
            );
            PermisoViajesExternal.value = data;
            paginationExternal.value = meta;
        } catch (error) {
        } finally {
            isLoadingExternal.value = false;
        }
    }

    async function savePermisoViaje(item: PermisoViaje) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<PermisoViaje> = await axios.post(`${apiResource}`, item);
        return { PermisoViaje: data, message, status };
    }

    async function updatePermisoViaje(id: String, item: PermisoViaje) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<PermisoViaje> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { PermisoViaje: data, message, status };
    }

    async function findPermisoViajeById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<PermisoViaje> = await axios.get(`${apiResource}/${id}`);
        return { PermisoViaje: data, message, status };
    }

    async function disabledPermisoViaje(item: PermisoViaje) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<PermisoViaje> = await axios.put(
            `${apiResource}/disabled/${item.i_codigo}`
        );
        return { PermisoViaje: data, message, status };
    }

    async function enabledPermisoViaje(item: PermisoViaje) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<PermisoViaje> = await axios.put(
            `${apiResource}/enabled/${item.i_codigo}`
        );
        return { PermisoViaje: data, message, status };
    }

    async function generateDocument(item: PermisoViaje) {
        const { status } = await axios.get(`${apiResource}/generateDocument/${item.i_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocument/${item.i_codigo}`,
            { responseType: 'blob'});
            useDownloadFile( 'permiso_viaje_notaria', '.docx', data)
        }

    }


    async function generateExcel(item: PermisoViaje) {
        const { status } = await axios.get(`${apiResource}/generateDocumentExcel/${item.i_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocumentExcel/${item.i_codigo}`,
            { responseType: 'blob'});
            useDownloadFile( 'permiso_viaje' ,'.xlsx', data)
        }

    }

    async function generatePDF(item: PermisoViaje) {
        const { status } = await axios.get(`${apiResource}/generateDocumentPDF/${item.i_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocumentPDF/${item.i_codigo}`,
            { responseType: 'blob'});
            useDownloadFile('permiso_viaje' ,'.pdf', data)
        }

    }

    async function deleteDocument(id: number) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<PermisoViajeDocument> = await axios.delete(
            `${apiResource}/document/${id}`
        );
        return { PermisoViaje: data, message, status };
    }


    function cleanPagination() {
        pagination.value = {
            current_page:0,
            from:0,
            last_page:0,
            per_page:0,
            to:0,
            total:0
        }
    }

    return {
        PermisoViajesExternal,
        search,
        isLoading,
        PermisoViajes,
        pagination,
        isSubmit,
        isLoadingExternal,
        paginationExternal,
        listarPermisoViaje,
        savePermisoViaje,
        updatePermisoViaje,
        findPermisoViajeById,
        disabledPermisoViaje,
        enabledPermisoViaje,
        cleanPagination,
        generateDocument,
        listarPermisoViajeExternal,
        generateExcel,
        generatePDF,
        deleteDocument
    };
});

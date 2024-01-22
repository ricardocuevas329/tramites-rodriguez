import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "@/models/Pagination";
import type {Kardex} from "@/models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import {useDownloadFile} from "@/hooks/useUtils";
import {API_URL} from "@/config/enviroments";

const idStore = "kardexStore";
const apiResource = API_URL + "/api/kardex";

export const useKardexStore = defineStore(idStore, () => {
    const Kardexs = ref<Kardex[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit = ref<boolean>(false);

    async function listarKardex() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<Kardex> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            Kardexs.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function saveKardex(item: Kardex) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Kardex> = await axios.post(`${apiResource}`, item);
        return {Kardex: data, message, status};
    }

    async function updateKardex(id: String, item: Kardex) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Kardex> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return {Kardex: data, message, status};
    }

    async function findKardexById(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Kardex> = await axios.get(`${apiResource}/${id}`);
        return {Kardex: data, message, status};
    }

    async function disabledKardex(item: Kardex) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Kardex> = await axios.put(
            `${apiResource}/disabled/${item.i_codigo}`
        );
        return {Kardex: data, message, status};
    }

    async function enabledKardex(item: Kardex) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Kardex> = await axios.put(
            `${apiResource}/enabled/${item.i_codigo}`
        );
        return {Kardex: data, message, status};
    }

    async function generateDocument(item: Kardex) {
        const {status} = await axios.get(`${apiResource}/generateDocument/${item.i_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocument/${item.i_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('permiso_viaje_notaria', '.docx', data)
        }

    }


    async function generateExcel(item: Kardex) {
        const {status} = await axios.get(`${apiResource}/generateDocumentExcel/${item.i_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocumentExcel/${item.i_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('permiso_viaje', '.xlsx', data)
        }

    }

    async function generatePDF(item: Kardex) {
        const {status} = await axios.get(`${apiResource}/generateDocumentPDF/${item.i_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocumentPDF/${item.i_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('permiso_viaje', '.pdf', data)
        }

    }

    async function deleteDocument(id: number) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<KardexDocument> = await axios.delete(
            `${apiResource}/document/${id}`
        );
        return {Kardex: data, message, status};
    }


    function cleanPagination() {
        pagination.value = {
            current_page: 0,
            from: 0,
            last_page: 0,
            per_page: 0,
            to: 0,
            total: 0
        }
    }

    return {
        search,
        isLoading,
        Kardexs,
        pagination,
        isSubmit,
        listarKardex,
        saveKardex,
        updateKardex,
        findKardexById,
        disabledKardex,
        enabledKardex,
        cleanPagination,
        generateDocument,
        generateExcel,
        generatePDF,
        deleteDocument
    };
});

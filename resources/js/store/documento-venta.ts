import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { DocumentoVenta } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "DocumentoVentaStore";
const apiResource = API_URL+"/api/documento-venta";
export const useDocumentoVentaStore = defineStore(idStore, () => {
    const DocumentoVentas = ref<DocumentoVenta[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarDocumentoVenta(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<DocumentoVenta> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                DocumentoVentas.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function listDocumentoVentaActives(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<DocumentoVenta> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
            DocumentoVentas.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function saveDocumentoVenta(item: DocumentoVenta) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<DocumentoVenta> = await axios.post(
            `${apiResource}`,
            item
        );
        return { DocumentoVenta: data, message, status };
    }

    async function updateDocumentoVenta(id: String, item: DocumentoVenta) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<DocumentoVenta> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { DocumentoVenta: data, message, status };
    }

    async function findDocumentoVentaById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<DocumentoVenta> = await axios.get(`${apiResource}/${id}`);
        return { DocumentoVenta: data, message, status };
    }

    async function disabledDocumentoVenta(item: DocumentoVenta) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<DocumentoVenta> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { DocumentoVenta: data, message, status };
    }

    async function enabledDocumentoVenta(item: DocumentoVenta) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<DocumentoVenta> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { DocumentoVenta: data, message, status };
    }

    return {
        DocumentoVentas,
        pagination,
        isLoading,
        listarDocumentoVenta,
        saveDocumentoVenta,
        updateDocumentoVenta,
        findDocumentoVentaById,
        disabledDocumentoVenta,
        enabledDocumentoVenta,
    };
});


import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { TipoDocumento } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "TipoDocumentotore";
const apiResource = API_URL+"/api/tipo-documento";
export const useTipoDocumentoStore = defineStore(idStore, () => {
    const TipoDocumentos = ref<TipoDocumento[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const TipoDocumentsClients = ref<TipoDocumento[]>([]);
    const TipoDocumentsCompanies = ref<TipoDocumento[]>([]);

    async function listarTipoDocumento(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<TipoDocumento> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                TipoDocumentos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function listarActivos() {
        try {

            const {
                data: { data },
            }: ResponseList<TipoDocumento> = await axios.get(
                `${apiResource}/listar/activos`
            );
            if (data.length) {
                TipoDocumentos.value = data;
            }
        } catch (error) {
        } finally {

        }
    }

    async function getDocumentClient() {
        try {

            const {
                data: { data },
            }: ResponseList<TipoDocumento> = await axios.get(
                `${apiResource}/listar/documentClient`
            );
            if (data.length) {
                TipoDocumentsClients.value = data;
            }
        } catch (error) {
        } finally {

        }
    }

    async function getDocumentCompany() {
        try {

            const {
                data: { data },
            }: ResponseList<TipoDocumento> = await axios.get(
                `${apiResource}/listar/documentCompany`
            );
            if (data.length) {
                TipoDocumentsCompanies.value = data;
            }
        } catch (error) {
        } finally {

        }
    }
    async function saveTipoDocumento(item: TipoDocumento) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoDocumento> = await axios.post(
            `${apiResource}`,
            item
        );
        return { TipoDocumento: data, message, status };
    }

    async function updateTipoDocumento(id: String, item: TipoDocumento) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoDocumento> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { TipoDocumento: data, message, status };
    }

    async function findTipoDocumentoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoDocumento> = await axios.get(`${apiResource}/${id}`);
        return { TipoDocumento: data, message, status };
    }

    async function disabledTipoDocumento(item: TipoDocumento) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoDocumento> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { TipoDocumento: data, message, status };
    }

    async function enabledTipoDocumento(item: TipoDocumento) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoDocumento> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { TipoDocumento: data, message, status };
    }

    return {
        TipoDocumentos,
        pagination,
        isLoading,
        listarTipoDocumento,
        saveTipoDocumento,
        updateTipoDocumento,
        findTipoDocumentoById,
        disabledTipoDocumento,
        enabledTipoDocumento,
        listarActivos,
        getDocumentClient,
        getDocumentCompany,
        TipoDocumentsClients,
        TipoDocumentsCompanies
    };
});

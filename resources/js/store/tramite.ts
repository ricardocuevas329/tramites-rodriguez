import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "@/models/Pagination";
import type { HistorialTramite, Kardex } from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import { useDownloadFile } from "@/hooks/useUtils";
import { API_URL } from "@/config/enviroments";

const idStore = "useTramiteStore";
const apiResource = API_URL + "/api/tramite";

export const useTramiteStore = defineStore(idStore, () => {
    const TramiteResults = ref<Kardex[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit = ref<boolean>(false);

    async function listTramite() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Kardex> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            TramiteResults.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function saveObservationExternal(payload) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<HistorialTramite> = await axios.post(
            `${apiResource}/observation-external`,
            payload
        );
        return { historial_tramite: data, message, status }
    }

    async function saveObservationInternal(payload) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<HistorialTramite> = await axios.post(
            `${apiResource}/observation-internal`,
            payload
        );
        return { historial_tramite: data, message, status }
    }

    async function getAllObservationById(id: string) {
        const {
            data: { data, meta },
        }: ResponseList<HistorialTramite> = await axios.get(
            `${apiResource}/getAllObservationById/${id}`);
        return { historial_tramites: data, pagination: meta }

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
        TramiteResults,
        pagination,
        isSubmit,
        listTramite,
        cleanPagination,
        saveObservationExternal,
        saveObservationInternal,
        getAllObservationById
    };
});

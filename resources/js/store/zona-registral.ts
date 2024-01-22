import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { ZonaRegistral } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "RegistryZoneStore";
const apiResource = API_URL+"/api/registry-zone";
export const useZonaRegistralStore = defineStore(idStore, () => {
    const ZonaRegistrales = ref<ZonaRegistral[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarZonaRegistral(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<ZonaRegistral> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                ZonaRegistrales.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveZonaRegistral(item: ZonaRegistral) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ZonaRegistral> = await axios.post(
            `${apiResource}`,
            item
        );
        return { ZonaRegistral: data, message, status };
    }

    async function updateZonaRegistral(id: String, item: ZonaRegistral) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ZonaRegistral> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { ZonaRegistral: data, message, status };
    }

    async function findZonaRegistralById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ZonaRegistral> = await axios.get(`${apiResource}/${id}`);
        return { ZonaRegistral: data, message, status };
    }

    async function disabledZonaRegistral(item: ZonaRegistral) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ZonaRegistral> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { ZonaRegistral: data, message, status };
    }

    async function enabledZonaRegistral(item: ZonaRegistral) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ZonaRegistral> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { ZonaRegistral: data, message, status };
    }

    return {
        ZonaRegistrales,
        pagination,
        isLoading,
        listarZonaRegistral,
        saveZonaRegistral,
        updateZonaRegistral,
        findZonaRegistralById,
        disabledZonaRegistral,
        enabledZonaRegistral,
    };
});

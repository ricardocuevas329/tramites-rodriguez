import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { ComparecienteBloqueado } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "CompareBlockedStore";
const apiResource = API_URL+"/api/compare-blocked";
export const useComparecienteBloqueadoStore = defineStore(idStore, () => {
    const ComparecienteBloqueados = ref<ComparecienteBloqueado[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarComparecienteBloqueado(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<ComparecienteBloqueado> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
            if (data.length) {
                ComparecienteBloqueados.value = data;
                pagination.value = meta;
            }
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveComparecienteBloqueado(item: ComparecienteBloqueado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ComparecienteBloqueado> = await axios.post(
            `${apiResource}`,
            item
        );
        return { ComparecienteBloqueado: data, message, status };
    }

    async function updateComparecienteBloqueado(id: String, item: ComparecienteBloqueado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ComparecienteBloqueado> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { ComparecienteBloqueado: data, message, status };
    }

    async function findComparecienteBloqueadoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ComparecienteBloqueado> = await axios.get(`${apiResource}/${id}`);
        return { ComparecienteBloqueado: data, message, status };
    }

    async function disabledComparecienteBloqueado(item: ComparecienteBloqueado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ComparecienteBloqueado> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { ComparecienteBloqueado: data, message, status };
    }

    async function enabledComparecienteBloqueado(item: ComparecienteBloqueado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ComparecienteBloqueado> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { ComparecienteBloqueado: data, message, status };
    }

    async function destroyFileComparecienteBloqueado(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ComparecienteBloqueado> = await axios.put(
            `${apiResource}/file/${id}`
        );
        return { ComparecienteBloqueado: data, message, status };
    }

    return {
        ComparecienteBloqueados,
        pagination,
        isLoading,
        listarComparecienteBloqueado,
        saveComparecienteBloqueado,
        updateComparecienteBloqueado,
        findComparecienteBloqueadoById,
        disabledComparecienteBloqueado,
        enabledComparecienteBloqueado,
        destroyFileComparecienteBloqueado
    };
});

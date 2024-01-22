import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Pais } from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "PaisStore";
const apiResource = API_URL+"/api/pais";

export const usePaisStore = defineStore(idStore, () => {
    const Paises = ref<Pais[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarPais(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Pais> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Paises.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function savePais(item: Pais) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Pais> = await axios.post(`${apiResource}`, item);
        return { Pais: data, message, status };
    }

    async function updatePais(id: String, item: Pais) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Pais> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Pais: data, message, status };
    }

    async function findPaisById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Pais> = await axios.get(`${apiResource}/${id}`);
        return { Pais: data, message, status };
    }

    async function disabledPais(item: Pais) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Pais> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Pais: data, message, status };
    }

    async function enabledPais(item: Pais) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Pais> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Pais: data, message, status };
    }
    return {
        isLoading,
        Paises,
        pagination,
        listarPais,
        savePais,
        updatePais,
        findPaisById,
        disabledPais,
        enabledPais,
    };
});

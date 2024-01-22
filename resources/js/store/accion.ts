import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Accion } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "AccionStore";
const apiResource = API_URL+"/api/action";
export const useAccionStore = defineStore(idStore, () => {
    const Acciones = ref<Accion[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarAccion(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Accion> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Acciones.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveAccion(item: Accion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Accion> = await axios.post(
            `${apiResource}`,
            item
        );
        return { accion: data, message, status };
    }

    async function updateAccion(id: String, item: Accion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Accion> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { accion: data, message, status };
    }

    async function findAccionById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Accion> = await axios.get(`${apiResource}/${id}`);
        return { accion: data, message, status };
    }

    async function disabledAccion(item: Accion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Accion> = await axios.put(
            `${apiResource}/disabled/${item.i_codigo}`
        );
        return { accion: data, message, status };
    }

    async function enabledAccion(item: Accion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Accion> = await axios.put(
            `${apiResource}/enabled/${item.i_codigo}`
        );
        return { accion: data, message, status };
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
        cleanPagination,
        Acciones,
        pagination,
        isLoading,
        listarAccion,
        saveAccion,
        updateAccion,
        findAccionById,
        disabledAccion,
        enabledAccion,
    };
});

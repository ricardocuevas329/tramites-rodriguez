import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Unidad } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "UnidadStore";
const apiResource = API_URL+"/api/unidad";
export const useUnidadStore = defineStore(idStore, () => {
    const Unidades = ref<Unidad[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarUnidad(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Unidad> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Unidades.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveUnidad(item: Unidad) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Unidad> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Unidad: data, message, status };
    }

    async function updateUnidad(id: String, item: Unidad) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Unidad> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Unidad: data, message, status };
    }

    async function findUnidadById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Unidad> = await axios.get(`${apiResource}/${id}`);
        return { Unidad: data, message, status };
    }

    async function disabledUnidad(item: Unidad) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Unidad> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Unidad: data, message, status };
    }

    async function enabledUnidad(item: Unidad) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Unidad> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Unidad: data, message, status };
    }

    return {
        Unidades,
        pagination,
        isLoading,
        listarUnidad,
        saveUnidad,
        updateUnidad,
        findUnidadById,
        disabledUnidad,
        enabledUnidad,
    };
});

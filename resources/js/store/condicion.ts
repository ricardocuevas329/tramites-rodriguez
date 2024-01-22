import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Condicion } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "CondicionStore";
const apiResource = API_URL+"/api/condicion";
export const useCondicionStore = defineStore(idStore, () => {
    const Condiciones = ref<Condicion[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarCondicion(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Condicion> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Condiciones.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveCondicion(item: Condicion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Condicion> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Condicion: data, message, status };
    }

    async function updateCondicion(id: String, item: Condicion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Condicion> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Condicion: data, message, status };
    }

    async function findCondicionById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Condicion> = await axios.get(`${apiResource}/${id}`);
        return { Condicion: data, message, status };
    }

    async function disabledCondicion(item: Condicion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Condicion> = await axios.put(
            `${apiResource}/disabled/${item.id}`
        );
        return { Condicion: data, message, status };
    }

    async function enabledCondicion(item: Condicion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Condicion> = await axios.put(
            `${apiResource}/enabled/${item.id}`
        );
        return { Condicion: data, message, status };
    }

    return {
        Condiciones,
        pagination,
        isLoading,
        listarCondicion,
        saveCondicion,
        updateCondicion,
        findCondicionById,
        disabledCondicion,
        enabledCondicion,
    };
});

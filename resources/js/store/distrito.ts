import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Distrito } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "DistritoStore";
const apiResource = API_URL+"/api/distrito";
export const useDistritoStore = defineStore(idStore, () => {
    const Distritos = ref<Distrito[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarDistrito(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Distrito> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Distritos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveDistrito(item: Distrito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Distrito> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Distrito: data, message, status };
    }

    async function updateDistrito(id: String, item: Distrito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Distrito> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Distrito: data, message, status };
    }

    async function findDistritoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Distrito> = await axios.get(`${apiResource}/${id}`);
        return { Distrito: data, message, status };
    }

    async function disabledDistrito(item: Distrito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Distrito> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Distrito: data, message, status };
    }

    async function enabledDistrito(item: Distrito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Distrito> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Distrito: data, message, status };
    }

    return {
        Distritos,
        pagination,
        isLoading,
        listarDistrito,
        saveDistrito,
        updateDistrito,
        findDistritoById,
        disabledDistrito,
        enabledDistrito,
    };
});

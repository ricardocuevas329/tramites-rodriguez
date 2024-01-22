import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import type { Ubigeo } from "@/models/ubigeo";
import {API_URL} from "@/config/enviroments";

const idStore = "UbigeoStore";
const apiResource = API_URL+"/api/ubigeo";
export const useUbigeoStore = defineStore(idStore, () => {
    const Ubigeos = ref<Ubigeo[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarUbigeo(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Ubigeo> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Ubigeos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function searchUbigeo(search: string = "") {
        try {
            const {
                data: { data },
            }: ResponseList<Ubigeo> = await axios.get(
                `${apiResource}/search-ubigeo?search=${search}`
            );
            if (data.length) {
                Ubigeos.value = data;
            }
        } catch (error) {
        } finally {
        }
    }

    async function saveUbigeo(item: Ubigeo) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Ubigeo> = await axios.post(`${apiResource}`, item);
        return { Ubigeo: data, message, status };
    }

    async function updateUbigeo(id: String, item: Ubigeo) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Ubigeo> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Ubigeo: data, message, status };
    }

    async function findUbigeoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Ubigeo> = await axios.get(`${apiResource}/${id}`);
        return { Ubigeo: data, message, status };
    }

    async function disabledUbigeo(item: Ubigeo) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Ubigeo> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Ubigeo: data, message, status };
    }

    async function enabledUbigeo(item: Ubigeo) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Ubigeo> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Ubigeo: data, message, status };
    }

    return {
        Ubigeos,
        pagination,
        isLoading,
        listarUbigeo,
        saveUbigeo,
        updateUbigeo,
        findUbigeoById,
        disabledUbigeo,
        enabledUbigeo,
        searchUbigeo,
    };
});

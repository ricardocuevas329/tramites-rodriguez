import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Provincia } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ProvinciaStore";
const apiResource = API_URL+"/api/provincia";
export const useProvinciaStore = defineStore(idStore, () => {
    const Provincias = ref<Provincia[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarProvincia(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Provincia> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Provincias.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveProvincia(item) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Provincia> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Provincia: data, message, status };
    }

    async function updateProvincia(id: String, item) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Provincia> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Provincia: data, message, status };
    }

    async function findProvinciaById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Provincia> = await axios.get(`${apiResource}/${id}`);
        return { Provincia: data, message, status };
    }

    async function disabledProvincia(item: Provincia) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Provincia> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Provincia: data, message, status };
    }

    async function enabledProvincia(item: Provincia) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Provincia> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Provincia: data, message, status };
    }

    return {
        Provincias,
        pagination,
        isLoading,
        listarProvincia,
        saveProvincia,
        updateProvincia,
        findProvinciaById,
        disabledProvincia,
        enabledProvincia,
    };
});

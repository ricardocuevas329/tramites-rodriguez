import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Servicio } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ServiceStore";
const apiResource = API_URL+"/api/service";
export const useServicioStore = defineStore(idStore, () => {
    const Servicios = ref<Servicio[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const ServicesResults = ref<Servicio[]>([]);

    async function listarServicio(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Servicio> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Servicios.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveServicio(item: Servicio) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Servicio> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Servicio: data, message, status };
    }

    async function updateServicio(id: String, item: Servicio) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Servicio> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Servicio: data, message, status };
    }

    async function findServicioById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Servicio> = await axios.get(`${apiResource}/${id}`);
        return { Servicio: data, message, status };
    }

    async function disabledServicio(item: Servicio) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Servicio> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Servicio: data, message, status };
    }

    async function enabledServicio(item: Servicio) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Servicio> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Servicio: data, message, status };
    }

    async function searchServicesActivesAllFast(search: string = '') {
        try {
            isLoading.value = true;
            const {
                data: { data, meta },
            }: ResponseList<Servicio> = await axios.get(
                `${apiResource}/list/actives/all/fast?search=${search}`
            );
            ServicesResults.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    return {
        searchServicesActivesAllFast,
        ServicesResults,
        Servicios,
        pagination,
        isLoading,
        listarServicio,
        saveServicio,
        updateServicio,
        findServicioById,
        disabledServicio,
        enabledServicio,
    };
});

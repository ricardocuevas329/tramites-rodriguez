import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { ModoPago } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ModoPagoStore";
const apiResource = API_URL+"/api/modo-pago";
export const useModoPagoStore = defineStore(idStore, () => {
    const ModoPagos = ref<ModoPago[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarModoPago(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<ModoPago> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                ModoPagos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveModoPago(item: ModoPago) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ModoPago> = await axios.post(
            `${apiResource}`,
            item
        );
        return { ModoPago: data, message, status };
    }

    async function updateModoPago(id: String, item: ModoPago) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ModoPago> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { ModoPago: data, message, status };
    }

    async function findModoPagoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ModoPago> = await axios.get(`${apiResource}/${id}`);
        return { ModoPago: data, message, status };
    }

    async function disabledModoPago(item: ModoPago) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ModoPago> = await axios.put(
            `${apiResource}/disabled/${item.i_codigo}`
        );
        return { ModoPago: data, message, status };
    }

    async function enabledModoPago(item: ModoPago) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<ModoPago> = await axios.put(
            `${apiResource}/enabled/${item.i_codigo}`
        );
        return { ModoPago: data, message, status };
    }

    return {
        ModoPagos,
        pagination,
        isLoading,
        listarModoPago,
        saveModoPago,
        updateModoPago,
        findModoPagoById,
        disabledModoPago,
        enabledModoPago,
    };
});

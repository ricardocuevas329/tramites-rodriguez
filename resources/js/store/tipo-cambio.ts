import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { TipoCambio } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ExchangeRateStore";
const apiResource = API_URL+"/api/exchange-rate";
export const useTipoCambioStore = defineStore(idStore, () => {
    const TipoCambios = ref<TipoCambio[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarTipoCambio(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<TipoCambio> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                TipoCambios.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveTipoCambio(item: TipoCambio) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCambio> = await axios.post(
            `${apiResource}`,
            item
        );
        return { TipoCambio: data, message, status };
    }

    async function updateTipoCambio(id: String, item: TipoCambio) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCambio> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { TipoCambio: data, message, status };
    }

    async function findTipoCambioById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCambio> = await axios.get(`${apiResource}/${id}`);
        return { TipoCambio: data, message, status };
    }

    async function disabledTipoCambio(item: TipoCambio) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCambio> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { TipoCambio: data, message, status };
    }

    async function enabledTipoCambio(item: TipoCambio) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCambio> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { TipoCambio: data, message, status };
    }

    return {
        TipoCambios,
        pagination,
        isLoading,
        listarTipoCambio,
        saveTipoCambio,
        updateTipoCambio,
        findTipoCambioById,
        disabledTipoCambio,
        enabledTipoCambio,
    };
});

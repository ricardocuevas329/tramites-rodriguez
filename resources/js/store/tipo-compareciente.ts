import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { TipoCompareciente } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "TipoComparecienteStore";
const apiResource = API_URL+"/api/tipo-compareciente";
export const useTipoComparecienteStore = defineStore(idStore, () => {
    const TipoComparecientes = ref<TipoCompareciente[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarTipoCompareciente(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<TipoCompareciente> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                TipoComparecientes.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveTipoCompareciente(item: TipoCompareciente) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCompareciente> = await axios.post(
            `${apiResource}`,
            item
        );
        return { TipoCompareciente: data, message, status };
    }

    async function updateTipoCompareciente(id: String, item: TipoCompareciente) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCompareciente> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { TipoCompareciente: data, message, status };
    }

    async function findTipoComparecienteById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCompareciente> = await axios.get(`${apiResource}/${id}`);
        return { TipoCompareciente: data, message, status };
    }

    async function disabledTipoCompareciente(item: TipoCompareciente) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCompareciente> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { TipoCompareciente: data, message, status };
    }

    async function enabledTipoCompareciente(item: TipoCompareciente) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<TipoCompareciente> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { TipoCompareciente: data, message, status };
    }

    return {
        TipoComparecientes,
        pagination,
        isLoading,
        listarTipoCompareciente,
        saveTipoCompareciente,
        updateTipoCompareciente,
        findTipoComparecienteById,
        disabledTipoCompareciente,
        enabledTipoCompareciente,
    };
});

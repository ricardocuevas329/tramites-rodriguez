import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Abogado } from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "LawyerStore";
const apiResource = API_URL +"/api/lawyer";

export const useAbogadoStore = defineStore(idStore, () => {
    const Abogados = ref<Abogado[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    async function listarAbogado() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value  ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Abogado> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                Abogados.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function searchAbogado(filter: string = '') {
        try {
            isLoading.value = true;
            let page = 1;
            const {
                data: { data, meta },
            }: ResponseList<Abogado> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${filter}`
            );
            Abogados.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveAbogado(item: Abogado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Abogado> = await axios.post(`${apiResource}`, item);
        return { abogado: data, message, status };
    }

    async function updateAbogado(id: String, item: Abogado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Abogado> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { abogado: data, message, status };
    }

    async function findAbogadoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Abogado> = await axios.get(`${apiResource}/${id}`);
        return { abogado: data, message, status };
    }

    async function disabledAbogado(item: Abogado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Abogado> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { abogado: data, message, status };
    }

    async function enabledAbogado(item: Abogado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Abogado> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { abogado: data, message, status };
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
        search,
        isLoading,
        Abogados,
        pagination,
        listarAbogado,
        saveAbogado,
        updateAbogado,
        findAbogadoById,
        disabledAbogado,
        enabledAbogado,
        cleanPagination,
        searchAbogado
    };
});

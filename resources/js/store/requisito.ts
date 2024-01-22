import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Requisito } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "RequisitoStore";
const apiResource = API_URL+"/api/requisito";
export const useRequisitoStore = defineStore(idStore, () => {
    const Requisitos = ref<Requisito[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarRequisito(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Requisito> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Requisitos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveRequisito(item: Requisito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Requisito> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Requisito: data, message, status };
    }

    async function updateRequisito(id: String, item: Requisito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Requisito> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Requisito: data, message, status };
    }

    async function findRequisitoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Requisito> = await axios.get(`${apiResource}/${id}`);
        return { Requisito: data, message, status };
    }

    async function disabledRequisito(item: Requisito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Requisito> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Requisito: data, message, status };
    }

    async function enabledRequisito(item: Requisito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Requisito> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Requisito: data, message, status };
    }

    return {
        Requisitos,
        pagination,
        isLoading,
        listarRequisito,
        saveRequisito,
        updateRequisito,
        findRequisitoById,
        disabledRequisito,
        enabledRequisito,
    };
});

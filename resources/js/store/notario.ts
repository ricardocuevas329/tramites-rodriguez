import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type {  Notario } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "NotaryStore";
const apiResource = API_URL+"/api/notary";
export const useNotarioStore = defineStore(idStore, () => {
    const Notarios = ref<Notario[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    async function listarNotario() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Notario> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                Notarios.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function searchNotario(filter:string = '') {
        try {
            isLoading.value = true;
            let page = 1;

            const {
                data: { data, meta },
            }: ResponseList<Notario> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${filter}`
            );
            Notarios.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function saveNotario(item: Notario) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Notario> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Notario: data, message, status };
    }

    async function updateNotario(id: String, item: Notario) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Notario> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Notario: data, message, status };
    }

    async function findNotarioById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Notario> = await axios.get(`${apiResource}/${id}`);
        return { Notario: data, message, status };
    }

    async function disabledNotario(item: Notario) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Notario> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Notario: data, message, status };
    }

    async function enabledNotario(item: Notario) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Notario> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Notario: data, message, status };
    }

    async function cleanPagination() {
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
        Notarios,
        pagination,
        isLoading,
        listarNotario,
        saveNotario,
        updateNotario,
        findNotarioById,
        disabledNotario,
        enabledNotario,
        cleanPagination,
        searchNotario
    };
});

import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "@/models/Pagination";
import type {Presencia} from "@/models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "useProcuradorStore";
const apiResource = API_URL + "/api/procurador";

export const useProcuradorStore = defineStore(idStore, () => {
    const procuradores = ref<Presencia[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit = ref<boolean>(false);

    async function listarProcuradores() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<Presencia> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            procuradores.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function saveProcuradores(item) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.post(`${apiResource}`, item);
        return {procuradores: data, message, status};
    }

    async function updateProcuradores(id: String, item) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return {procuradores: data, message, status};
    }

    async function findProcuradoresById(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.get(`${apiResource}/${id}`);
        return {procuradores: data, message, status};
    }

    async function saveInit(id: string) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.put(
            `${apiResource}/save/init/${id}`,
        );
        return {procurador: data, message, status};
    }

    async function saveFinish(id: string) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.put(
            `${apiResource}/save/finish/${id}`,
        );
        return {procurador: data, message, status};
    }


    async function saveInitUpload(id: string, payload) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.post(
            `${apiResource}/save/documents/init/${id}`,
            payload
        );
        return {procurador: data, message, status};
    }

 

    function cleanPagination() {
        pagination.value = {
            current_page: 0,
            from: 0,
            last_page: 0,
            per_page: 0,
            to: 0,
            total: 0
        }
    }

    return {
        search,
        isLoading,
        procuradores,
        pagination,
        isSubmit,
        listarProcuradores,
        saveProcuradores,
        updateProcuradores,
        findProcuradoresById,
        cleanPagination,
        saveFinish,
        saveInit,
        saveInitUpload
    };
});

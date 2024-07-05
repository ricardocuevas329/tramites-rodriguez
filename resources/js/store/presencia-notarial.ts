import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "@/models/Pagination";
import type {Presencia} from "@/models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "presenciaNotarialStore";
const apiResource = API_URL + "/api/presencia-notarial";

export const usePresenciaNotarialStore = defineStore(idStore, () => {
    const presenciaNotariales = ref<Presencia[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit = ref<boolean>(false);

    async function listarPresenciaNotarial() {
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
            presenciaNotariales.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function savePresenciaNotarial(item) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.post(`${apiResource}`, item);
        return {presencial_notarial: data, message, status};
    }

    async function updatePresenciaNotarial(id: String, item) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return {presencial_notarial: data, message, status};
    }

    async function findPresenciaNotarialById(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Presencia> = await axios.get(`${apiResource}/${id}`);
        return {presencial_notarial: data, message, status};
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
        presenciaNotariales,
        pagination,
        isSubmit,
        listarPresenciaNotarial,
        savePresenciaNotarial,
        updatePresenciaNotarial,
        findPresenciaNotarialById,
        cleanPagination,
    };
});

import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "@/models/Pagination";
import type {TipoKardex} from "@/models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "TipoKardexStore";
const apiResource = API_URL + "/api/tipo-kardex";

export const useTipoKardexStore = defineStore(idStore, () => {
    const TipoKardexs = ref<TipoKardex[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit = ref<boolean>(false);

    async function listTipoKardexActives() {
        try {
            isLoading.value = true;
            const {
                data: {data},
            }: ResponseList<TipoKardex> = await axios.get(
                `${apiResource}/actives`
            );
            TipoKardexs.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function listTipoKardex() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<TipoKardex> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            TipoKardexs.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function saveTipoKardex(item: TipoKardex) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<TipoKardex> = await axios.post(`${apiResource}`, item);
        return {TipoKardex: data, message, status};
    }

    async function updateTipoKardex(id: String, item: TipoKardex) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<TipoKardex> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return {TipoKardex: data, message, status};
    }

    async function findTipoKardexById(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<TipoKardex> = await axios.get(`${apiResource}/${id}`);
        return {TipoKardex: data, message, status};
    }

    async function disabledTipoKardex(item: TipoKardex) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<TipoKardex> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return {TipoKardex: data, message, status};
    }

    async function enabledTipoKardex(item: TipoKardex) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<TipoKardex> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return {TipoKardex: data, message, status};
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
        TipoKardexs,
        pagination,
        isSubmit,
        listTipoKardex,
        saveTipoKardex,
        updateTipoKardex,
        findTipoKardexById,
        disabledTipoKardex,
        enabledTipoKardex,
        cleanPagination,
        listTipoKardexActives

    };
});

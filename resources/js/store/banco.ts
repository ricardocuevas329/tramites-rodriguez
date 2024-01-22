import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Banco } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "BancoStore";
const apiResource = API_URL+"/api/bank";
export const useBancoStore = defineStore(idStore, () => {
    const Bancos = ref<Banco[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const AllBancos = ref<Banco[]>([]);
    async function listarBancos() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value  ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Banco> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                Bancos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function listAllBancos() {
        try {
            isLoading.value = true;
            const {
                data: { data, meta },
            }: ResponseList<Banco> = await axios.get(
                `${apiResource}/list/all`
            );
            AllBancos.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function saveBanco(item: Banco) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Banco> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Banco: data, message, status };
    }

    async function updateBanco(id: String, item: Banco) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Banco> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Banco: data, message, status };
    }

    async function findBancoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Banco> = await axios.get(`${apiResource}/${id}`);
        return { Banco: data, message, status };
    }


    async function disabledBanco(item: Banco) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Banco> = await axios.put(
            `${apiResource}/disabled/${item.id_cod}`
        );
        return { Banco: data, message, status };
    }

    async function enabledBanco(item: Banco) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Banco> = await axios.put(
            `${apiResource}/enabled/${item.id_cod}`
        );
        return { Banco: data, message, status };
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
        Bancos,
        pagination,
        isLoading,
        listarBancos,
        saveBanco,
        updateBanco,
        findBancoById,
        disabledBanco,
        enabledBanco,
        cleanPagination,
        listAllBancos,
        AllBancos,
    };
});

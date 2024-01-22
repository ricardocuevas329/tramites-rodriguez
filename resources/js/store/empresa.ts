import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Empresa } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "CompanyStore";
const apiResource = API_URL+"/api/company";
export const useEmpresaStore = defineStore(idStore, () => {
    const Empresas = ref<Empresa[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    async function listarEmpresa() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Empresa> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                Empresas.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function searchEmpresa(search: string) {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search  ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Empresa> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                Empresas.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveEmpresa(item: Empresa) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Empresa> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Empresa: data, message, status };
    }

    async function updateEmpresa(id: String, item: Empresa) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Empresa> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Empresa: data, message, status };
    }

    async function findEmpresaById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Empresa> = await axios.get(`${apiResource}/${id}`);
        return { Empresa: data, message, status };
    }

    async function disabledEmpresa(item: Empresa) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Empresa> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Empresa: data, message, status };
    }

    async function enabledEmpresa(item: Empresa) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Empresa> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Empresa: data, message, status };
    }

    async function findEmpresaByRuc(numdocu: string) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Empresa> = await axios.get(
            `${apiResource}/find/ruc/${numdocu}`
        );
        return { Empresa: data, message, status };
    }


    async function findEmpresaDocument(tipodocu: string, numdocu: string) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Empresa> = await axios.get(
            `${apiResource}/find/document?tipodocu=${tipodocu}&numdocu=${numdocu}`
        );
        return { Empresa: data, message, status };
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
        Empresas,
        pagination,
        isLoading,
        cleanPagination,
        listarEmpresa,
        searchEmpresa,
        saveEmpresa,
        updateEmpresa,
        findEmpresaById,
        disabledEmpresa,
        enabledEmpresa,
        findEmpresaByRuc,
        findEmpresaDocument
    };
});

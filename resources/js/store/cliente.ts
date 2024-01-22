import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Cliente } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ClientStore";
const apiResource = API_URL+"/api/client";
export const useClienteStore = defineStore(idStore, () => {
    const Clientes = ref<Cliente[]>([]);
    const ClientexDocu = ref<Cliente[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    async function listarCliente() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value  ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Cliente> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                Clientes.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function searchCliente(search: string) {
        try {
            isLoading.value = true;
            let searchFilter = search  ?? ''
            const {
                data: { data  },
            }: ResponseList<Cliente> = await axios.get(
                `${apiResource}/search?search=${searchFilter}`
            );
            Clientes.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function saveCliente(item: Cliente) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cliente> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Cliente: data, message, status };
    }

    async function updateCliente(id: String, item: Cliente) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cliente> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Cliente: data, message, status };
    }

    async function findClienteById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cliente> = await axios.get(`${apiResource}/${id}`);
        return { Cliente: data, message, status };
    }

    async function findClienteByDocument(tipodocu: string, numdocu: string) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cliente> = await axios.get(
            `${apiResource}/find/document?tipodocu=${tipodocu}&numdocu=${numdocu}`
        );
        return { Cliente: data, message, status };
    }

    async function disabledCliente(item: Cliente) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cliente> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Cliente: data, message, status };
    }

    async function enabledCliente(item: Cliente) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cliente> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Cliente: data, message, status };
    }

    async function findClienteByDni(numdocu: string) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cliente> = await axios.get(
            `${apiResource}/find/dni/${numdocu}`
        );
        return { Cliente: data, message, status };
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
        Clientes,
        ClientexDocu,
        pagination,
        isLoading,
        listarCliente,
        searchCliente,
        saveCliente,
        updateCliente,
        findClienteById,
        findClienteByDocument,
        disabledCliente,
        enabledCliente,
        cleanPagination,
        findClienteByDni
    };
});

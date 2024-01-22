import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Cliente, PermisoViajeExternal} from "@/models/types";
import type {ResponseByEntity} from "@/models/extends";
import type {ResponseList} from "@/models/extends";
import type {Pagination} from "@/models/Pagination";

const idStore = "PermisoViajeExternalStore";
const apiResource = "/api/external/permission-travel";

export const usePermisoViajeExternalStore = defineStore(idStore, () => {
    const PermisoViajes = ref<PermisoViajeExternal[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');

    async function listMyRecords() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<PermisoViajeExternal> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            PermisoViajes.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }


    }

    async function savePermisoViaje(item: PermisoViajeExternal) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<PermisoViajeExternal> = await axios.post(`${apiResource}`, item);
        return {PermisoViaje: data, message, status};
    }

    async function findClienteByDocument(tipodocu: string, numdocu: string) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Cliente> = await axios.get(
            `${apiResource}/client/find/document?tipodocu=${tipodocu}&numdocu=${numdocu}`
        );
        return {Cliente: data, message, status};
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
        pagination,
        search,
        isLoading,
        PermisoViajes,
        savePermisoViaje,
        findClienteByDocument,
        listMyRecords

    };
});

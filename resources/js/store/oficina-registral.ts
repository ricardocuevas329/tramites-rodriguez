import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "../models/Pagination";
import type {OficinaRegistral} from "@/models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "registrationOfficeStore";
const apiResource = API_URL + "/api/registration-office";

export const useRegistrationOfficeStore = defineStore(idStore, () => {
    const registrationOffice = ref<OficinaRegistral[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');

    async function listOficinaRegistral() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<OficinaRegistral> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            registrationOffice.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function listRegistrationOfficeActiveBySignature() {
        try {
            isLoading.value = true;
            const {
                data: {data},
            }: ResponseList<OficinaRegistral> = await axios.get(
                `${apiResource}/list/ActiveBySignature`
            );
            registrationOffice.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function searchOficinaRegistral(filter: string = '') {
        try {
            isLoading.value = true;
            let page = 1;
            const {
                data: {data, meta},
            }: ResponseList<OficinaRegistral> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${filter}`
            );
            registrationOffice.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveOficinaRegistral(item: OficinaRegistral) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<OficinaRegistral> = await axios.post(`${apiResource}`, item);
        return {registrationOffice: data, message, status};
    }

    async function updateOficinaRegistral(id: String, item: OficinaRegistral) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<OficinaRegistral> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return {registrationOffice: data, message, status};
    }

    async function findOficinaRegistralById(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<OficinaRegistral> = await axios.get(`${apiResource}/${id}`);
        return {oficinaRegistral: data, message, status};
    }

    async function disabledOficinaRegistral(item: OficinaRegistral) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<OficinaRegistral> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return {registrationOffice: data, message, status};
    }

    async function enabledOficinaRegistral(item: OficinaRegistral) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<OficinaRegistral> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return {registrationOffice: data, message, status};
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
        registrationOffice,
        pagination,
        listOficinaRegistral,
        saveOficinaRegistral,
        updateOficinaRegistral,
        findOficinaRegistralById,
        disabledOficinaRegistral,
        enabledOficinaRegistral,
        cleanPagination,
        searchOficinaRegistral,
        listRegistrationOfficeActiveBySignature
    };
});

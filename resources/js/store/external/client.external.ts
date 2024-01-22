import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {ResponseByEntity} from "@/models/extends";
import type {Pagination} from "@/models/Pagination";
import type {ResponseList} from "@/models/extends";

const idStore = "useClientExternalStore";
const apiResource = "/api/external/client";

export const useClientExternalStore = defineStore(idStore, () => {

    const recordsClients = ref<any>();
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const recordsRegisterPublics = ref<any>();

    async function listRegisterPublic(id: number) {
        try {
            recordsRegisterPublics.value = {}
            const {
                data: {data},
            }: ResponseList<any> = await axios.post(
                `${apiResource}/get/register-public`,{
                    id
                }
            );
            recordsRegisterPublics.value = data;

        } catch (error) {
        } finally {

        }


    }

    async function listProcedure() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<any> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            recordsClients.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }


    }
    async function saveClient(item) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<any> = await axios.post(`${apiResource}`, item);
        return {Client: data, message, status};
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
        recordsClients,
        isLoading,
        saveClient,
        listProcedure,
        listRegisterPublic,
        recordsRegisterPublics,
        cleanPagination
    };
});

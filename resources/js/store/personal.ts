import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { User as Personal } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import type {IFormChangePassword} from "@/models/personal.interface";
import {API_URL} from "@/config/enviroments";

const idStore = "PersonalStore";
const apiResource = API_URL+"/api/personal";
export const usePersonalStore = defineStore(idStore, () => {
    const Personales = ref<Personal[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    async function listarPersonal() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Personal> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );

                Personales.value = data;
                pagination.value = meta;

        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function searchPersonal(filter: string) {
        try {
            isLoading.value = true;
            let searchFilter = filter ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Personal> = await axios.get(
                `${apiResource}/get/search?search=${searchFilter}`
            );

            Personales.value = data;

        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function listarActivos() {
        try {

            const {
                data: { data },
            }: ResponseList<Personal> = await axios.get(
                `${apiResource}/listar/activos`
            );
            if (data.length) {
                Personales.value = data;
            }
        } catch (error) {
        } finally {

        }
    }

    async function savePersonal(item: Personal) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Personal> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Personal: data, message, status };
    }

    async function updatePersonal(id: String, item: Personal) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Personal> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Personal: data, message, status };
    }

    async function findPersonalById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Personal> = await axios.get(`${apiResource}/${id}`);
        return { Personal: data, message, status };
    }

    async function disabledPersonal(item: Personal) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Personal> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Personal: data, message, status };
    }

    async function enabledPersonal(item: Personal) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Personal> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Personal: data, message, status };
    }

    async function changePassPersonal(id: String, item: IFormChangePassword ) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Personal> = await axios.put(
            `${apiResource}/changePassword/${id}`,
            item
        );
        return { Personal: data, message, status };
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
        Personales,
        pagination,
        isLoading,
        listarPersonal,
        savePersonal,
        updatePersonal,
        findPersonalById,
        disabledPersonal,
        enabledPersonal,
        cleanPagination,
        listarActivos,
        changePassPersonal,
        searchPersonal
    };
});

import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Permission } from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "PermissionStore";
const apiResource = API_URL+"/api/permission";

export const usePermissionStore = defineStore(idStore, () => {
    const Permissions = ref<Permission[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('')

    async function listarPermission() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Permission> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                Permissions.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function savePermission(name: string) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Permission> = await axios.post(`${apiResource}`, {name});
        return { Permission: data, message, status };
    }

    async function updatePermission(id: String, item: Permission) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Permission> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Permission: data, message, status };
    }

    async function findPermissionById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Permission> = await axios.get(`${apiResource}/${id}`);
        return { Permission: data, message, status };
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
        cleanPagination,
        search,
        isLoading,
        Permissions,
        pagination,
        listarPermission,
        savePermission,
        updatePermission,
        findPermissionById
    };
});

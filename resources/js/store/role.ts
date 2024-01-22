import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Role } from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "RoleStore";
const apiResource = API_URL+"/api/role";

export const useRoleStore = defineStore(idStore, () => {
    const Roles = ref<Role[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarRoles(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Role> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Roles.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveRole(name: string) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Role> = await axios.post(`${apiResource}`, {name});
        return { Role: data, message, status };
    }

    async function updateRole(id: String, item: Role) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Role> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Role: data, message, status };
    }

    async function findRoleById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Role> = await axios.get(`${apiResource}/${id}`);
        return { Role: data, message, status };
    }

    return {
        isLoading,
        Roles,
        pagination,
        listarRoles,
        saveRole,
        updateRole,
        findRoleById
    };
});

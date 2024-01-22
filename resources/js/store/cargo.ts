import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Cargo } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "CargoStore";
const apiResource = API_URL+"/api/cargo";
export const useCargoStore = defineStore(idStore, () => {
    const Cargos = ref<Cargo[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarCargo(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Cargo> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Cargos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveCargo(item: Cargo) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cargo> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Cargo: data, message, status };
    }

    async function updateCargo(id: String, item: Cargo) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cargo> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Cargo: data, message, status };
    }

    async function findCargoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cargo> = await axios.get(`${apiResource}/${id}`);
        return { Cargo: data, message, status };
    }

    async function disabledCargo(item: Cargo) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cargo> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Cargo: data, message, status };
    }

    async function enabledCargo(item: Cargo) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Cargo> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Cargo: data, message, status };
    }

    return {
        Cargos,
        pagination,
        isLoading,
        listarCargo,
        saveCargo,
        updateCargo,
        findCargoById,
        disabledCargo,
        enabledCargo,
    };
});

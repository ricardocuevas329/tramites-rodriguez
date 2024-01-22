import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { CargoPublico } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "CargoPublicoStore";
const apiResource = API_URL+"/api/cargo-publico";
export const useCargoPublicoStore = defineStore(idStore, () => {
    const CargoPublicos = ref<CargoPublico[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarCargoPublico(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<CargoPublico> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                CargoPublicos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveCargoPublico(item: CargoPublico) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CargoPublico> = await axios.post(
            `${apiResource}`,
            item
        );
        return { CargoPublico: data, message, status };
    }

    async function updateCargoPublico(id: String, item: CargoPublico) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CargoPublico> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { CargoPublico: data, message, status };
    }

    async function findCargoPublicoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CargoPublico> = await axios.get(`${apiResource}/${id}`);
        return { CargoPublico: data, message, status };
    }

    async function disabledCargoPublico(item: CargoPublico) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CargoPublico> = await axios.put(
            `${apiResource}/disabled/${item.codigo}`
        );
        return { CargoPublico: data, message, status };
    }

    async function enabledCargoPublico(item: CargoPublico) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CargoPublico> = await axios.put(
            `${apiResource}/enabled/${item.codigo}`
        );
        return { CargoPublico: data, message, status };
    }

    return {
        CargoPublicos,
        pagination,
        isLoading,
        listarCargoPublico,
        saveCargoPublico,
        updateCargoPublico,
        findCargoPublicoById,
        disabledCargoPublico,
        enabledCargoPublico,
    };
});

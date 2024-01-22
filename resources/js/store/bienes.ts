import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Bien } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "propertyStore";
const apiResource = API_URL+"/api/property";
export const useBienStore = defineStore(idStore, () => {
    const Bienes = ref<Bien[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarBienes(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Bien> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Bienes.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveBien(item: Bien) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Bien> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Bien: data, message, status };
    }

    async function updateBien(id: String, item: Bien) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Bien> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Bien: data, message, status };
    }

    async function findBienById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Bien> = await axios.get(`${apiResource}/${id}`);
        return { Bien: data, message, status };
    }

    async function disabledBien(item: Bien) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Bien> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Bien: data, message, status };
    }

    async function enabledBien(item: Bien) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Bien> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Bien: data, message, status };
    }

    return {
        Bienes,
        pagination,
        isLoading,
        listarBienes,
        saveBien,
        updateBien,
        findBienById,
        disabledBien,
        enabledBien,
    };
});

import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Area } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "AreaStore";
const apiResource = API_URL+"/api/area";
export const useAreaStore = defineStore(idStore, () => {
    const Areas = ref<Area[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarAreas(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Area> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Areas.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveArea(item: Area) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Area> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Area: data, message, status };
    }

    async function updateArea(id: String, item: Area) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Area> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Area: data, message, status };
    }

    async function findAreaById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Area> = await axios.get(`${apiResource}/${id}`);
        return { Area: data, message, status };
    }

    async function disabledArea(item: Area) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Area> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Area: data, message, status };
    }

    async function enabledArea(item: Area) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Area> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Area: data, message, status };
    }

    return {
        Areas,
        pagination,
        isLoading,
        listarAreas,
        saveArea,
        updateArea,
        findAreaById,
        disabledArea,
        enabledArea,
    };
});

import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Profesion } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ProfessionStore";
const apiResource = API_URL+"/api/profession";
export const useProfesionStore = defineStore(idStore, () => {
    const Profesiones = ref<Profesion[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarProfesion(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Profesion> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Profesiones.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveProfesion(item: Profesion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Profesion> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Profesion: data, message, status };
    }

    async function updateProfesion(id: String, item: Profesion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Profesion> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Profesion: data, message, status };
    }

    async function findProfesionById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Profesion> = await axios.get(`${apiResource}/${id}`);
        return { Profesion: data, message, status };
    }

    async function disabledProfesion(item: Profesion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Profesion> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Profesion: data, message, status };
    }

    async function enabledProfesion(item: Profesion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Profesion> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Profesion: data, message, status };
    }

    return {
        Profesiones,
        pagination,
        isLoading,
        listarProfesion,
        saveProfesion,
        updateProfesion,
        findProfesionById,
        disabledProfesion,
        enabledProfesion,
    };
});

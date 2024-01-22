import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Nacionalidad } from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "NacionalidadStore";
const apiResource = API_URL+"/api/nacionalidad";

export const useNacionalidadStore = defineStore(idStore, () => {
    const Nacionalidades = ref<Nacionalidad[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarNacionalidad(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Nacionalidad> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                Nacionalidades.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function listarNacionalidadAll() {
        try {
            isLoading.value = true;
            const {
                data: { data, meta },
            }: ResponseList<Nacionalidad> = await axios.get(
                `${apiResource}-all`
            );
            Nacionalidades.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function saveNacionalidad(item: Nacionalidad) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Nacionalidad> = await axios.post(`${apiResource}`, item);
        return { Nacionalidad: data, message, status };
    }

    async function updateNacionalidad(id: String, item: Nacionalidad) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Nacionalidad> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Nacionalidad: data, message, status };
    }

    async function findNacionalidadById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Nacionalidad> = await axios.get(`${apiResource}/${id}`);
        return { Nacionalidad: data, message, status };
    }

    async function disabledNacionalidad(item: Nacionalidad) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Nacionalidad> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Nacionalidad: data, message, status };
    }

    async function enabledNacionalidad(item: Nacionalidad) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Nacionalidad> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Nacionalidad: data, message, status };
    }
    return {
        isLoading,
        Nacionalidades,
        pagination,
        listarNacionalidad,
        saveNacionalidad,
        updateNacionalidad,
        findNacionalidadById,
        disabledNacionalidad,
        enabledNacionalidad,
        listarNacionalidadAll
    };
});

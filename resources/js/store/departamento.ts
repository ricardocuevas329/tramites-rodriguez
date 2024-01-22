import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Departamento } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "DepartamentoStore";
const apiResource = API_URL+"/api/departamento";
export const useDepartamentoStore = defineStore(idStore, () => {
    const Departamentos = ref<Departamento[]>([]);
    const allDepartaments = ref<Departamento[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarDepartamento(search: string = "", per_page:number = 5) {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Departamento> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}&per_page=${per_page}`
            );
                Departamentos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function getAllDepartament() {
        try {
            isLoading.value = true;
            const {
                data: { data, meta },
            }: ResponseList<Departamento> = await axios.get(
                `${apiResource}/get/all`
            );
            allDepartaments.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function saveDepartamento(item: Departamento) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Departamento> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Departamento: data, message, status };
    }

    async function updateDepartamento(id: String, item: Departamento) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Departamento> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Departamento: data, message, status };
    }

    async function findDepartamentoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Departamento> = await axios.get(`${apiResource}/${id}`);
        return { Departamento: data, message, status };
    }

    async function disabledDepartamento(item: Departamento) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Departamento> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { Departamento: data, message, status };
    }

    async function enabledDepartamento(item: Departamento) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Departamento> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { Departamento: data, message, status };
    }

    return {
        getAllDepartament,
        Departamentos,
        pagination,
        isLoading,
        listarDepartamento,
        saveDepartamento,
        updateDepartamento,
        findDepartamentoById,
        disabledDepartamento,
        enabledDepartamento,
        allDepartaments
    };
});

import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Estado } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "EstadoStore";
const apiResource = API_URL+"/api/estado";
export const useEstadoStore = defineStore(idStore, () => {
    const Estados = ref<Estado[]>([]);
    const Referencias = ref<Estado[]>([]);
    const Condiciones = ref<Estado[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarEstado(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<Estado> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
            if (data.length) {
                Estados.value = data;
                pagination.value = meta;
            }
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function listarReferencia() {
        try {

            const {
                data: { data },
            }: ResponseList<Estado> = await axios.get(
                `${apiResource}/listar/referencia`
            );
            if (data.length) {
                Referencias.value = data;
            }
        } catch (error) {
        } finally {

        }
    }

    async function listarCondicion() {
        try {

            const {
                data: { data },
            }: ResponseList<Estado> = await axios.get(
                `${apiResource}/listar/condicion`
            );
            if (data.length) {
                Condiciones.value = data;
            }
        } catch (error) {
        } finally {

        }
    }

    async function saveEstado(item: Estado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Estado> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Estado: data, message, status };
    }

    async function updateEstado(id: String, item: Estado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Estado> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Estado: data, message, status };
    }

    async function findEstadoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Estado> = await axios.get(`${apiResource}/${id}`);
        return { Estado: data, message, status };
    }

    async function disabledEstado(item: Estado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Estado> = await axios.put(
            `${apiResource}/disabled/${item.i_codigo}`
        );
        return { Estado: data, message, status };
    }

    async function enabledEstado(item: Estado) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Estado> = await axios.put(
            `${apiResource}/enabled/${item.i_codigo}`
        );
        return { Estado: data, message, status };
    }

    async function listarRegistroDeEstadoFirma() {
        try {
            isLoading.value = true;
            const {
                data: { data },
            }: ResponseList<Estado> = await axios.get(
                `${apiResource}/listar/registro-firma`
            );
            if (data.length) {
                Estados.value = data;
            }
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    return {
        Estados,
        Referencias,
        Condiciones,
        pagination,
        isLoading,
        listarEstado,
        saveEstado,
        updateEstado,
        findEstadoById,
        disabledEstado,
        enabledEstado,
        listarReferencia,
        listarCondicion,
        listarRegistroDeEstadoFirma
    };
});

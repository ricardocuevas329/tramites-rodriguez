import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Configuracion } from "@/models/types";
import type { ResponseByEntity } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ConfiguracionStore";
const apiResource = API_URL+"/api/configuration";
export const useConfiguracionStore = defineStore(idStore, () => {
    const configuracion = ref<Configuracion>();
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarConfiguracion() {
        try {
            isLoading.value = true;
            const {
                data: { data, status },
            }: ResponseByEntity<Configuracion> = await axios.get(`${apiResource}`);
            if (status) {
                configuracion.value = data;
            }
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveConfiguracion(item: Configuracion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Configuracion> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Configuracion: data, message, status };
    }

    async function updateConfiguracion(id: String, item: Configuracion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Configuracion> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { configuracion: data, message, status };
    }

    async function findConfiguracionById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Configuracion> = await axios.get(`${apiResource}/${id}`);
        return { configuracion: data, message, status };
    }

    async function disabledConfiguracion(item: Configuracion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Configuracion> = await axios.put(
            `${apiResource}/disabled/${item.i_codigo}`
        );
        return { configuracion: data, message, status };
    }

    async function enabledConfiguracion(item: Configuracion) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Configuracion> = await axios.put(
            `${apiResource}/enabled/${item.i_codigo}`
        );
        return { configuracion: data, message, status };
    }

    return {
        configuracion,
        pagination,
        isLoading,
        listarConfiguracion,
        saveConfiguracion,
        updateConfiguracion,
        findConfiguracionById,
        disabledConfiguracion,
        enabledConfiguracion,
    };
});

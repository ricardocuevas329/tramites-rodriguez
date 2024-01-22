import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "../models/Pagination";
import type {DiligenciaCarta, DiligenciaProgramada} from "../models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import type {IDiligenciaProgramada} from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";
import {API_URL} from "@/config/enviroments";

const idStore = "Diligencia";
const apiResource = API_URL+"/api/diligence";
export const useDiligenciaCartaStore = defineStore(idStore, () => {
    const DiligenciaProgramadas = ref<DiligenciaProgramada[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');

    async function listarDiligencia() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<DiligenciaProgramada> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            DiligenciaProgramadas.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveDiligenciaProgramada(item: IDiligenciaProgramada) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<DiligenciaProgramada> = await axios.post(
            `${apiResource}`,
            item
        );
        return {DiligenciaProgramadas: data, message, status};
    }

    async function findDiligenciaCartaById(id: number) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<DiligenciaCarta> = await axios.get(`${apiResource}/view/shipments-scheduled/${id}`);
        return {DiligenciaCarta: data, message, status};
    }

    function limpiarPagination() {
        pagination.value = {
            current_page: 0,
            from: 0,
            last_page: 0,
            per_page: 0,
            to: 0,
            total: 0
        }
    }

    return {
        search,
        DiligenciaProgramadas,
        pagination,
        isLoading,
        listarDiligencia,
        saveDiligenciaProgramada,
        limpiarPagination,
        findDiligenciaCartaById
    };
});

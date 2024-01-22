import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { Carta, DetalleRango, DiligenciaCarta, User } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import type { IDiligenciaCartaForm } from "@/pages/ExtraProtocolar/Carta/Interfaces/diligenciaCarta.inteface";
import { useDownloadFile } from "@/hooks/useUtils";
import type { ICartaFormStore } from "@/pages/ExtraProtocolar/Carta/Interfaces/carta.interface";
import {API_URL} from "@/config/enviroments";

const idStore = "Carta";
const apiResource = API_URL+"/api/letter";
const apiResourceD = API_URL+"/api/letter-diligence";
export const useCartaStore = defineStore(idStore, () => {
    const Cartas = ref<Carta[]>([]);

    const isSubmit =  ref<boolean>(false);
    const isSubmitForm =  ref<boolean>(false);
    const DetalleRango = ref<DetalleRango[]>([]);
    const Users = ref<User[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    async function listarCarta() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value  ?? ''
            const {
                data: { data, meta },
            }: ResponseList<Carta> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
                Cartas.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function searchDistrito(search: string = "") {
        try {
            const {
                data: { data },
            }: ResponseList<DetalleRango> = await axios.get(
                `${apiResource}/search-district?search=${search}`
            );
            if (data.length) {
                DetalleRango.value = data;
            }
        } catch (error) {
        } finally {
        }
    }

    async function searchMotorizado(search: string = "") {
        try {
            const {
                data: { data },
            }: ResponseList<User> = await axios.get(
                `${apiResource}/motorized?search=${search}`
            );
            console.log(data);
            if (data.length) {
                Users.value = data;
            }
        } catch (error) {
        } finally {
        }
    }

    async function saveCarta(item: ICartaFormStore) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Carta> = await axios.post(
            `${apiResource}`,
            item
        );
        return { Carta: data, message, status };
    }

    async function saveCartaDiligencia(item: IDiligenciaCartaForm) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<DiligenciaCarta> = await axios.post(
            `${apiResourceD}`,
            item
        );
        return { DiligenciaCarta: data, message, status };
    }

    async function findDiligenciaCartaById(id: String) {
        console.log(id);
        const {
            data: { data, message, status },
        }: ResponseByEntity<DiligenciaCarta> = await axios.get(`${apiResourceD}/${id}`);
        return { DiligenciaCarta: data, message, status };
    }

    async function findCartaById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Carta> = await axios.get(`${apiResource}/${id}`);
        console.log(data);
        return { Carta: data, message, status };
    }

    async function updateObservation(id: String, item: Carta) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Carta> = await axios.put(
            `${apiResource}/observation/${id}`,
            item
        );
        return { Carta: data, message, status };
    }

    async function updateProgramation(id: String, item: Carta) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Carta> = await axios.put(
            `${apiResource}/programation/${id}`,
            item
        );
        return { Carta: data, message, status };
    }

    function cleanPagination() {
        pagination.value = {
            current_page:0,
            from:0,
            last_page:0,
            per_page:0,
            to:0,
            total:0
        }
    }


    async function generateDocument(item: Carta) {
        const { status } = await axios.get(`${apiResource}/generateDocument/${item.s_carta}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocument/${item.s_carta}`,
            { responseType: 'blob'});
            useDownloadFile( 'carta', '.docx', data)
        }

    }


    async function generateExcel(item: Carta) {
        const { status } = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_carta}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_carta}`,
            { responseType: 'blob'});
            useDownloadFile( 'carta' ,'.xlsx', data)
        }

    }

    async function generatePDF(item: Carta) {
        const { status } = await axios.get(`${apiResource}/generarOrden/${item.s_carta}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generarOrden/${item.s_carta}`,
            { responseType: 'blob'});
            useDownloadFile('carta' ,'.pdf', data)
        }

    }


    return {
        Cartas,
        DetalleRango,
        Users,
        pagination,
        isLoading,
        isSubmit,
        isSubmitForm,
        listarCarta,
        searchDistrito,
        searchMotorizado,
        saveCarta,
        updateObservation,
        updateProgramation,
        saveCartaDiligencia,
        findDiligenciaCartaById,
        findCartaById,
        search,
        cleanPagination,
        generateExcel,
        generatePDF,
        generateDocument
    };
});

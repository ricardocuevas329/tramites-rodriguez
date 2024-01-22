import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "@/models/Pagination";
import type {Libro, Servicio, Arancel} from "@/models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import {useDownloadFile} from "@/hooks/useUtils";
import type {
    IFormFieldLibro,
    IUpdateDateOpeningLibro,
    IUpdateObservationLibro
} from "@/pages/ExtraProtocolar/Libro/Interfaces/libro.interface";
import {API_URL} from "@/config/enviroments";

const idStore = "LibroStore";
const apiResource = API_URL+"/api/book";

export const useLibroStore = defineStore(idStore, () => {
    const Libros = ref<Libro[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit = ref<boolean>(false);
    const servicios = ref<Servicio[]>([])

    async function listarLibros() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<Libro> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            Libros.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function saveLibro(item: IFormFieldLibro) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro> = await axios.post(`${apiResource}`, item);
        return {libro: data, message, status};
    }

    async function updateLibro(id: String, item: IFormFieldLibro) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return {libro: data, message, status};
    }

    async function updateObservation(id: String, item: IUpdateObservationLibro) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro> = await axios.put(
            `${apiResource}/observation/${id}`,
            item
        );
        return {libro: data, message, status};
    }

    async function updateDateOpening(id: String, item: IUpdateDateOpeningLibro) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro> = await axios.put(
            `${apiResource}/updateDateOpening/${id}`,
            item
        );
        return {libro: data, message, status};
    }


    async function findLibroById(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro[]> = await axios.get(`${apiResource}/${id}`);
        return {libro: data, message, status};
    }

    async function disabledLibro(item: Libro) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro> = await axios.put(
            `${apiResource}/disabled/${item.s_libro}`
        );
        return {libro: data, message, status};
    }

    async function enabledLibro(item: Libro) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro> = await axios.put(
            `${apiResource}/enabled/${item.s_libro}`
        );
        return {libro: data, message, status};
    }

    async function generateDocument(item: Libro) {
        const {status} = await axios.get(`${apiResource}/generateDocument/${item.s_libro}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocument/${item.s_libro}`,
                {responseType: 'blob'});
            useDownloadFile('libro', '.docx', data)
        }

    }


    async function generateExcel(item: Libro) {
        const {status} = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_libro}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_libro}`,
                {responseType: 'blob'});
            useDownloadFile('libro', '.xlsx', data)
        }

    }

    async function generatePDF(item: Libro) {
        const {status} = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_libro}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_libro}`,
                {responseType: 'blob'});
            useDownloadFile('libro', '.pdf', data)
        }

    }

    async function deleteDocument(id: number) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro> = await axios.delete(
            `${apiResource}/document/${id}`
        );
        return {libro: data, message, status};
    }

    async function filterLibro(search: string) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Servicio[]> = await axios.post(
            `${apiResource}/filterBook`, {
                search
            }
        );
        servicios.value = data
    }

    async function getPrice(servicio: string) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Arancel> = await axios.post(
            `${apiResource}/getPrice`, {
                servicio
            }
        );
        return {arancel: data, message, status};
    }

    async function findPayment(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Libro[]> = await axios.get(`${apiResource}/findPayment/${id}`);
        return {libro: data, message, status};
    }



    function cleanPagination() {
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
        servicios,
        search,
        isLoading,
        Libros,
        pagination,
        isSubmit,
        listarLibros,
        saveLibro,
        updateLibro,
        findLibroById,
        disabledLibro,
        enabledLibro,
        cleanPagination,
        generateDocument,
        generateExcel,
        generatePDF,
        deleteDocument,
        filterLibro,
        getPrice,
        findPayment,
        updateObservation,
        updateDateOpening
    };
});

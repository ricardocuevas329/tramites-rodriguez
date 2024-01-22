import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "@/models/Pagination";
import type {ReciboPago, RegistroDeposito} from "@/models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import {useDownloadFile} from "@/hooks/useUtils";
import {API_URL} from "@/config/enviroments";

const idStore = "useRegistroVentaStore";
const apiResource = API_URL + "/api/registration-sale";

export const useRegistroVentaStore = defineStore(idStore, () => {
    const RegistrationSales = ref<ReciboPago[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit = ref<boolean>(false);

    async function listRegistrationSale() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<ReciboPago> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            RegistrationSales.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveRegistrationSale(item: ReciboPago) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<ReciboPago> = await axios.post(`${apiResource}`, item);
        return {ReciboPago: data, message, status};
    }

    async function updateRegistrationSale(id: String, item: ReciboPago) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<RegistroDeposito> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return {ReciboPago: data, message, status};
    }

    async function findRegistrationSaleById(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<RegistroDeposito> = await axios.get(`${apiResource}/${id}`);
        return {ReciboPago: data, message, status};
    }

    async function disabledRegistrationSale(item: ReciboPago) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<ReciboPago> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return {ReciboPago: data, message, status};
    }

    async function enabledRegistrationSale(item: ReciboPago) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<ReciboPago> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return {ReciboPago: data, message, status};
    }

    async function generateDocument(item: ReciboPago) {
        const {status} = await axios.get(`${apiResource}/generateDocument/${item.s_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocument/${item.s_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('registro_deposito_notaria', '.docx', data)
        }

    }


    async function generateExcel(item: ReciboPago) {
        const {status} = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('registro_deposito', '.xlsx', data)
        }

    }

    async function generatePDF(item: ReciboPago) {
        const {status} = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('registro_deposito', '.pdf', data)
        }

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
        search,
        isLoading,
        RegistrationSales,
        pagination,
        isSubmit,
        listRegistrationSale,
        saveRegistrationSale,
        updateRegistrationSale,
        findRegistrationSaleById,
        disabledRegistrationSale,
        enabledRegistrationSale,
        cleanPagination,
        generateDocument,
        generateExcel,
        generatePDF,
    };
});

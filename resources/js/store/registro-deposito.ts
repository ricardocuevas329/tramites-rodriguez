import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "@/models/Pagination";
import type {RegistroDeposito} from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import { useDownloadFile } from "@/hooks/useUtils";
import {API_URL} from "@/config/enviroments";

const idStore = "useRegistroDepositoStore";
const apiResource = API_URL+"/api/register-deposit";

export const useRegistroDepositoStore = defineStore(idStore, () => {
    const RegistroDepositos = ref<RegistroDeposito[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit =  ref<boolean>(false);

    async function listRegistroDeposito() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value  ?? ''
            const {
                data: { data, meta },
            }: ResponseList<RegistroDeposito> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            RegistroDepositos.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveRegistroDeposito(item: RegistroDeposito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<RegistroDeposito> = await axios.post(`${apiResource}`, item);
        return { RegistroDeposito: data, message, status };
    }

    async function updateRegistroDeposito(id: String, item: RegistroDeposito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<RegistroDeposito> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { RegistroDeposito: data, message, status };
    }

    async function findRegistroDepositoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<RegistroDeposito> = await axios.get(`${apiResource}/${id}`);
        return { RegistroDeposito: data, message, status };
    }

    async function disabledRegistroDeposito(item: RegistroDeposito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<RegistroDeposito> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { RegistroDeposito: data, message, status };
    }

    async function enabledRegistroDeposito(item: RegistroDeposito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<RegistroDeposito> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { RegistroDeposito: data, message, status };
    }

    async function generateDocument(item: RegistroDeposito) {
        const { status } = await axios.get(`${apiResource}/generateDocument/${item.s_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocument/${item.s_codigo}`,
                { responseType: 'blob'});
            useDownloadFile( 'registro_deposito_notaria', '.docx', data)
        }

    }


    async function generateExcel(item: RegistroDeposito) {
        const { status } = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_codigo}`,
                { responseType: 'blob'});
            useDownloadFile( 'registro_deposito' ,'.xlsx', data)
        }

    }

    async function generatePDF(item: RegistroDeposito) {
        const { status } = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_codigo}`,
                { responseType: 'blob'});
            useDownloadFile('registro_deposito' ,'.pdf', data)
        }

    }

    async function onAprove(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<RegistroDeposito> = await axios.put(`${apiResource}/aprove/${id}`);
        return { Banco: data, message, status };
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

    return {
        search,
        isLoading,
        RegistroDepositos,
        pagination,
        isSubmit,
        listRegistroDeposito,
        saveRegistroDeposito,
        updateRegistroDeposito,
        findRegistroDepositoById,
        disabledRegistroDeposito,
        enabledRegistroDeposito,
        cleanPagination,
        generateDocument,
        generateExcel,
        generatePDF,
        onAprove
    };
});

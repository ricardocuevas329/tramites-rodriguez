import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "@/models/Pagination";
import type {CopiaCertificada} from "@/models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import { useDownloadFile } from "@/hooks/useUtils";
import {API_URL} from "@/config/enviroments";

const idStore = "CertifiedCopyStore";
const apiResource = API_URL+"/api/certified-copy";

export const useCertifiedCopyStore = defineStore(idStore, () => {
    const CertifiedCopies = ref<CopiaCertificada[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmit =  ref<boolean>(false);


    async function listCertifiedCopies() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value  ?? ''
            const {
                data: { data, meta },
            }: ResponseList<CopiaCertificada> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            CertifiedCopies.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    async function saveCertifiedCopy(item: CopiaCertificada) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CopiaCertificada> = await axios.post(`${apiResource}`, item);
        return { CopiaCertificada: data, message, status };
    }

    async function updateCertifiedCopy(id: String, item: CopiaCertificada) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CopiaCertificada> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { CopiaCertificada: data, message, status };
    }

    async function findCertifiedCopyById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CopiaCertificada> = await axios.get(`${apiResource}/${id}`);
        return { CopiaCertificada: data, message, status };
    }

    async function disabledCertifiedCopy(item: CopiaCertificada) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CopiaCertificada> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return { CopiaCertificada: data, message, status };
    }

    async function enabledCertifiedCopy(item: CopiaCertificada) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<CopiaCertificada> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return { CopiaCertificada: data, message, status };
    }

    async function generateDocument(item: CopiaCertificada) {
        const { status } = await axios.get(`${apiResource}/generateDocument/${item.s_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocument/${item.s_codigo}`,
                { responseType: 'blob'});
            useDownloadFile( 'copia_certificada', '.docx', data)
        }

    }


    async function generateExcel(item: CopiaCertificada) {
        const { status } = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_codigo}`,
                { responseType: 'blob'});
            useDownloadFile( 'copia_certificada' ,'.xlsx', data)
        }

    }

    async function generatePDF(item: CopiaCertificada) {
        const { status } = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_codigo}`);
        if ( status === 200) {
            const { data } = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_codigo}`,
                { responseType: 'blob'});
            useDownloadFile('copia_certificada' ,'.pdf', data)
        }

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
        CertifiedCopies,
        pagination,
        isSubmit,
        listCertifiedCopies,
        saveCertifiedCopy,
        updateCertifiedCopy,
        findCertifiedCopyById,
        disabledCertifiedCopy,
        enabledCertifiedCopy,
        cleanPagination,
        generateDocument,
        generateExcel,
        generatePDF,
    };
});

import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Pagination} from "../models/Pagination";
import type {Firma, FirmaRepresentacion} from "../models/types";
import type {ResponseByEntity, ResponseList} from "@/models/extends";
import {API_URL} from "@/config/enviroments";
import {useDownloadFile} from "@/hooks/useUtils";

const idStore = "FirmaStore";
const apiResource = API_URL + "/api/signature";
type IUploadSignaturePhoto = {
    foto_firma: string
}
export const useFirmaStore = defineStore(idStore, () => {
    const Firmas = ref<Firma[]>([]);
    const SignatureRepresentation = ref<FirmaRepresentacion[]>([]);
    const isLoading = ref<boolean>(false);
    const isLoadingGetSignatureRepresentationById = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');

    async function listarRegistroFirmas() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? ''
            const {
                data: {data, meta},
            }: ResponseList<Firma> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );
            Firmas.value = data;
            pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function getSignatureRepresentationById(id_signature: string) {
        try {
            isLoadingGetSignatureRepresentationById.value = true;
            const {
                data: {data},
            }: ResponseList<FirmaRepresentacion> = await axios.get(
                `${apiResource}/SignatureRepresentationById/${id_signature}`
            );
            SignatureRepresentation.value = data;
        } catch (error) {
        } finally {
            isLoadingGetSignatureRepresentationById.value = false;
        }
    }

    async function saveRegistroFirma(item: Firma) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Firma> = await axios.post(
            `${apiResource}`,
            item
        );
        return {Firma: data, message, status};
    }

    async function updateRegistroFirma(id: String, item: Firma) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Firma> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return {Firma: data, message, status};
    }

    async function uploadPhotoSignature(id: String, item: IUploadSignaturePhoto) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Firma> = await axios.put(
            `${apiResource}/upload-photo/${id}`,
            item
        );
        return {Firma: data, message, status};
    }

    async function deletePhotoSignature(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Firma> = await axios.put(
            `${apiResource}/delete-photo/${id}`
        );
        return {Firma: data, message, status};
    }

    async function findFirmaById(id: String) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Firma> = await axios.get(`${apiResource}/${id}`);
        return {Firma: data, message, status};
    }

    async function disabledFirma(item: Firma) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Firma> = await axios.put(
            `${apiResource}/disabled/${item.s_codigo}`
        );
        return {Firma: data, message, status};
    }

    async function enabledFirma(item: Firma) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<Firma> = await axios.put(
            `${apiResource}/enabled/${item.s_codigo}`
        );
        return {Firma: data, message, status};
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

    async function generateDocument(item: Firma) {
        const {status} = await axios.get(`${apiResource}/generateDocument/${item.s_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocument/${item.s_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('registro_firma', '.docx', data)
        }

    }


    async function generateExcel(item: Firma) {
        const {status} = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocumentExcel/${item.s_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('registro_firma', '.xlsx', data)
        }

    }

    async function generatePDF(item: Firma) {
        const {status} = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_codigo}`);
        if (status === 200) {
            const {data} = await axios.get(`${apiResource}/generateDocumentPDF/${item.s_codigo}`,
                {responseType: 'blob'});
            useDownloadFile('registro_firma', '.pdf', data)
        }

    }

    async function saveSignaturePresentation(item: FirmaRepresentacion) {
        const {
            data: {data, message, status},
        }: ResponseByEntity<FirmaRepresentacion> = await axios.post(
            `${apiResource}/storeSignatureRepresentation`,
            item
        );
        return {SignaturePresentation: data, message, status};
    }

    return {
        search,
        Firmas,
        pagination,
        isLoading,
        isLoadingGetSignatureRepresentationById,
        saveRegistroFirma,
        updateRegistroFirma,
        findFirmaById,
        disabledFirma,
        enabledFirma,
        listarRegistroFirmas,
        cleanPagination,
        generateDocument,
        generateExcel,
        generatePDF,
        saveSignaturePresentation,
        getSignatureRepresentationById,
        SignatureRepresentation,
        uploadPhotoSignature,
        deletePhotoSignature
    };
});

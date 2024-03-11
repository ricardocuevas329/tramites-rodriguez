import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { ResponseByEntity } from "@/models/extends";
import type { Pagination } from "@/models/Pagination";
import type { ResponseList } from "@/models/extends";
import type { IGetParticipants, ISaveAsignationKardex } from "@/pages/External/Tramite/Interfaces/kardex.interface";
import type { IUploadFile } from "@/models/components/upload-file.interface";
import type { Kardex as IKardex } from "@/models/types";

const idStore = "useKardexExternalStore";
const apiResource = "/api/external/kardex";

export const useKardexExternalStore = defineStore(idStore, () => {

    const recordsKardex = ref<IKardex[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmitAction = ref<boolean>(false);
    const participants = ref<any[]>([]);

    async function listParticipants(item: IGetParticipants) {
        try {

            const {
                data: { data, meta },
            }: ResponseList<any> = await axios.post(
                `${apiResource}/get/participants`,
                item
            );
            participants.value = data;
        } catch (error) {
        } finally {

        }
    }

    async function listKardexActives() {
        try {
            isLoading.value = true;
            let searchFilter = search.value ?? ''
            const {
                data: { data, meta },
            }: ResponseList<IKardex> = await axios.get(
                `${apiResource}/get/tipo-kardex/actives?search=${searchFilter}`
            );
            recordsKardex.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }
    async function saveAsignationKardex(item: ISaveAsignationKardex) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<any> = await axios.post(`${apiResource}/save/asignation`, item);
        return { Kardex: data, message, status };
    }

    async function saveDocumentsExternal(item: IUploadFile[], id_kardex: number) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<any> = await axios.post(`${apiResource}/save/documents-external`, {
            documents: item,
            id_kardex
        });
        return { Kardex: data, message, status };
    }

    async function saveDocumentsInternal(item: IUploadFile[], id_kardex: number) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<any> = await axios.post(`${apiResource}/save/documents-internal`, {
            documents: item,
            id_kardex
        });
        return { Kardex: data, message, status };
    }

    return {
        participants,
        listParticipants,
        pagination,
        search,
        recordsKardex,
        isLoading,
        saveAsignationKardex,
        listKardexActives,
        isSubmitAction,
        saveDocumentsExternal,
        saveDocumentsInternal
    };
});

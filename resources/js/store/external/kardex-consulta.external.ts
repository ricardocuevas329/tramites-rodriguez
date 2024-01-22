import axios from "axios";
import {defineStore} from "pinia";
import {ref} from "vue";
import type {Kardex as IKardex, Participante as IParticipante} from "@/models/types";
import type {Pagination} from "@/models/Pagination";
import type {ResponseList} from "@/models/extends";
import type {IGetParticipants, ISaveAsignationKardex} from "@/pages/External/Tramite/Interfaces/kardex.interface";
import type {IFilterSearchKardex} from "@/pages/External/ConsultaTramite/Interfaces/filters.consulta-tramite.interface";

const idStore = "useKardexConsultaExternalStore";
const apiResource = "/api/external/kardex-consulta";


export const useKardexConsultaExternalStore = defineStore(idStore, () => {

    const recordsKardex = ref<IKardex[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const isSubmitAction = ref<boolean>(false);
    const participants = ref<IParticipante[]>([]);

    async function searchKardex(payload: IFilterSearchKardex
    ) {
        isLoading.value = true
        try {

            const {
                data: {data, meta},
            }: ResponseList<IKardex> = await axios.post(
                `${apiResource}/get/searchKardex`,
                payload
            );
            recordsKardex.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false
        }
    }

    async function listParticipants(item: IGetParticipants) {
        try {

            const {
                data: {data, meta},
            }: ResponseList<IParticipante> = await axios.post(
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
                data: {data, meta},
            }: ResponseList<any> = await axios.get(
                `${apiResource}/get/tipo-kardex/actives?search=${searchFilter}`
            );
            recordsKardex.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    return {
        searchKardex,
        listKardexActives,
        listParticipants,
        participants,
        pagination,
        search,
        recordsKardex,
        isLoading,
        isSubmitAction,
    };
});

import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Pagination } from "../models/Pagination";
import type { BancoDeposito } from "../models/types";
import type { ResponseByEntity, ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "BancoDepositoStore";
const apiResource = API_URL+"/api/banco-deposito";
export const useBancoDepositoStore = defineStore(idStore, () => {
    const BancoDepositos = ref<BancoDeposito[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    async function listarBancoDeposito(search: string = "") {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            const {
                data: { data, meta },
            }: ResponseList<BancoDeposito> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${search}`
            );
                BancoDepositos.value = data;
                pagination.value = meta;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }

    async function saveBancoDeposito(item: BancoDeposito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<BancoDeposito> = await axios.post(
            `${apiResource}`,
            item
        );
        return { BancoDeposito: data, message, status };
    }

    async function updateBancoDeposito(id: String, item: BancoDeposito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<BancoDeposito> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { BancoDeposito: data, message, status };
    }

    async function findBancoDepositoById(id: String) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<BancoDeposito> = await axios.get(`${apiResource}/${id}`);
        return { BancoDeposito: data, message, status };
    }

    async function disabledBancoDeposito(item: BancoDeposito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<BancoDeposito> = await axios.put(
            `${apiResource}/disabled/${item.i_codigo}`
        );
        return { BancoDeposito: data, message, status };
    }

    async function enabledBancoDeposito(item: BancoDeposito) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<BancoDeposito> = await axios.put(
            `${apiResource}/enabled/${item.i_codigo}`
        );
        return { BancoDeposito: data, message, status };
    }

    return {
        BancoDepositos,
        pagination,
        isLoading,
        listarBancoDeposito,
        saveBancoDeposito,
        updateBancoDeposito,
        findBancoDepositoById,
        disabledBancoDeposito,
        enabledBancoDeposito,
    };
});

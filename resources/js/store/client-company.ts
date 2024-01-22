import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { ResponseList } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ClientCompanyStore";
const apiResource = API_URL+"/api/client-company";
export const useClientCompanyStore = defineStore(idStore, () => {
    const ClientsCompanies = ref<any[]>([]);
    const isLoading = ref<boolean>(false);

    async function searchClientCompany(search: string) {
        try {
            isLoading.value = true;
            let searchFilter = search  ?? ''
            const {
                data: { data  },
            }: ResponseList<any> = await axios.get(
                `${apiResource}/search?search=${searchFilter}`
            );
            ClientsCompanies.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false;
        }
    }


    return {
        ClientsCompanies,
        isLoading,
        searchClientCompany,
    };
});

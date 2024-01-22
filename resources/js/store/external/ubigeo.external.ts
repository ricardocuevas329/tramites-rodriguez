import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { ResponseList } from "@/models/extends";
import type { Ubigeo } from "@/models/ubigeo";

const idStore = "UbigeoExternalStore";
const apiResource = "/api/external/ubigeo";
export const useUbigeoExternalStore = defineStore(idStore, () => {
    const Ubigeos = ref<Ubigeo[]>([]);

    async function searchUbigeo(search: string = "") {
        try {
            const {
                data: { data },
            }: ResponseList<Ubigeo> = await axios.get(
                `${apiResource}/search-ubigeo?search=${search}`
            );
            if (data.length) {
                Ubigeos.value = data;
            }
        } catch (error) {
        } finally {
        }
    }




    return {
        Ubigeos,
        searchUbigeo,
    };
});

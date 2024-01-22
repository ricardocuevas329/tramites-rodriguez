import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { Nacionalidad } from "@/models/types";
import type { ResponseList } from "@/models/extends";

const idStore = "NacionalidadExternalStore";
const apiResource = "/api/external/nacionalidad";

export const useNacionalidadExternalStore = defineStore(idStore, () => {
    const Nacionalidades = ref<Nacionalidad[]>([]);

    async function listarNacionalidadAll() {
        try {
            const {
                data: { data, meta },
            }: ResponseList<Nacionalidad> = await axios.get(
                `${apiResource}-all`
            );
            Nacionalidades.value = data;
        } catch (error) {
        } finally {
        }
    }


    return {
        Nacionalidades,
        listarNacionalidadAll
    };
});

import axios from "axios";
import { defineStore } from "pinia";
import type { Participante } from "@/models/types";
import type { ResponseByEntity } from "@/models/extends";
import {API_URL} from "@/config/enviroments";

const idStore = "ParticipanteStore";
const apiResource = API_URL+"/api/participant";

export const useParticipanteStore = defineStore(idStore, () => {

    async function updateParticipante(id: String, item: Participante) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Participante> = await axios.put(
            `${apiResource}/${id}`,
            item
        );
        return { Participante: data, message, status };
    }

    async function destroyParticipante(item: Participante) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<Participante> = await axios.delete(
            `${apiResource}/${item.i_codigo}`
        );
        return { Participante: data, message, status };
    }

    return {
        destroyParticipante,
        updateParticipante
    };
});

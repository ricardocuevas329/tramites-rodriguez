
import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type { ResponseList } from "@/models/extends";
import type {TipoDocumento} from "@/models/types";

const idStore = "TipoDocumentoExternalStore";
const apiResource = "/api/external/tipo-documento";
export const useTipoDocumentoExternalStore = defineStore(idStore, () => {
    const TipoDocumentos = ref<TipoDocumento[]>([]);
    async function listarTipoDocumentosActivos() {
        try {

            const {
                data: { data },
            }: ResponseList<TipoDocumento> = await axios.get(
                `${apiResource}-activos`
            );
            if (data.length) {
                TipoDocumentos.value = data;
            }
        } catch (error) {
        } finally {

        }
    }

    return {
        TipoDocumentos,
        listarTipoDocumentosActivos
    };
});

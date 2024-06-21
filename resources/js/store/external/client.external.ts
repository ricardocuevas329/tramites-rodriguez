import axios from "axios";
import { defineStore } from "pinia";
import { ref } from "vue";
import type {Kardex as IKardex, ClientExternal, RegistroPublico} from "@/models/types";
import type { ResponseByEntity } from "@/models/extends";
import type { Pagination } from "@/models/Pagination";
import type { ResponseList } from "@/models/extends";

const idStore = "useClientExternalStore";
const apiResource = "/api/external/client";
const apiResourceTwo = "/api/external/kardex-consulta";

export const useClientExternalStore = defineStore(idStore, () => {

    const recordsClients = ref<ClientExternal[]>([]);
    const isLoading = ref<boolean>(false);
    const pagination = ref<Pagination>();
    const search = ref<string>('');
    const recordsKardex = ref<IKardex[]>([]);
    const details = ref<ClientExternal>();
    const isLoadingDetail = ref<boolean>(false);

    async function listProcedureDetail(id: string) {
        try {
            isLoadingDetail.value = true
            const {
                data: { data },
            }: ResponseByEntity<any> = await axios.get(
                `${apiResource}/get/byId/${id}`
            );
            details.value = data;

        } catch (error) {
            isLoadingDetail.value = false
        } finally {
            isLoadingDetail.value = false
        }
    }



    async function listProcedure() {
        try {
            isLoading.value = true;
            let current_page = pagination.value?.current_page;
            let page = current_page ? current_page : 1;
            let searchFilter = search.value ?? '';
            const {
                data: { data, meta },
            }: ResponseList<any> = await axios.get(
                `${apiResource}?page=${page.toString()}&search=${searchFilter}`
            );

            // Recorrer cada objeto en la lista
            for (const obj of data) {
                // Verificar si la clave "detalle_kardex" está presente en el objeto
                if (obj.hasOwnProperty("detalle_kardex")) {
                    // Obtener el valor de "s_kardexconex" si está presente en "detalle_kardex"
                    const s_kardexconex_valor = obj.detalle_kardex ? obj.detalle_kardex.s_kardexconex : null;

                    // Llamar a la función solo si s_kardexconex_valor no es nulo
                    if (s_kardexconex_valor !== null && s_kardexconex_valor !== '') {
                        await searchCodigokardexConex(s_kardexconex_valor);

                        // Convertir el primer elemento del array a un objeto plano
                        const detalleKardexConexPlain = recordsKardex.value.length > 0
                            ? JSON.parse(JSON.stringify(recordsKardex.value[0]))
                            : null;

                        // Asignar el nuevo objeto a "detalle_kardex_conex"
                        obj.detalle_kardex_conex = detalleKardexConexPlain;


                    } else {

                    }
                } else {

                }
            }
            recordsClients.value = data;
            pagination.value = meta;
        } catch (error) {
            // Handle errors appropriately
        } finally {
            isLoading.value = false;
        }
    }
    async function searchCodigokardexConex(payload: string
    ) {
        isLoading.value = true
        try {
            const {
                data: { data, meta },
            }: ResponseList<IKardex> = await axios.post(
                `${apiResourceTwo}/get/searchCodigo`,
                { codigo: payload }
            );
            console.log('url', `${apiResourceTwo}/get/searchCodigo`);
            recordsKardex.value = data;
        } catch (error) {
        } finally {
            isLoading.value = false
        }
    }
    async function saveClient(item) {
        const {
            data: { data, message, status },
        }: ResponseByEntity<any> = await axios.post(`${apiResource}`, item);
        return { Client: data, message, status };
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

    return {
        pagination,
        search,
        recordsClients,
        isLoading,
        saveClient,
        listProcedure,
        cleanPagination,
        details,
        listProcedureDetail,
        isLoadingDetail
    };
});

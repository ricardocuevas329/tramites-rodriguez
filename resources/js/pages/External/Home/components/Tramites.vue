<template>
    <div>
        <div class="md:mx-5">
            <div class="flex justify-between pt-4 pb-4 mt-4 mx-2">
                <div>
                    <a role="button" class="btn btn-sm">Mis Trámites</a>
                </div>
                <div>
                    <button class="bg-custom-color text-white p-2 rounded">Mi Botón</button>
                    <router-link to="tramite" class="btn btn-outline btn-sm custom-hover">NUEVO TRÁMITE</router-link>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4  gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                    <TextInputSearch @input="filter()" @keyup="filter()" v-model="search" placeholder="Buscar..." />
                </div>
                <div class="col-span-1">
                    <Options text="Opciones">
                        <ul tabindex="0"
                            class="static  dropdown-content z-60 menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li>
                                <a @click="filter()">
                                    <RefreshIcon />
                                    Refrescar
                                </a>
                            </li>
                        </ul>
                    </Options>
                </div>
            </div>
            <Table v-if="!isLoading">
                <THead>
                    <tr class="bg-blue">
                        <!--<th>Accion</th>-->
                        <th>CODIGO</th>
                        <th>F. INGRESO</th>
                        <th>SOLICITANTE</th>
                        <th>N° DOCUMENTO</th>
                        <th>ACTO NOTARIAL</th>
                        <th>KARDEX</th>
                        <th>F. APERTURA</th>
                        <th>KARDEX CONEXO</th>
                        <!--<th>COT. NOTARIAL</th>
                    <th>COT. REGISTRAL</th>-->
                        <th>F. ESCRITURACION</th>
                        <th>F. ULTIMA FIRMA</th>
                        <!--<th>OBSERVACION</th>-->
                        <th>ESTATUS</th>
                    </tr>
                </THead>
                <tbody>
                    <tr class="cursor-pointer hover:bg-gray-200" v-for="(item, key) in recordsClients" :key="key"
                        @click="rowClickHandler(item)">

                        <td class="text-center">{{ item.id }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.nombre_compuesto }}</td>
                        <td>{{ item.documento }}</td>
                        <td> {{ item?.detalle_kardex?.s_obstitulo }}</td>
                        <td> {{ item?.detalle_kardex?.s_tipokardex }} - {{ item?.detalle_kardex?.num_kardex }}</td>
                        <td>{{ item?.detalle_kardex?.d_feching }}</td>
                        <td v-if="item?.detalle_kardex_conex">{{ item.detalle_kardex_conex.s_tipokardex + ' - ' +
                        item.detalle_kardex_conex.s_kardex }}</td>
                        <td v-else></td>
                        <td>{{ item?.detalle_kardex?.d_fechescritura }}</td>
                        <td> {{ item?.is_date_mayor }}</td>
                        <td> <span v-if="item?.detalle_kardex?.i_estadonota"
                                class="btn btn-outline btn-xs btn-success">{{
                        getStatus(item?.detalle_kardex?.i_estadonota) }}</span> </td>
                    </tr>
                </tbody>
            </Table>
            <div class="mx-4">
                <Paginate v-if="recordsClients?.length && !isLoading" :pagination="pagination"
                    @paginate="listProcedure()" />
            </div>
            <Skeleton v-if="isLoading" :tipo="2" />

            <Galery ref="galeryComponentRef" :showItemNavigators="false" />
        </div>
        <router-view></router-view>
    </div>
</template>
<style></style>
<script lang="ts" setup>
import { onMounted, ref, toRefs } from "vue";
import {
    Table,
    THead,
    Paginate,
    Skeleton,
    Galery,
    TextInputSearch,
    Options
} from "@/components";
import { useClientExternalStore } from "@/store/external/client.external";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "@/utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import { useRouter } from "vue-router";
import { useKardexExternalStore } from "@/store/external/kardex.external";

const { isLoading, pagination, recordsClients, recordsRegisterPublics, search } = toRefs(useClientExternalStore())
const { listProcedure, cleanPagination } = useClientExternalStore()
const { listKardexActives } = useKardexExternalStore()

const galeryComponentRef = ref<any>(null);
const emit = defineEmits(['onSelectedRow'])
const router = useRouter()

const rowClickHandler = (item) => {
    if (item.detalle_kardex == null) {
        notify({
            title: 'Aún no se ha asignado un kárdex.',
            type: "warn",
        });
    } else {
            goDetail(item.id, item.detalle_kardex.num_kardex)
    }
};



const goDetail = async (id: string, num_kardex: string) => {
    await router.push({
        name: 'Detalle',
        params: {
            id: id,
            kardex: num_kardex
        }
    })

}

const getStatus = (status: string) => {
    switch (status) {
        case '4':
            return "Concluido"
        case '5':
            return "Calificado"
        case '6':
            return "Ingresado"
        case '1':
            return "Ingresado"

    }
}

const filter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination()
    await listProcedure();
}
onMounted(() => {
    listKardexActives()
    listProcedure()
})
</script>

<style scoped>
.bg-blue {
    background-color: #006aa6;
    color: white;
}

.custom-hover:hover {
    background-color: #006aa6 !important;
    color: white !important;
}

.custom-hover {
    border-color: #66a3d2;
    color: #66a3d2;
}

/**Scroll */
/* Agrega estas reglas de estilo */
/* Ajusta el grosor del scrollbar horizontal */
.scrollbar[data-v-6c2c71f9]::-webkit-scrollbar {
    width: 10px;
    /* Ajusta el valor según tus preferencias */
    height: 6px;
}
</style>

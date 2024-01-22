<template>
    <Container>
        <Card>
            <Title>Comparecientes Bloqueados</Title>
            <div
                class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4"
            >
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                    <TextInputSearch
                        @input="filterComparecienteBloqueado()"
                        @keyup="filterComparecienteBloqueado()"
                        v-model="search"
                        placeholder="Buscar..."
                    />
                </div>
                <div class="text-right">
                    <BtnAdd
                        text="Nuevo"
                        :path="configEntidad._COMPARECIENTE_BLOQUEADO_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                    <tr>
                        <th scope="col" class="px-6">Acciones.</th>
                        <th scope="col" class="">Referencia</th>
                        <th scope="col" class="">Numero</th>
                        <th scope="col" class="">Fecha Registro</th>
                        <th scope="col" class="">Condicion</th>
                        <th scope="col" class="">Ruta</th>
                        <th scope="col" class="">Personal</th>
                    </tr>
                    </THead>
                    <tbody>
                    <tr
                        @click="goDetail(item)"
                        v-for="(item, index) in ComparecienteBloqueados"
                        :key="index"
                        class="cursor-pointer  hover:bg-base-300"
                    >
                        <td class="flex actions">
                            <button
                                type="button"
                                class="btn btn-xs btn-circle btn-ghost"
                            >
                                <ToolTip position="right" text="Editar">
                                    <EditIcon/>
                                </ToolTip>
                            </button>

                            <button
                                @click.stop
                                type="button"
                                class="btn btn-xs btn-circle btn-ghost text-error"
                            >
                                <ToolTip position="right" text="Eliminar">
                                    <DeleteIcon/>
                                </ToolTip>
                            </button>
                        </td>
                        <td class="">
                            {{ item.referencia?.s_desc }}
                        </td>
                        <td class="">
                            {{ item.s_numero }}
                        </td>
                        <td class="">
                            {{ item?.created_at }}
                        </td>
                        <td class="">
                            {{ item.condicion?.s_desc }}
                        </td>
                        <td class="actions" @click.stop>
                            <a :href="item.s_ruta?.toString()" class="btn btn-circle btn-ghost btn-xs" target="_blank">
                                <ToolTip position="right" text="Visualizar Documento">
                                    <EyeIcon class="text-primary"/>
                                </ToolTip>
                            </a>
                        </td>
                        <td class="">
                            {{ item.personal?.nombre_compuesto }}
                        </td>

                    </tr>
                    </tbody>
                </Table>
                <ListEmpty v-if="ComparecienteBloqueados?.length == 0"/>
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2"/>
            <Paginate
                v-if="ComparecienteBloqueados?.length && !isLoading"
                :pagination="pagination"
                @paginate="listarComparecienteBloqueado()"
            />
        </Card>
        <RouterView/>
    </Container>
</template>
<script setup lang="ts">
import {useRouter} from "vue-router";
import {onMounted, ref, toRefs} from "vue";
import {
    BtnAdd,
    Card,
    Container,
    ContainerTable,
    ListEmpty,
    Paginate,
    Skeleton,
    Table,
    TextInputSearch,
    THead,
    Title,
    ToolTip
} from "../../../components";
import {debounce} from "../../../utils/debounce.js";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EyeIcon from "vue-material-design-icons/EyeCheck.vue";
import {configEntidad} from "../../../router/Entidad/EntidadConfig";
import {useComparecienteBloqueadoStore} from "../../../store/compareciente-bloqueado";
import type {ComparecienteBloqueado} from "../../../models/types";
import {useTipoDocumentoStore} from "@/store/tipo-documento";
import {useEstadoStore} from '../../../store/estado';

const {listarComparecienteBloqueado} = useComparecienteBloqueadoStore();
const {ComparecienteBloqueados, isLoading, pagination} = toRefs(
    useComparecienteBloqueadoStore()
);
const {listarActivos} = useTipoDocumentoStore();
const {listarCondicion, listarReferencia} = useEstadoStore();

const router = useRouter();
const search = ref<string>("");

const goDetail = (item: ComparecienteBloqueado) => {
    if (item.s_codigo) {
        router.push({
            name: configEntidad._COMPARECIENTE_BLOQUEADO_.update.name,
            params: {
                id: item.s_codigo,
            },
        });
    }
};

const filterComparecienteBloqueado = debounce(() => {
    return listarComparecienteBloqueado(search.value);
}, 500);

onMounted(() => {
    listarComparecienteBloqueado();
    listarActivos();
    listarCondicion();
    listarReferencia();
});
</script>

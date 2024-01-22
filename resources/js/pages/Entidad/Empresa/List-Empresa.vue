<template>
    <Container>
        <Card>
            <SelectedCheckCounter v-if="selecteds?.length"
                >{{ selecteds?.length }}
            </SelectedCheckCounter>
            <Title>Empresas</Title>
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 my-4"
            >
                <div
                    class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
                >
                    <TextInputSearch
                        @input="onFilter()"
                        @keyup="onFilter()"
                        v-model="search"
                        placeholder="Buscar..."
                    />
                </div>
                <div class="col-span-1">
                    <Options text="Opciones">
                        <MenuItem v-slot="{ active }" @click="listarEmpresa()">
                            <Item :active="active">
                                <RefreshIcon
                                    :active="active"
                                     class="mx-1"
                                />
                                Refrescar
                            </Item>
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                            <Item :active="active">
                                <ExportIcon
                                    :active="active"
                                     class="mx-1"
                                />
                                Exportar
                            </Item>
                        </MenuItem>
                    </Options>
                </div>
                <div class="text-right">
                    <BtnAdd
                        text="Nuevo"
                        :path="configEntidad._EMPRESA_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>

                            <th scope="col" class="">Nombre</th>
                            <th scope="col" class="">Correo</th>
                            <th scope="col" class="">Localidad</th>
                            <th scope="col" class="">Direccion</th>
                            <th scope="col" class="">Nacionalidad</th>
                            <th scope="col" class="">
                                Tipo Documento
                            </th>
                            <th scope="col" class="">Documento</th>
                            <th scope="col" class="px-6">Acciones</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in Empresas"
                            :key="index"
                            @click="goDetail(item)"
                            class="cursor-pointer  hover:bg-base-300"
                        >

                            <td class="">
                                {{ item?.s_nombre }}
                            </td>
                            <td class="">
                                {{ item.s_email }}
                            </td>
                            <td class="">
                                {{ item.s_localidad }}
                            </td>
                            <td class=" text-ellipsis overflow-hidden">
                                {{ item.s_direccion }}
                            </td>
                            <td class="">
                                {{ item?.nacionalidad?.s_gentilicio }}
                            </td>
                            <td class="">
                                {{ item?.tipo_documento?.s_abrev }}
                            </td>
                            <td class="">
                                {{ item.s_num_doc }}
                            </td>
                            <td class="flex actions">
                                <button
                                    type="button"
                                    @click.stop
                                    class="btn btn-sm btn-circle bg-base-200"
                                >
                                    <ToolTip text="Cambiar Clave">
                                        <KeyIcon />
                                    </ToolTip>
                                </button>

                                <button
                                    type="button"
                                    class="btn btn-sm btn-circle bg-base-200"
                                >
                                    <ToolTip text="Editar">
                                        <EditIcon />
                                    </ToolTip>
                                </button>

                                <button
                                    @click.stop
                                    @click="changeStatus(item)"
                                    type="button"
                                    class="btn btn-sm btn-circle bg-error text-white"
                                >
                                    <ToolTip
                                        v-if="item.i_estado"
                                        text="Desactivar"
                                    >
                                        <DeleteIcon />
                                    </ToolTip>
                                    <ToolTip v-else text="Activar">
                                        <CloseIcon />
                                    </ToolTip>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </Table>
                <ListEmpty v-if="Empresas?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Empresas?.length && !isLoading"
                :pagination="pagination"
                @paginate="listarEmpresa()"
            />
        </Card>
        <RouterView />
    </Container>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import { ref, onMounted, toRefs } from "vue";
import {
    Card,
    Container,
    Paginate,
    BtnAdd,
    Skeleton,
    ListEmpty,
    ContainerTable,
    SelectedCheckCounter,
    TextInputSearch,
    THead,
    Table,
    Title,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import KeyIcon from "vue-material-design-icons/Key.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";
import { MenuItem } from "@headlessui/vue";
import { useEmpresaStore } from "../../../store/empresa";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import { Options, Item, ToolTip } from "../../../components";
import type { Empresa } from "@/models/types";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import ExportIcon from "vue-material-design-icons/Export.vue";
import { useTipoDocumentoStore } from "../../../store/tipo-documento";

const { listarEmpresa, disabledEmpresa, enabledEmpresa, cleanPagination } =
    useEmpresaStore();
const { Empresas, pagination, isLoading, search } = toRefs(useEmpresaStore());
const { getDocumentCompany } = useTipoDocumentoStore();

const router = useRouter();
const selecteds = ref<Empresa[]>();
const isMarkAll = ref<boolean>(false);

const goDetail = (item: Empresa) => {
    router.push({
        name: configEntidad._EMPRESA_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
};

const changeStatus = (item: Empresa) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado ? disabledEmpresa(item) : enabledEmpresa(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarEmpresa();
        }
    });
};

const onFilter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination();
    await listarEmpresa();
};

const onSelectedAll = (state: boolean) => {
    if (state) {
        return (selecteds.value = Empresas.value);
    }
    return (selecteds.value = []);
};

onMounted(() => {
    listarEmpresa();
    getDocumentCompany();
});
</script>

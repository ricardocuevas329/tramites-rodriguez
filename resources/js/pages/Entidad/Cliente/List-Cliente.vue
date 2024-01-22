<template>
    <Container>
        <Card>
            <SelectedCheckCounter v-if="selecteds?.length"
                >{{ selecteds?.length }}
            </SelectedCheckCounter>
            <Title>Clientes</Title>
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
                        <MenuItem v-slot="{ active }">
                            <Item :active="active">
                                <EditIcon
                                    :active="active"
                                    class="mx-1"
                                    aria-hidden="true"
                                />
                                Exportar
                            </Item>
                        </MenuItem>
                        <MenuItem v-slot="{ active }">
                            <Item :active="active">
                                <DeleteIcon
                                    :active="active"
                                    class="mx-1"
                                    aria-hidden="true"
                                />
                                Archivar
                            </Item>
                        </MenuItem>
                    </Options>
                </div>
                <div class="text-right">
                    <BtnAdd
                        text="Nuevo"
                        :path="configEntidad._CLIENTE_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="">Nombres</th>
                            <th scope="col" class="">Estado Civil</th>
                            <th scope="col" class="">Direccion</th>
                            <th scope="col" class="">Nacionalidad</th>
                            <th scope="col" class="">Localidad</th>
                            <th scope="col" class="">
                                Tipo Documento
                            </th>
                            <th scope="col" class="">
                                Numero Documento
                            </th>
                            <th scope="col" class="px-6">Acciones</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in Clientes"
                            :key="index"
                            @click="goDetail(item)"
                            class="cursor-pointer  hover:bg-base-300"
                        >

                            <td class="">
                                {{ item?.nombre_compuesto }}
                            </td>
                            <td class="">
                                {{ item.s_estado_civil }}
                            </td>
                            <td class="">
                                {{ item.s_direccion }}
                            </td>
                            <td
                                class=" text-ellipsis overflow-hidden"
                            >
                                {{ item.nacionalidad?.s_gentilicio }}
                            </td>
                            <td
                                class=" text-ellipsis overflow-hidden"
                            >
                                {{ item.ubigeo?.distrito }}-{{
                                    item.ubigeo?.provincia
                                }}-{{ item.ubigeo?.departamento }}
                            </td>
                            <td class="">
                                {{ item.tipo_documento?.s_abrev }}
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
                                    <KeyIcon />
                                </button>

                                <button
                                    @click="goDetail(item)"
                                    type="button"
                                    class="btn btn-sm btn-circle bg-base-200"
                                >
                                    <EditIcon />
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
                <ListEmpty v-if="Clientes?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Clientes?.length && !isLoading"
                :pagination="pagination"
                @paginate="listarCliente()"
            />
        </Card>
        <RouterView />
    </Container>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import { ref, toRefs, onMounted } from "vue";
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
    Options,
    THead,
    Table,
    Title,
    Item,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import KeyIcon from "vue-material-design-icons/Key.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";
import { MenuItem } from "@headlessui/vue";
import { useClienteStore } from "../../../store/cliente";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { Cliente } from "@/models/types";
import { ToolTip } from '../../../components';
import { useTipoDocumentoStore } from '../../../store/tipo-documento';

const { getDocumentClient } = useTipoDocumentoStore();
const { Clientes, pagination, isLoading, search } = toRefs(useClienteStore());
const { listarCliente, disabledCliente, enabledCliente, cleanPagination } =
    useClienteStore();

const router = useRouter();
const selecteds = ref<Cliente[]>();
const isMarkAll = ref<boolean>(false);

const goDetail = (item: Cliente) => {
    router.push({
        name: configEntidad._CLIENTE_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
};

const changeStatus = (item: Cliente) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado ? disabledCliente(item) : enabledCliente(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarCliente();
        }
    });
};

const onFilter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination();
    await listarCliente();
};

const onSelectedAll = (state: boolean) => {
    if (state) {
        return (selecteds.value = Clientes.value);
    }
    return (selecteds.value = []);
};

onMounted(() => {
    listarCliente();
    getDocumentClient()
});
</script>

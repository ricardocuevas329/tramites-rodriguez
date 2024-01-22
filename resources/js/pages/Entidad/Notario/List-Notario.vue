<template>
    <Container>
        <Card>
            <Title
                >Notario
                <span v-if="pagination?.total">({{ pagination?.total }})</span>
            </Title>
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
                        <MenuItem v-slot="{ active }" @click="listarNotario()">
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
                <div class="md:text-end lg:text-right">
                    <BtnAdd
                        text="Nuevo"
                        :path="configEntidad._NOTARIO_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="">DOCUMENTO</th>
                            <th scope="col" class="">NUMERO.</th>
                            <th scope="col" class="">PATERNO</th>
                            <th scope="col" class="">MATERNO</th>
                            <th scope="col" class="">NOMBRES</th>
                            <th scope="col" class="">CARGO</th>
                            <th scope="col" class="">SEXO</th>
                            <th scope="col" class="">TELEFONO</th>
                            <th scope="col" class="">OBSERVACION</th>
                            <th scope="col" class="px-6">Acciones.</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in Notarios"
                            :key="index"
                            @click="goDetail(item)"
                            class="cursor-pointer  hover:bg-base-300"
                        >
                            <td class="">
                                {{ item?.tipo_documento?.s_abrev }}
                            </td>
                            <td class="">
                                {{ item.s_numdoc }}
                            </td>
                            <td class="">
                                {{ item.s_paterno }}
                            </td>
                            <td class="">
                                {{ item.s_materno }}
                            </td>
                            <td class="">
                                {{ item.s_nombres }}
                            </td>
                            <td class="">
                                {{ item.s_cargo }}
                            </td>
                            <td class="">
                                {{ item.s_sexo }}
                            </td>
                            <td class="">
                                {{ item.s_telefonos }}
                            </td>
                            <td class="">
                                {{ item.s_observacion }}
                            </td>

                            <td class="actions flex">
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
                <ListEmpty v-if="Notarios?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Notarios?.length && !isLoading"
                :pagination="pagination"
                @paginate="listarNotario()"
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
    Title,
    THead,
    Table,
    TextInputSearch,
} from "../../../components";
import { debounce } from "../../../utils/debounce";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import ExportIcon from "vue-material-design-icons/Export.vue";
import type { Notario } from "../../../models/types";
import { useNotarioStore } from "../../../store/notario";
import { ToolTip, Item, Options } from "../../../components";
import CloseIcon from "vue-material-design-icons/Close.vue";
import { notify } from "@kyvg/vue3-notification";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import { useTipoDocumentoStore } from "../../../store/tipo-documento";
import { MenuItem } from "@headlessui/vue";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";

const { listarNotario, enabledNotario, disabledNotario, cleanPagination } =
    useNotarioStore();
const { Notarios, isLoading, pagination, search } = toRefs(useNotarioStore());
const { listarActivos } = useTipoDocumentoStore();

const router = useRouter();

const goDetail = (item: Notario) => {
    if (item.s_codigo) {
        router.push({
            name: configEntidad._NOTARIO_.update.name,
            params: {
                id: item.s_codigo,
            },
        });
    }
};

const changeStatus = (item: Notario) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado ? disabledNotario(item) : enabledNotario(item);

    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarNotario();
        }
    });
};

const onFilter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination();
    await listarNotario();
};
onMounted(() => {
    listarNotario();
    listarActivos();
});
</script>

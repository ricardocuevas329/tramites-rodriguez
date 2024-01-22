<template>
    <Container>
        <Card>
            <Title> Abogado </Title>
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
                        <MenuItem v-slot="{ active }" @click="listarAbogado()">
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
                        :path="configEntidad._ABOGADO_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="">Nombres</th>
                            <th scope="col" class="">Paterno</th>
                            <th scope="col" class="">Materno</th>
                            <th scope="col" class="">Sexo</th>
                            <th scope="col" class="">Telefono</th>
                            <th scope="col" class="">CAL</th>
                            <th scope="col" class="">Colegio</th>
                            <th scope="col" class="">Personal</th>
                            <th scope="col" class="px-6">ACCIONES</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in Abogados"
                            :key="index"
                            class="cursor-pointer  hover:bg-base-300"
                            @click="goDetail(item)"
                        >

                            <td class="">
                                {{ item?.s_nombres }}
                            </td>
                            <td class="">
                                {{ item.s_paterno }}
                            </td>
                            <td class="">
                                {{ item.s_materno }}
                            </td>
                            <td class="">
                                {{ item.s_sexo }}
                            </td>
                            <td class="">
                                {{ item.s_telefono }}
                            </td>
                            <td class="">
                                {{ item.s_cal }}
                            </td>
                            <td class="">
                                {{ item.s_colegio }}
                            </td>
                            <td class="">
                                {{ item.personal?.s_nombres }}
                            </td>
                            <td class="flex actions">
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
                <ListEmpty v-if="Abogados?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Abogados?.length && !isLoading"
                :pagination="pagination"
                @paginate="listarAbogado()"
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
    Table,
    THead,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import { useAbogadoStore } from "../../../store/abogado";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { Abogado } from "../../../models/types";
import {
    TextInputSearch,
    Item,
    Options,
    ToolTip,
} from "../../../components";
import { MenuItem } from "@headlessui/vue";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import ExportIcon from "vue-material-design-icons/Export.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";

const { Abogados, isLoading, pagination, search } = toRefs(useAbogadoStore());
const { listarAbogado, disabledAbogado, enabledAbogado, cleanPagination } =
    useAbogadoStore();

const router = useRouter();

const goDetail = (item: Abogado) => {
    router.push({
        name: configEntidad._ABOGADO_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
};

const changeStatus = (item: Abogado) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado ? disabledAbogado(item) : enabledAbogado(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarAbogado();
        }
    });
};

const onFilter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination();
    await listarAbogado();
};

onMounted(() => {
    listarAbogado();
});
</script>

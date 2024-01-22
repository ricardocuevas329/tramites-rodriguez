<template>
    <Container>
        <Card>
            <Title>Zona Registral</Title>
            <div
                class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4"
            >
                <div
                    class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
                >
                    <TextInputSearch
                        @input="filterZonaRegistral()"
                        @keyup="filterZonaRegistral()"
                        v-model="search"
                        placeholder="Buscar..."
                    />
                </div>
                <div class="text-right">
                    <BtnAdd
                        text="Nuevo"
                        :path="configMantenimiento._ZONA_REGISTRAL_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Codigo SBS</th>
                            <th scope="col" class="py-3">Acciones.</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in ZonaRegistrales"
                            :key="index"
                            @click="goDetail(item)"
                            class="cursor-pointer  hover:bg-base-300"
                        >
                            <td class="px-6">
                                {{ item?.s_codigo }}
                            </td>
                            <td class="px-6">
                                {{ item.s_nombre }}
                            </td>
                            <td class="px-6">
                                {{ item.s_codigo_sbs }}
                            </td>

                            <td class="flex actions">
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
                                    type="button"
                                    @click="changeStatus(item)"
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
                <ListEmpty v-if="ZonaRegistrales?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="ZonaRegistrales?.length && !isLoading"
                :pagination="pagination"
                @paginate="listarZonaRegistral()"
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
    ToolTip,
} from "../../../components";
import { debounce } from "../../../utils/debounce";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import type { ZonaRegistral } from "../../../models/types";
import { useZonaRegistralStore } from "../../../store/zona-registral";
import CloseIcon from "vue-material-design-icons/Close.vue";
import { notify } from "@kyvg/vue3-notification";

const { listarZonaRegistral, disabledZonaRegistral, enabledZonaRegistral } =
    useZonaRegistralStore();
const { ZonaRegistrales, isLoading, pagination } = toRefs(
    useZonaRegistralStore()
);

const router = useRouter();
const search = ref<string>("");

const goDetail = (item: ZonaRegistral) => {
    if (item.s_codigo) {
        router.push({
            name: configMantenimiento._ZONA_REGISTRAL_.update.name,
            params: {
                id: item.s_codigo,
            },
        });
    }
};

const changeStatus = (item: ZonaRegistral) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado
        ? disabledZonaRegistral(item)
        : enabledZonaRegistral(item);

    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarZonaRegistral();
        }
    });
};

const filterZonaRegistral = debounce(() => {
    return listarZonaRegistral(search.value);
}, 500);

onMounted(() => {
    listarZonaRegistral();
});
</script>

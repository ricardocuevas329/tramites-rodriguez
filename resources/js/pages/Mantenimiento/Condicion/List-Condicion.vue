<template>
    <Container>
        <Card>
            <Title>Condicion</Title>
            <div
                class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4"
            >
                <div
                    class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
                >
                    <TextInputSearch
                        @input="filterCondicion()"
                        @keyup="filterCondicion()"
                        v-model="search"
                        placeholder="Buscar..."
                    />
                </div>
                <div class="text-right">
                    <BtnAdd
                        text="Nueva Condicion"
                        :path="configMantenimiento._CONDICION_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="">Codigo</th>
                            <th scope="col" class="">Nombre</th>
                            <th scope="col" class="">CNL</th>
                            <th scope="col" class="px-6">Accion</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in Condiciones"
                            :key="index"
                            class="cursor-pointer  hover:bg-base-300"
                            @click="goDetail(item)"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-primary whitespace-nowrap dark:text-white"
                            >
                                {{ item.id }}
                            </th>
                            <td class="">
                                {{ item.nombre }}
                            </td>
                            <td class="">
                                {{ item.id_cnl }}
                            </td>

                            <td class="actions flex items-center space-x-2">
                                <button class="btn btn-sm btn-circle bg-base-200">
                                    <ToolTip text="Editar">
                                        <EditIcon />
                                    </ToolTip>
                                </button>

                                <a @click.stop
                                    @click="changeStatus(item)"
                                    class="cursor-pointer font-medium text-red-600 dark:text-red-500 hover:underline"
                                    >{{
                                        item.estado ? "Desactivar" : "Activar"
                                    }}</a
                                >
                            </td>
                        </tr>
                    </tbody>
                </Table>
                <ListEmpty v-if="Condiciones.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Condiciones.length && !isLoading"
                :pagination="pagination"
                @paginate="listarCondicion()"
            />
        </Card>
        <RouterView />
    </Container>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import { useCondicionStore } from "../../../store/condicion";
import {ref, onMounted, toRefs, defineAsyncComponent} from "vue";
import {
    Card,
    Container,
    Paginate,
    BtnAdd,
    Skeleton,
    ListEmpty,
    ContainerTable,
    Table,
    THead,
    TextInputSearch,
    Title, ToolTip,
} from "../../../components";
import { debounce } from "../../../utils/debounce.js";
import type { Condicion } from "@/models/types";
import { notify } from "@kyvg/vue3-notification";
import {configMantenimiento} from "@/router/Mantenimiento/MantenimientoConfig";

const EditIcon = defineAsyncComponent(() =>
    import("vue-material-design-icons/Pencil.vue")
);

const { listarCondicion, disabledCondicion, enabledCondicion } =
    useCondicionStore();
const { Condiciones, isLoading, pagination } = toRefs(useCondicionStore());

const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Condicion) => {
    router.push({
        name: configMantenimiento._CONDICION_.update.name,
        params: { id: item.id },
    });
};

const changeStatus = (item: Condicion) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }
    const rpta = item.estado ? disabledCondicion(item) : enabledCondicion(item);
    rpta.then((res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            listarCondicion();
        }
    });
};

const filterCondicion = debounce(() => {
    return listarCondicion(search.value);
}, 500);

onMounted(() => {
    listarCondicion();
});
</script>

<template>
    <Container>
        <Card>
            <Title>Cargo Publico</Title>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                    <TextInputSearch @input="filterCargoPublicos()" @keyup="filterCargoPublicos()" v-model="search"
                        placeholder="Buscar..." />
                </div>
                <div class="text-right">
                    <BtnAdd text="Nuevo" :path="configMantenimiento._CARGO_PUBLICO_.add.path" />
                </div>
            </div>
            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>

                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Descripcion</th>
                            <th scope="col" class="px-6 py-3">ACCIONES</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in CargoPublicos" :key="index"
                        class="cursor-pointer  hover:bg-base-300"  @click="goDetail(item)" >


                            <td class="px-6 py-4">
                                {{ item?.codigo }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.descripcion }}
                            </td>

                            <td class="flex actions">
                                <button   type="button"
                                    class="btn btn-sm btn-circle bg-base-200">
                                  <ToolTip text="Editar">
                                    <EditIcon />
                                  </ToolTip>
                                </button>

                                <button
                                    @click="changeStatus(item)"
                                    @click.stop
                                    type="button"
                                    class="btn btn-sm btn-circle bg-error text-white"
                                >
                                  <ToolTip v-if="item.i_estado" text="Desactivar">
                                    <DeleteIcon v-if="item.i_estado"/>
                                  </ToolTip>
                                  <ToolTip v-else text="Activar">
                                    <CloseIcon/>
                                  </ToolTip>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </Table>
                <ListEmpty v-if="CargoPublicos?.length == 0" />
            </ContainerTable>

            <Paginate v-if="CargoPublicos?.length && !isLoading" :pagination="pagination"
                @paginate="listarCargoPublico()" />
        </Card>
        <RouterView />
    </Container>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import { ref, onMounted, toRefs, defineAsyncComponent } from 'vue';
import {
  Card,
  Container,
  Paginate,
  BtnAdd,
  ListEmpty,
  ContainerTable,
  Table,
  THead,
  TextInputSearch,
  Title, ToolTip,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce.js";

const EditIcon = defineAsyncComponent(() =>
    import("vue-material-design-icons/Pencil.vue")
);
const DeleteIcon = defineAsyncComponent(() =>
    import("vue-material-design-icons/Delete.vue")
);
const CloseIcon = defineAsyncComponent(() =>
    import("vue-material-design-icons/Close.vue")
);
import {  useCargoPublicoStore } from "../../../store/cargo-publico";
import { configMantenimiento } from '@/router/Mantenimiento/MantenimientoConfig';
import type { CargoPublico } from "@/models/types";

const { CargoPublicos, pagination, isLoading } = toRefs(useCargoPublicoStore())
const { listarCargoPublico, disabledCargoPublico, enabledCargoPublico } = useCargoPublicoStore();


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: CargoPublico) => {
    router.push({
        name: configMantenimiento._CARGO_PUBLICO_.update.name,
        params: {
            id: item.codigo,
        },
    });
};

const changeStatus = (item: CargoPublico) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado
        ? disabledCargoPublico(item)
        : enabledCargoPublico(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarCargoPublico();
        }
    });
};

const filterCargoPublicos = debounce(() => {
    return listarCargoPublico(search.value);
}, 500);


onMounted(() => {
    listarCargoPublico();
})
</script>

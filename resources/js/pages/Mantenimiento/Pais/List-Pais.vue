<template>
    <Container>
        <Card>
            <Title>Paises</Title>

            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                    <TextInputSearch @input="filterCargos()" @keyup="filterCargos()" v-model="search"
                        placeholder="Buscar..." />
                </div>
                <div class="text-right">
                    <BtnAdd text="Nuevo" :path="configMantenimiento._PAIS_.add.path" />
                </div>
            </div>
            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>

                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Pais</th>
                            <th scope="col" class="px-6 py-3">Gentilicio F</th>
                            <th scope="col" class="px-6 py-3">Gentilicio M</th>
                            <th scope="col" class="px-6 py-3">ACCIONES</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in Paises" :key="index"
                        class="cursor-pointer  hover:bg-base-300"   @click="goDetail(item)">

                            <td class="px-6 py-4">
                                {{ item?.s_codigo }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item?.s_pais }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.s_gentilicio_f }}
                            </td>   <td class="px-6 py-4">
                                {{ item.s_gentilicio_m }}
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
                <ListEmpty v-if="Paises?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="Paises?.length && !isLoading" :pagination="pagination"
                @paginate="listarPais()" />
        </Card>
        <RouterView />
    </Container>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import { ref, onMounted, toRefs } from 'vue';
import {
  Card,
  Container,
  Paginate,
  BtnAdd,
  SearchIcon,
  Skeleton,
  ListEmpty,
  ContainerTable,
  Table,
  THead,
  TextInputSearch,
  Title, ToolTip,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import { configMantenimiento } from '@/router/Mantenimiento/MantenimientoConfig';
import type { Pais } from "@/models/types";
import { usePaisStore } from '../../../store/pais';
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";

const { Paises, pagination, isLoading } = toRefs(usePaisStore())
const { listarPais, disabledPais, enabledPais } = usePaisStore();


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Pais) => {
    router.push({
        name: configMantenimiento._PAIS_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
};

const changeStatus = (item: Pais) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado
        ? disabledPais(item)
        : enabledPais(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarPais();
        }
    });
};

const filterCargos = debounce(() => {
    return listarPais(search.value);
}, 500);


onMounted(() => {
    listarPais();
})
</script>

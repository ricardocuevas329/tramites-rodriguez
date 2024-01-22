<template>
    <Container>
        <Card>
            <Title>Nacionalidades</Title>

                <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                    <TextInputSearch @input="onGetFilters()" @keyup="onGetFilters()" v-model="search"
                        placeholder="Buscar..." />
                </div>
                <div class="text-right">
                    <BtnAdd text="Nuevo" :path="configMantenimiento._NACIONALIDAD_.add.path" />
                </div>
            </div>
            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>


                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Pais</th>
                            <th scope="col" class="px-6 py-3">Gentilicio</th>
                            <th scope="col" class="px-6 py-3">ACCIONES</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in Nacionalidades" :key="index"  @click="goDetail(item)"
                        class="cursor-pointer  hover:bg-base-300">

                            <td class="px-6 py-4">
                                {{ item?.s_codigo }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item?.s_pais }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.s_gentilicio }}
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
                <ListEmpty v-if="Nacionalidades?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="Nacionalidades?.length && !isLoading" :pagination="pagination"
                @paginate="listarNacionalidad()" />
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
import { useNacionalidadStore } from '../../../store/nacionalidad';
import type { Nacionalidad } from "@/models/types";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";

const { Nacionalidades, pagination, isLoading } = toRefs(useNacionalidadStore())
const { listarNacionalidad, disabledNacionalidad, enabledNacionalidad } = useNacionalidadStore();


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Nacionalidad) => {
    router.push({
        name: configMantenimiento._NACIONALIDAD_.update.name,
        params: {
            id: item.s_codigo ,
        },
    });
};

const changeStatus = (item: Nacionalidad) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado
        ? disabledNacionalidad(item)
        : enabledNacionalidad(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarNacionalidad();
        }
    });
};

const onGetFilters = debounce(() => {
    return listarNacionalidad(search.value);
}, 500);


onMounted(() => {
    listarNacionalidad();
})
</script>

<template>
    <Container>
        <Card>
            <Title>Estado</Title>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                  <TextInputSearch @input="filterEstado()" @keyup="filterEstado()" v-model="search"
                   placeholder="Buscar..." />
                </div>
                <div class="text-right">
                <BtnAdd text="Nuevo" :path="configMantenimiento._ESTADO_.add.path" />
               </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Codigo SBS</th>
                            <th scope="col" class="px-6 py-3">Tipo</th>
                            <th scope="col" class="px-6 py-3">Descripcion.</th>
                            <th scope="col" class=" py-3">Acciones.</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in Estados" :key="index" @click="goDetail(item)"
                        class="cursor-pointer  hover:bg-base-300">

                            <td class="px-6">
                                {{ item?.i_codigo }}
                            </td>
                            <td class="px-6">
                                {{ item.s_codigo_sbs }}
                            </td>
                            <td class="px-6">
                                {{ item.s_tipo }}
                            </td>
                            <td class="px-6">
                                {{ item.s_desc }}
                            </td>
                            <td class="flex actions">
                                <button @click="goDetail(item)" type="button"
                                    class="btn btn-sm btn-circle bg-base-200">
                                  <ToolTip text="Editar">
                                    <EditIcon />
                                  </ToolTip>
                                </button>

                                <button type="button"
                                    class="btn btn-sm btn-circle bg-error text-white">
                                    <DeleteIcon />
                                </button>
                            </td>


                        </tr>
                    </tbody>

                </Table>
                <ListEmpty v-if="Estados?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="Estados?.length && !isLoading" :pagination="pagination"
                @paginate="listarEstado()" />
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
  Title,
  THead,
  Table,
  TextInputSearch, ToolTip,
} from "../../../components";
import { debounce } from "../../../utils/debounce";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import { configMantenimiento } from '../../../router/Mantenimiento/MantenimientoConfig';
import type { Estado } from '../../../models/types';
import { useEstadoStore } from '../../../store/estado';

const { listarEstado } = useEstadoStore();
const {  Estados, isLoading , pagination } = toRefs(useEstadoStore());


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Estado) => {
    if(item.i_codigo){
        router.push({
        name: configMantenimiento._ESTADO_.update.name,
        params: {
            id: item.i_codigo,
        },
    });
    }

};


const filterEstado = debounce(() => {
    return  listarEstado(search.value);
}, 500);

onMounted(() => {
    listarEstado()
})


</script>

<template>
    <Container>
        <Card>
            <Title>Unidades</Title>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                  <TextInputSearch @input="filterUbigeo()" @keyup="filterUbigeo()" v-model="search" placeholder="Buscar..." />
                </div>
                <div class="text-right">
                <BtnAdd text="Nuevo" :path="configMantenimiento._UNIDADES_.add.path" />
               </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Abrev.</th>
                            <th scope="col" class="px-6 py-3">Observacion</th>

                            <th scope="col" class=" py-3">Acciones.</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in Unidades" :key="index" @click="goDetail(item)"
                        class="cursor-pointer  hover:bg-base-300">

                            <td class="px-6">
                                {{ item?.s_codigo }}
                            </td>
                            <td class="px-6">
                                {{ item.s_nombre }}
                            </td>
                            <td class="px-6">
                                {{ item.s_abrev }}
                            </td>
                            <td class="px-6">
                                {{ item.s_observacion }}
                            </td>
                            <td class="flex actions">
                                <button type="button"
                                    class="btn btn-sm btn-circle bg-base-200">
                                  <ToolTip text="Editar">
                                    <EditIcon />
                                  </ToolTip>
                                </button>

                                <button type="button"   @click.stop
                                    class="btn btn-sm btn-circle bg-error text-white">
                                    <DeleteIcon />
                                </button>
                            </td>


                        </tr>
                    </tbody>

                </Table>
                <ListEmpty v-if="Unidades?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="Unidades?.length && !isLoading" :pagination="pagination"
                @paginate="listarUnidad()" />
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
import { configMantenimiento } from "@/router/Mantenimiento/MantenimientoConfig";
import { useUnidadStore } from '../../../store/unidad';
import type { Unidad } from '../../../models/types';

const { listarUnidad } = useUnidadStore();
const {  Unidades, isLoading , pagination } = toRefs(useUnidadStore());


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Unidad) => {
    if(item.s_codigo){
        router.push({
        name: configMantenimiento._UNIDADES_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
    }

};


const filterUbigeo = debounce(() => {
    return  listarUnidad(search.value);
}, 500);

onMounted(() => {
    listarUnidad()
})


</script>

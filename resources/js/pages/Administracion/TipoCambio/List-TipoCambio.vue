<template>
    <Container>
        <Card>
            <Title>
                Tipo de Cambio
            </Title>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                    <TextInputSearch @input="filterTipoCambio()" @keyup="filterTipoCambio()" v-model="search"
                        placeholder="Buscar..." />
                </div>
                <div class="text-right">
                    <BtnAdd text="Nuevo Tipo de Cambio" :path="configAdministracion._TIPOCAMBIO_.add.path" />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">

                <Table>
                    <THead>
                        <tr>

                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Compra</th>
                            <th scope="col" class="px-6 py-3">Venta</th>
                            <th scope="col" class="px-6 py-3">Fecha</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in TipoCambios" :key="index"
                        class="cursor-pointer  hover:bg-base-300" @click="goDetail(item)">

                            <th scope="row" class="px-6 py-4 font-medium text-primary whitespace-nowrap dark:text-white">
                                {{ item.s_codigo }}
                            </th>
                            <td class="px-6 py-4">
                                {{ item.de_compra }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.de_venta }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.d_fecha_reg }}
                            </td>
                          <td class="flex actions">
                            <button
                                @click="goDetail(item)"
                                type="button"
                                class="btn btn-sm btn-circle bg-base-200"
                            >
                              <EditIcon />
                            </button>


                          </td>

                        </tr>
                    </tbody>
                </Table>
                <ListEmpty v-if="TipoCambios.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="TipoCambios.length && !isLoading"
                :pagination="pagination" @paginate="listarTipoCambio()" />
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
  TextInputSearch,
  Table,
  THead, ToolTip,
} from "../../../components";
import { debounce } from "../../../utils/debounce";
import { useTipoCambioStore } from '../../../store/tipo-cambio';
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { TipoCambio } from "@/models/types";
import { Title } from '../../../components';
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";

const {listarTipoCambio} = useTipoCambioStore();
const { TipoCambios, pagination, isLoading } = toRefs(useTipoCambioStore());


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: TipoCambio) => {
    router.push({ name: configAdministracion._TIPOCAMBIO_.update.name, params: { id: item.s_codigo } })
}


const filterTipoCambio = debounce(() => {
    return listarTipoCambio(search.value);
}, 500);

onMounted(() => {
    listarTipoCambio();
})
</script>

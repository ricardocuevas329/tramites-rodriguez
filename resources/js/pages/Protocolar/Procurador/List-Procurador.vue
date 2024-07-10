<template>
  <Container>
    <div v-if="$route.name == configProtocolar._PROCURADORES_.listar.name">
      <Card>
        <Title>Procuradores</Title>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4  gap-2 my-4">
          <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
            <TextInputSearch @input="filter()" @keyup="filter()" v-model="search" placeholder="Buscar..."/>
          </div>
          <div class="col-span-1 flex">
            <Options text="Opciones">
              <ul tabindex="0"
                  class="static  dropdown-content z-60 menu p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                  <a @click="filter()">
                    <RefreshIcon/>
                    Refrescar
                  </a>

                </li>
              </ul>
            </Options>
          </div>
        </div>
        <ContainerTable v-if="!isLoading">
          <Table>
            <THead>
            <tr class="text-left bg-blue">
              <th>Fecha</th>
              <th>Empresa Solicitante</th>
              <th>Solicitante</th>
              <th>Contacto</th>
              <th>Accion</th>
            </tr>
            </THead>
            <tbody>
            <tr class="cursor-pointer hover:bg-gray-200" :class="idSelected === item.s_codigo && 'bg-gray-400'"
              v-if="procuradores?.length"  v-for="(item, key) in procuradores" :key="key" @click="onViewDetail(item.s_codigo)">
              <td>{{ item.d_fecha_registro }}</td>
              <td class="actions">{{ item.facturado_cliente?.nombre_compuesto }}{{ item.facturado_empresa?.nombre_compuesto }}</td>
              <td class="actions">{{ item.referente_cliente?.nombre_compuesto }}{{ item.referente_empresa?.nombre_compuesto }}</td>
              <td class="actions">{{ item.contacto_cliente?.nombre_compuesto }}{{ item.contacto_empresa?.nombre_compuesto }}</td>
              <td class="flex">
                  <button
                          class="btn btn-xs btn-primary  ">
                     <i class="pi pi-file"></i>Ver Detalle
                  </button>
              </td>
            </tr>
            </tbody>
          </Table>
          <ListEmpty v-if="procuradores?.length == 0"/>
        </ContainerTable>
        <Skeleton v-if="isLoading" :tipo="2"/>
        <Paginate v-if="procuradores?.length && !isLoading" :pagination="pagination"
                  @paginate="listarProcuradores()"/>
      </Card>
    </div>

    <router-view></router-view>
  </Container>
</template>

<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
import {
  Card,
  Container,
  ContainerTable,
  ListEmpty,
  Options,
  Paginate,
  Skeleton,
  Table,
  TextInputSearch,
  THead,
  Title,
} from "@/components";
import {debounce} from "../../../utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";
import {useKardexExternalStore} from "@/store/external/kardex.external";
import {useRouter} from "vue-router";
import {useProcuradorStore} from "@/store/procurador";

const {listKardexActives} = useKardexExternalStore()
const {search, pagination, isLoading, procuradores} = toRefs(useProcuradorStore());
const {listarProcuradores, cleanPagination} = useProcuradorStore();
const idSelected = ref<string>('')
const router = useRouter()

const filter = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  cleanPagination()
  await listarProcuradores();
}



const onViewDetail = async(cod: string) => {
  idSelected.value = cod
  await router.push({
    name: configProtocolar._PROCURADORES_.detail.name,
    params: {
      id: cod,
    }
  })

}



onMounted(() => {
  listKardexActives()
  if (!procuradores.value.length) {
    listarProcuradores();
  }
});
</script>

<style scoped>

</style>

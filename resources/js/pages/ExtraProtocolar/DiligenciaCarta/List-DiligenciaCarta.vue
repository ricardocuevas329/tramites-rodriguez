<template>
  <div>
    <div class="grid grid-cols-1"
         :class="$route.name == configExtraProtocolar._DILIGENCIA_CARTA_.listar.name ? '' : 'md:grid-cols-4'">
        <div class="col-span-2 ">
        <RouterView v-slot="{ Component}">
          <TransitionSlide>
            <component :is="Component"/>
          </TransitionSlide>
        </RouterView>
        </div>
      <div class="col-span-2 ">
        <Card>
          <Title>Envios Programados</Title>
          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 my-4">
            <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
              <TextInputSearch
                  @input="onFilter()"
                  @keyup="onFilter()"
                  v-model="search"
                  placeholder="Buscar..."
              />
            </div>
            <div class="col-span-1">
              <Options text="Opciones">
                <div class="lg:mx-1 lg:px-1 mx-2 px-3 py-1">
                  <MenuItem v-slot="{ active }" @click="filterData()">
                    <Item :active="active">
                      <RefreshIcon
                          :active="active"
                          class="mr-2 h-5 w-5 text-violet-400"
                          aria-hidden="true"
                      />
                      Refrescar
                    </Item>
                  </MenuItem>
                  <MenuItem v-slot="{ active }">
                    <Item :active="active">
                      <DeleteIcon
                          :active="active"
                          class="mr-2 h-5 w-5 text-violet-400"
                          aria-hidden="true"
                      />
                      Exportar
                    </Item>
                  </MenuItem>
                </div>
              </Options>
            </div>
          </div>
          <ContainerTable v-if="!isLoading">
            <Table>
              <THead>
              <tr>
                <th scope="col" class="">ACCIÓN</th>
                <th scope="col" class="">FECHA PROGRAMACIÓN</th>
                <th scope="col" class="">Nº CARTA</th>
                <th scope="col" class="">ASIGNADO A</th>
                <th scope="col" class="">DESTINATARIO</th>
                <th scope="col" class="">OBSERVACIÓN</th>
                <th scope="col" class="">ESTADO</th>
                <th scope="col" class="">FECHA DE ENTREGA</th>
              </tr>
              </THead>
              <tbody>
              <tr v-for="(item, index) in DiligenciaProgramadas" :key="index">
                <td class="flex actions">
                  <div v-if="item?.i_estado == 2">
                    <button
                        type="button"
                        @click.stop
                        class="btn btn-sm btn-circle bg-base-200"
                        @click="onViewDiligencia(item?.s_num_carta)"
                    >
                      <ToolTip position="right"  text="VER DILIGENCIA">
                        <Eye />
                      </ToolTip>
                    </button>
                  </div>
                  <div v-else>
                    <button type="button" class="btn btn-circle btn-sm btn-ghost" @click="goAddDiligencia(item)">
                      <ToolTip position="right" text="REGISTRAR DILIGENCIA">
                        <EmailPlus />
                      </ToolTip>
                    </button>
                  </div>
                </td>
                <td class="">{{ item.d_fecha_programacion }}</td>
                <td class="">{{ item.s_num_carta }}</td>

                <td class="">{{ item?.motorizado?.nombre_compuesto }}</td>
                <td class="">{{ item.cartas[0].s_destinatario }}</td>
                <td class="">{{ item.s_observacion }}</td>
                <td class="">
                  <div v-if="item.i_estado == 1">
                    <span class="badge badge-outline p-2 badge-xs badge-info text-white">PENDIENTE</span>
                  </div>
                  <div v-else-if="item.i_estado == 2">
                    <span class="badge  badge-outline p-2 badge-xs badge-success text-white">ENTREGADO</span>
                  </div>
                </td>
                <td class="">{{ item?.created_at }}</td>
              </tr>
              </tbody>
            </Table>
          </ContainerTable>

          <ListEmpty  text="Sin Información" v-if="DiligenciaProgramadas?.length == 0" />

          <Skeleton v-if="isLoading" :tipo="2" />
          <Paginate
              v-if="DiligenciaProgramadas?.length && !isLoading"
              :pagination="pagination"
              @paginate="listarDiligencia()"
          />
        </Card>
      </div>
    </div>
  </div>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import { onMounted, toRefs } from "vue";
import { debounce } from "../../../utils/debounce.js";
import EmailPlus from "vue-material-design-icons/EmailPlus.vue";
import Eye from "vue-material-design-icons/Eye.vue";
import {
  Card,
  Container,
  ToolTip,
  Options,
  ListEmpty,
  ContainerTable,
  Paginate,
  TextInputSearch,
  Skeleton,
  THead,
  Table,
  Title,
} from "../../../components";
import { configExtraProtocolar } from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import { useDiligenciaCartaStore } from "../../../store/diligencia-carta";
import { usePropsRoute} from "@/utils/RoutersUtils";
import type {DiligenciaProgramada} from "@/models/types";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import Item from "@/components/Item.vue";
import {MenuItem} from "@headlessui/vue";
import {TransitionSlide} from "@morev/vue-transitions";

const { DiligenciaProgramadas, isLoading, pagination, search } = toRefs(
  useDiligenciaCartaStore()
);
const { listarDiligencia, limpiarPagination } = useDiligenciaCartaStore();

const router = useRouter();

const onFilter = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  limpiarPagination();
  await listarDiligencia();
};

const goAddDiligencia = async (payload: DiligenciaProgramada) => {
  await router.push({name:configExtraProtocolar._DILIGENCIA_CARTA_.add.name })
  usePropsRoute({  id_carta: payload.s_num_carta, motorizado: payload.motorizado.nombre_compuesto  });
}

const onViewDiligencia = async(id: number) => {
  await router.push({
    name: configExtraProtocolar._DILIGENCIA_CARTA_.view_diligencia.name,
    params: {
      id: id,
    },
  });
}

onMounted(() => {
  if(!DiligenciaProgramadas.value.length){
    listarDiligencia();
  }

});

</script>

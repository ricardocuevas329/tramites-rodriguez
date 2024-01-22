<template>
  <Container>
    <Card>
      <Title>Tipo Compareciente</Title>
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
        <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
          <TextInputSearch @input="filterTipoCompareciente()" @keyup="filterTipoCompareciente()" v-model="search"
                           placeholder="Buscar..."/>
        </div>
        <div class="text-right">
          <BtnAdd text="Nuevo" :path="configMantenimiento._TIPO_COMPARECIENTE_.add.path"/>
        </div>
      </div>

      <ContainerTable v-if="!isLoading">
        <Table>
          <THead>
          <tr>
            <th scope="col" class="px-6 py-3">Codigo</th>
            <th scope="col" class="px-6 py-3">Nombre</th>
            <th scope="col" class="px-6 py-3">Codigo SG.</th>
            <th scope="col" class="px-6 py-3">Tipo PDT</th>
            <th scope="col" class="px-6 py-3">Color</th>
            <th scope="col" class="px-6 py-3">Clase</th>
            <th scope="col" class=" py-3">Acciones.</th>
          </tr>
          </THead>
          <tbody>
          <tr v-for="(item, index) in TipoComparecientes" :key="index" @click="goDetail(item)"
              class="cursor-pointer  hover:bg-base-300">

            <td class="px-6">
              {{ item?.s_codigo }}
            </td>
            <td class="px-6">
              {{ item.s_nombre }}
            </td>
            <td class="px-6">
              {{ item.s_codigo_sg }}
            </td>
            <td class="px-6">
              {{ item.s_tipo_pdt }}
            </td>
            <td class="px-6">
              {{ item.s_color }}
            </td>
            <td class="px-6">
              {{ item.s_clase }}
            </td>
            <td class="flex actions">
              <button type="button"
                      class="btn btn-sm btn-circle bg-base-200">
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
        <ListEmpty v-if="TipoComparecientes?.length == 0"/>
      </ContainerTable>
      <Skeleton v-if="isLoading" :tipo="2"/>
      <Paginate v-if="TipoComparecientes?.length && !isLoading" :pagination="pagination"
                @paginate="listarTipoCompareciente()"/>
    </Card>
    <RouterView/>
  </Container>
</template>
<script setup lang="ts">
import {useRouter} from "vue-router";
import {onMounted, ref, toRefs} from 'vue';
import {
  BtnAdd,
  Card,
  Container,
  ContainerTable,
  ListEmpty,
  Paginate,
  Skeleton,
  Table,
  TextInputSearch,
  THead,
  Title, ToolTip,
} from "../../../components";
import {notify} from "@kyvg/vue3-notification";
import {debounce} from "../../../utils/debounce";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";
import {configMantenimiento} from '../../../router/Mantenimiento/MantenimientoConfig';
import type {TipoCompareciente} from '../../../models/types';
import {useTipoComparecienteStore} from '../../../store/tipo-compareciente';

const {listarTipoCompareciente, disabledTipoCompareciente, enabledTipoCompareciente} = useTipoComparecienteStore();
const {TipoComparecientes, isLoading, pagination} = toRefs(useTipoComparecienteStore());


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: TipoCompareciente) => {
  if (item.s_codigo) {
    router.push({
      name: configMantenimiento._TIPO_COMPARECIENTE_.update.name,
      params: {
        id: item.s_codigo,
      },
    });
  }

};

const changeStatus = async (item: TipoCompareciente) => {
  if (!confirm("¿Estas completamente Seguro(a)?")) {
    return;
  }

  const {status, message} = item.i_estado
      ? await disabledTipoCompareciente(item)
      : await enabledTipoCompareciente(item);

  if (status) {
    notify({
      title: "Exito",
      text: message,
    });
    await listarTipoCompareciente();
  }
};

const filterTipoCompareciente = debounce(() => {
  return listarTipoCompareciente(search.value);
}, 500);

onMounted(() => {
  listarTipoCompareciente()
})


</script>

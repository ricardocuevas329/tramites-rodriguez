<template>
  <Container>
    <Card>
      <Title>Tipo Documento</Title>
      <div
          class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4"
      >
        <div
            class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
        >
          <TextInputSearch
              @input="filterTipoDocumento()"
              @keyup="filterTipoDocumento()"
              v-model="search"
              placeholder="Buscar..."
          />
        </div>
        <div class="text-right">
          <BtnAdd
              text="Nuevo Tipo Documento"
              :path="configMantenimiento._TIPO_DOCUMENTO_.add.path"
          />
        </div>
      </div>
      <ContainerTable v-if="!isLoading">
        <Table>
          <THead>
          <tr>

            <th scope="col" class="px-6 py-3">CODIGO</th>
            <th scope="col" class="px-6 py-3">SBS</th>
            <th scope="col" class="px-6 py-3">CNL</th>
            <th scope="col" class="px-6 py-3">NOMBRE</th>
            <th scope="col" class="px-6 py-3">ABREVIATURA</th>
            <th scope="col" class="px-6 py-3">DIGITOS</th>
            <th scope="col" class="px-6 py-3">TIPO FE</th>
            <th scope="col" class="px-6 py-3">ACCIONES</th>
          </tr>
          </THead>
          <tbody>
          <tr
              v-for="(item, index) in TipoDocumentos"
              :key="index"
              class="cursor-pointer  hover:bg-base-300"
              @click="goDetail(item)"
          >

            <th class="px-6 py-4">
              {{ item.s_codigo }}
            </th>
            <td class="px-6 py-4">
              {{ item.s_codigo_sbs }}
            </td>
            <td class="px-6 py-4">
              {{ item.s_cod_cnl }}
            </td>
            <td class="px-6 py-4">
              {{ item.s_nombre }}
            </td>
            <td class="px-6 py-4">
              {{ item.s_abrev }}
            </td>
            <td class="px-6 py-4">
              {{ item.i_digitos }}
            </td>
            <td class="px-6 py-4">
              {{ item.s_tipo_fe }}
            </td>
            <td class="flex actions">
              <button
                  type="button"
                  class="btn btn-sm btn-circle bg-base-200"
              >
                <ToolTip text="Editar">
                  <EditIcon/>
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

        <ListEmpty v-if="TipoDocumentos?.length == 0"/>
      </ContainerTable>
      <Skeleton v-if="isLoading" :tipo="2"/>
      <Paginate
          v-if="TipoDocumentos?.length && !isLoading"
          :pagination="pagination"
          @paginate="listarTipoDocumento()"
      />
    </Card>
    <RouterView/>
  </Container>
</template>
<script setup lang="ts">
import {useRouter} from "vue-router";
import {onMounted, ref, toRefs} from "vue";
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
  Title,
  ToolTip
} from "../../../components";
import {notify} from "@kyvg/vue3-notification";
import {debounce} from "../../../utils/debounce";
import {useTipoDocumentoStore} from "../../../store/tipo-documento";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import {configMantenimiento} from "../../../router/Mantenimiento/MantenimientoConfig";
import type {TipoDocumento} from "@/models/types";

const {TipoDocumentos, pagination, isLoading} = toRefs(
    useTipoDocumentoStore()
);
const {listarTipoDocumento, disabledTipoDocumento, enabledTipoDocumento} =
    useTipoDocumentoStore();

const router = useRouter();
const search = ref<string>("");

const goDetail = (item: TipoDocumento) => {
  router.push({
    name: configMantenimiento._TIPO_DOCUMENTO_.update.name,
    params: {
      id: item.s_codigo,
    },
  });
};

const changeStatus = async (item: TipoDocumento) => {
  if (!confirm("¿Estas completamente Seguro(a)?")) {
    return;
  }

  const {status, message} = item.i_estado
      ? await disabledTipoDocumento(item)
      : await enabledTipoDocumento(item);

  if (status) {
    notify({
      title: "Exito",
      text: message,
    });
    await listarTipoDocumento();
  }
};

const filterTipoDocumento = debounce(() => {
  return listarTipoDocumento(search.value);
}, 500);

onMounted(() => {
  listarTipoDocumento();
});
</script>

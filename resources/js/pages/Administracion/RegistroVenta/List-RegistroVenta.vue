<template>
  <Container>
    <div class=" grid grid-cols-1"
      :class="$route.name == configAdministracion._REGISTRO_VENTA_.listar.name ? '' : 'md:grid-cols-4 lg:grid-cols-4'">
      <div class="col-span-2">
        <RouterView v-slot="{ Component }">
          <TransitionSlide>
            <component :is="Component" />
          </TransitionSlide>
        </RouterView>
      </div>
      <div class="col-span-2 md:mx-1">
        <Card>
          <SelectedCheckCounter v-if="selecteds?.length">{{ selecteds?.length }}
          </SelectedCheckCounter>
          <Title>REGISTRO VENTA<span v-if="pagination?.total">({{ pagination?.total }})</span></Title>

          <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4  gap-2 my-4">
            <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
              <TextInputSearch @input="filter()" @keyup="filter()" v-model="search" placeholder="Buscar..." />
            </div>
            <div class="col-span-1">
              <Options text="Opciones">
                <ul tabindex="0" class="static  dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                  <li>
                    <a @click="filter()">
                      <RefreshIcon />
                      Refrescar
                    </a>
                    <a>
                      <DeleteIcon />
                      Exportar
                    </a>
                  </li>
                </ul>
              </Options>
            </div>
            <div class="md:text-end lg:text-right">
              <BtnAdd text="Nuevo" :path="configAdministracion._REGISTRO_VENTA_.add.path" />
            </div>
          </div>

          <ContainerTable v-if="!isLoading">
            <Table>
              <THead>
                <tr>
                  <th scope="col" class="px-6"></th>
                  <th scope="col" class="">Fecha Registro</th>
                  <th scope="col" class="">Tipo Documento</th>
                  <th scope="col" class="">Serie</th>
                  <th scope="col" class="">Numero</th>
                  <th scope="col" class="">Cliente</th>
                  <th scope="col" class="">Condicion</th>
                  <th scope="col" class="">Total</th>
                  <th scope="col" class="">Documento Asociado</th>
                  <th scope="col" class="">Anotacion</th>
                </tr>
              </THead>
              <tbody>
                <tr v-for="(item, index) in RegistrationSales" :key="index" class="cursor-pointer  hover:bg-base-300"
                  @click="onEdit(item)">
                  <td class="relative actions   ">

                    <div @click.stop class="dropdown  dropdown-right  dropdown-content dropdown-hover ">

                      <label tabindex="0" class="  m-1">
                        <button class="btn btn-sm btn-circle bg-base-200">
                          <DotsVertical />
                        </button>
                      </label>

                      <ul tabindex="0" class="static  dropdown-content z-[50] menu p-2   shadow bg-base-100 rounded-box">
                        <div class="flex">
                          <button @click="onEdit(item)" class="btn btn-sm btn-circle btn-ghost text-primary">
                            <ToolTip position="right" text="Editar">
                              <EditIcon />
                            </ToolTip>
                          </button>
                          <button class="btn btn-sm btn-circle btn-ghost text-green-400">
                            <ToolTip position="right" text="Exportar a Excel">
                              <FileExcel class="" />
                            </ToolTip>
                          </button>
                          <button class="btn btn-sm btn-circle btn-ghost text-red-500 ">
                            <ToolTip position="right" text="Exportar a Excel">
                              <FilePdfBox />
                            </ToolTip>
                          </button>
                        </div>
                      </ul>
                    </div>


                  </td>
                  <td class=" ">
                    {{ item.d_fecha }}
                  </td>
                  <td class=" ">
                    {{ item?.documento_caja?.s_abrev }}
                  </td>
                  <td class=" ">
                    {{ item.s_serieunica }}
                  </td>
                  <td class=" ">
                    {{ item?.s_numeroSerie }}
                  </td>
                  <td class=" ">
                    <span v-if="item?.cliente" class="badge badge-outline badge-success badge-xs text-xs  "> {{
                      item.cliente.nombre_compuesto }} </span>
                    <span v-if="item?.empresa" class="badge badge-outline badge-success badge-xs text-xs  "> {{
                      item.empresa.nombre_compuesto }}</span>

                  </td>
                  <td class=" ">
                    {{ item.i_pago_credito ? 'SI' :'NO' }}
                  </td>
                  <td class=" ">
                      {{ item.de_total?.toFixed(2) }}
                  </td>
                  <td class=" ">
                  </td>
                  <td class=" ">
                  </td>
                  <td class=" ">
                  </td>
                </tr>
              </tbody>
            </Table>
            <ListEmpty v-if="RegistrationSales?.length == 0" />
          </ContainerTable>
          <Skeleton v-if="isLoading" :tipo="2" />
          <Paginate v-if="RegistrationSales?.length && !isLoading" :pagination="pagination"
            @paginate="listRegistrationSale()" />
        </Card>
      </div>
    </div>
  </Container>
</template>
<script setup lang="ts">
import { onMounted, ref, toRefs } from "vue";
import {
  BtnAdd,
  Card,
  Container,
  ContainerTable,
  ListEmpty,
  Options,
  Paginate,
  SelectedCheckCounter,
  Skeleton,
  Table,
  TextInputSearch,
  THead,
  Title,
  ToolTip
} from "@/components";
import { debounce } from "../../../utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import type {  PermisoViaje } from "@/models/types";
import { useTipoDocumentoStore } from '@/store/tipo-documento';
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import FileExcel from "vue-material-design-icons/FileExcel.vue";
import DotsVertical from "vue-material-design-icons/DotsVertical.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import { TransitionSlide } from "@morev/vue-transitions";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import Button from "primevue/button";
import { useRouter } from "vue-router";
import { useRegistroVentaStore } from "@/store/registro-venta";
import type { ReciboPago } from "@/models/types";
 
const { search, pagination, isLoading, RegistrationSales } = toRefs(useRegistroVentaStore());
const { listRegistrationSale, cleanPagination } = useRegistroVentaStore();


const { getDocumentCompany } = useTipoDocumentoStore()
const router = useRouter()
const selecteds = ref<PermisoViaje[]>();

const filter = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  cleanPagination()
  await listRegistrationSale();
}

const onEdit = async (item: ReciboPago) => {
  await router.push({
    name: configAdministracion._REGISTRO_VENTA_.update.name,
    params: {
      id: item.s_codigo,
    },
  })
}


onMounted(() => {
  if(!RegistrationSales.value.length){
    listRegistrationSale();
  }

  getDocumentCompany()

});
</script>

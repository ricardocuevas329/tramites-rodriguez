<template>
  <Container>
    <div class=" grid grid-cols-1"
         :class="$route.name == configProtocolar._KARDEX_.listar.name ? '' : 'md:grid-cols-4 lg:grid-cols-4'">
      <div class="col-span-2">
      <RouterView v-slot="{ Component}">
        <TransitionSlide>
          <component :is="Component"/>
        </TransitionSlide>
      </RouterView>
      </div>
      <div class="col-span-2 md:mx-1">
        <Card>
          <SelectedCheckCounter v-if="selecteds?.length"
          >{{ selecteds?.length }}
          </SelectedCheckCounter>
          <Title>Kardex <span v-if="pagination?.total">({{ pagination?.total }})</span></Title>

          <div
              class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4  gap-2 my-4"
          >
            <div
                class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
            >
              <TextInputSearch
                  @input="filter()"
                  @keyup="filter()"
                  v-model="search"
                  placeholder="Buscar..."
              />
            </div>
            <div class="col-span-1">
              <Options text="Opciones">
                <ul tabindex="0"
                    class="static  dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                  <li>
                    <a @click="filter()">
                      <RefreshIcon/>
                      Refrescar
                    </a>
                    <a>
                      <DeleteIcon/>
                      Exportar
                    </a>
                  </li>
                </ul>
              </Options>
            </div>
            <div class="md:text-end lg:text-right">
              <BtnAdd
                  text="Nuevo"
                  :path="configProtocolar._KARDEX_.add.path"
              />
            </div>
          </div>

          <ContainerTable v-if="!isLoading">
            <Table>
              <THead>
              <tr>
                <th scope="col" class="px-6"></th>
                <th scope="col" class="">Kardex</th>
                <th scope="col" class="">Usuario/Empresa</th>
                <th scope="col" class="">Asesor</th>
                <th scope="col" class="">Fecha Ingreso</th>
                <th scope="col" class="">N° Operación</th>
                <th scope="col" class="">Fecha Escritura</th>
                <th scope="col" class="">Fecha Ultima Escritura</th>
                <th scope="col" class="">N° Titulo-Estado Registral</th>
                <th scope="col" class="">Estado Notarial</th>
                <th scope="col" class="">Sit</th>
                <th scope="col" class="">Obs</th>
                <th scope="col" class="">Observación</th>
              </tr>
              </THead>
              <tbody>
              <tr v-for="(item, index) in Kardexs" :key="index"
                  class="cursor-pointer  hover:bg-base-300" @click="onEdit(item)">
                <td class="relative actions   ">

                  <div @click.stop class="dropdown  dropdown-right  dropdown-content dropdown-hover ">

                    <label tabindex="0" class="  m-1">
                      <button class="btn btn-sm btn-circle bg-base-200">
                        <DotsVertical/>
                      </button>
                    </label>

                    <ul tabindex="0"
                        class="static  dropdown-content z-[50] menu p-2   shadow bg-base-100 rounded-box">
                      <div class="flex">
                        <button @click="onEdit(item)"
                            class="btn btn-sm btn-circle btn-ghost text-primary">
                          <ToolTip position="right" text="Editar">
                            <EditIcon/>
                          </ToolTip>
                        </button>
                        <button
                            class="btn btn-sm btn-circle btn-ghost text-green-400">
                          <ToolTip position="right" text="Exportar a Excel">
                            <FileExcel class=""/>
                          </ToolTip>
                        </button>
                        <button
                            class="btn btn-sm btn-circle btn-ghost text-red-500 " >
                          <ToolTip position="right" text="Exportar a Excel">
                            <FilePdfBox/>
                          </ToolTip>
                        </button>
                      </div>
                    </ul>
                  </div>


                </td>
                <td class=" ">
                  {{ item.s_tipokardex }} - {{ item.s_codigo }}
                </td>
                <td class=" ">
                  {{ item.cliente?.nombre_compuesto }} {{ item.empresa?.nombre_compuesto }}
                </td>
                <td class=" ">
                  {{ item.asesor?.nombre_compuesto }}
                </td>
                <td class=" ">
                  {{ item.d_feching }}
                </td>
                <td class=" ">

                </td>
                <td class=" ">
                  {{ item.d_fechescritura }}
                </td>
                <td class=" ">

                </td>
                <td class=" ">

                </td>
                <td class=" ">
                  <span class="badge badge-success badge-xs text-xs  ">  {{ item.estado?.s_desc }} </span>
                </td>
                <td class=" ">

                </td>
                <td class=" ">

                </td>
                <td class=" ">
                  {{ item.s_obstitulo }}
                </td>

              </tr>
              </tbody>
            </Table>
            <ListEmpty v-if="Kardexs?.length == 0"/>
          </ContainerTable>
          <Skeleton v-if="isLoading" :tipo="2"/>
          <Paginate v-if="Kardexs?.length && !isLoading" :pagination="pagination"
                    @paginate="listarKardex()"/>
        </Card>
      </div>
    </div>
  </Container>
</template>
<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
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
import {debounce} from "../../../utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import type {Kardex, PermisoViaje} from "@/models/types";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import FileExcel from "vue-material-design-icons/FileExcel.vue";
import DotsVertical from "vue-material-design-icons/DotsVertical.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import {TransitionSlide} from "@morev/vue-transitions";
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";
import {useKardexStore} from "@/store/kardex";
import Button from "primevue/button";
import {useRouter} from "vue-router";

const {search, pagination, isLoading, Kardexs} = toRefs(useKardexStore());
const {listarKardex, cleanPagination} = useKardexStore();
const router = useRouter()
const selecteds = ref<PermisoViaje[]>();

const filter = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  cleanPagination()
  await listarKardex();
}

const onEdit = async (item: Kardex) => {
  await router.push({
    name: configProtocolar._KARDEX_.update.name,
    params: {
      id: item.s_codigo,
    },
  })
}


onMounted(() => {
  if(!Kardexs.value.length){
    listarKardex();
  }
});
</script>

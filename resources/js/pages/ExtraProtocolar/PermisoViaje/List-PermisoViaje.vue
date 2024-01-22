<template>
  <Container>
    <Card>
      <SelectedCheckCounter v-if="selecteds?.length"
      >{{ selecteds?.length }}
      </SelectedCheckCounter>
      <Title>Permiso de Viaje <span v-if="pagination?.total">({{ pagination?.total }})</span></Title>

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
            <div class="lg:mx-1 lg:px-1 mx-2 px-3 py-1">
              <MenuItem v-slot="{ active }" @click="filter()">
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
        <div class="md:text-end lg:text-right">
          <BtnAdd
              text="Nuevo"
              :path="configExtraProtocolar._PERMISO_VIAJE_.add.path"
          />
        </div>
      </div>

      <Tab :tabs="tabOptions" :icons="tabIcons">
        <template v-slot:PermisosDeViaje>
          <PermisoViajeList/>
        </template>
        <template v-slot:DatosExternos>
          <DatosExternos/>
        </template>
      </Tab>


    </Card>
    <RouterView/>
  </Container>
</template>
<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
import {BtnAdd, Card, Container, Options, SelectedCheckCounter, Tab, TextInputSearch, Title} from "@/components";
import {debounce} from "../../../utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import {MenuItem} from "@headlessui/vue";
import Item from "../../../components/Item.vue";
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import type {PermisoViaje} from "@/models/types";
import {useTipoDocumentoStore} from '@/store/tipo-documento';
import {usePermisoViajeStore} from '@/store/permiso-viaje';
import {useZonaRegistralStore} from '@/store/zona-registral';
import {useCondicionStore} from '@/store/condicion';
import {useNacionalidadStore} from '@/store/nacionalidad';
import {InformationCircleIcon, PaperAirplaneIcon} from "@heroicons/vue/20/solid";
import {DatosExternos, PermisoViajeList } from "./Pages/Index";

const {search, pagination, PermisoViajes, PermisoViajesExternal} = toRefs(usePermisoViajeStore());
const {listarPermisoViaje,cleanPagination, listarPermisoViajeExternal} =
    usePermisoViajeStore();
const { getDocumentClient } = useTipoDocumentoStore();
const {listarZonaRegistral} = useZonaRegistralStore();
const {listarCondicion} = useCondicionStore();
const {listarNacionalidadAll} = useNacionalidadStore();

const selecteds = ref<PermisoViaje[]>();

const tabOptions = ref<any[]>([
  "PermisosDeViaje",
  "DatosExternos",
]);

const tabIcons = [
  PaperAirplaneIcon,
  InformationCircleIcon,

]


const filter = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  cleanPagination()
  await listarPermisoViaje();
  await listarPermisoViajeExternal()
}


onMounted(() => {
  if(!PermisoViajes.value.length){
    listarPermisoViaje();
  }

  if(!PermisoViajesExternal.value.length){
    listarPermisoViajeExternal()
  }

  getDocumentClient();
  listarZonaRegistral()
  listarCondicion()
  listarNacionalidadAll()

});
</script>

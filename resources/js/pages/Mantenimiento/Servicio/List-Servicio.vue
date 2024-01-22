<template>
    <Container>
        <Card>
            <Title>Servicios</Title>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                  <TextInputSearch @input="filterServicio()" @keyup="filterServicio()" v-model="search"
                   placeholder="Buscar..." />
                </div>
                <div class="text-right">
                <BtnAdd text="Nuevo" :path="configMantenimiento._SERVICIO_.add.path" />
               </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Descripcion.</th>
                            <th scope="col" class="px-6 py-3">Generico</th>
                            <th scope="col" class="px-6 py-3">Formato</th>
                            <th scope="col" class="px-6 py-3">Rapidos</th>
                            <th scope="col" class=" py-3">Acciones.</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in Servicios" :key="index" @click="goDetail(item)"
                        class="cursor-pointer  hover:bg-base-300">

                            <td class="px-6">
                                {{ item?.s_codigo }}
                            </td>
                            <td class="px-6">
                                {{ item.s_nombre }}
                            </td>
                            <td class="px-6">
                                {{ item.s_descripcion }}
                            </td>
                            <td class="px-6">
                                {{ item.s_generico }}
                            </td>
                            <td class="px-6">
                                {{ item.i_formato }}
                            </td>
                            <td class="px-6">
                                {{ item.i_rapidos }}
                            </td>
                            <td class="flex actions">
                                <button   type="button"
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
                <ListEmpty v-if="Servicios?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="Servicios?.length && !isLoading" :pagination="pagination"
                @paginate="listarServicio()" />
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
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import { configMantenimiento } from '../../../router/Mantenimiento/MantenimientoConfig';
import type { Servicio } from '../../../models/types';
import { useServicioStore } from '../../../store/servicio';

const { listarServicio, disabledServicio, enabledServicio } = useServicioStore();
const {  Servicios, isLoading , pagination } = toRefs(useServicioStore());


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Servicio) => {
    if(item.s_codigo){
        router.push({
        name: configMantenimiento._SERVICIO_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
    }

};

const changeStatus = async (item: Servicio) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const { status, message } = item.i_estado
        ? await disabledServicio(item)
        : await enabledServicio(item);

    if (status) {
        notify({
            title: "Exito",
            text: message,
        });
        await listarServicio();
    }
};


const filterServicio = debounce(() => {
    return  listarServicio(search.value);
}, 500);

onMounted(() => {
    listarServicio()
})


</script>

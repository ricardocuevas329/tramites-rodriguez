<template>
    <Container>
        <Card>
            <Title>Cargo</Title>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                  <TextInputSearch @input="filterCargo()" @keyup="filterCargo()" v-model="search" placeholder="Buscar..." />
                </div>
                <div class="text-right">
                <BtnAdd text="Nuevo" :path="configMantenimiento._CARGO_.add.path" />
               </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Descripcion</th>
                            <th scope="col" class=" py-3">Acciones.</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in Cargos" :key="index" @click="goDetail(item)"
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
                            <td class="flex actions">
                                <button @click="goDetail(item)" type="button"
                                    class="btn btn-sm btn-circle bg-base-200">
                                  <ToolTip text="Editar">
                                    <EditIcon />
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
                <ListEmpty v-if="Cargos?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="Cargos?.length && !isLoading" :pagination="pagination"
                @paginate="listarCargo()" />
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
import { debounce } from "../../../utils/debounce.js";
import { configMantenimiento } from "@/router/Mantenimiento/MantenimientoConfig";
import { useCargoStore } from '../../../store/cargo';
import type { Cargo } from '../../../models/types';
import { notify } from "@kyvg/vue3-notification";
import {defineAsyncComponent} from "vue";
const EditIcon = defineAsyncComponent(() =>
    import("vue-material-design-icons/Pencil.vue")
);

const DeleteIcon = defineAsyncComponent(() =>
    import("vue-material-design-icons/Delete.vue")
);
const CloseIcon = defineAsyncComponent(() =>
    import("vue-material-design-icons/Close.vue")
);
const { listarCargo, disabledCargo, enabledCargo } = useCargoStore();
const {  Cargos, isLoading , pagination } = toRefs(useCargoStore());


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Cargo) => {
    if(item.s_codigo){
        router.push({
        name: configMantenimiento._CARGO_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
    }

};

const changeStatus = async (item: Cargo) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const { status, message } = item.i_estado
        ? await disabledCargo(item)
        : await enabledCargo(item);

    if (status) {
        notify({
            title: "Exito",
            text: message,
        });
        await listarCargo();
    }
};


const filterCargo = debounce(() => {
    return  listarCargo(search.value);
}, 500);

onMounted(() => {
    listarCargo()
})


</script>

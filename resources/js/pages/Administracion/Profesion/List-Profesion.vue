<template>
    <Container>
        <Card>
            <Title>
                Profesion
            </Title>


            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">

                    <TextInputSearch @input="filterProfesion()" @keyup="filterProfesion()" v-model="search"
                        placeholder="Buscar..." />
                </div>
                <div class="text-right">
                    <BtnAdd text="Nuevo" :path="configAdministracion._PROFESION_.add.path" />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">


                <Table>
                    <THead>
                        <tr>

                            <th scope="col" class="px-6 py-3">SBS</th>
                            <th scope="col" class="px-6 py-3">Nombre M</th>
                            <th scope="col" class="px-6 py-3">Nombbre F</th>
                            <th scope="col" class="px-6 py-3">Tipo</th>
                            <th scope="col" class="px-6 py-3">Descripcion</th>
                            <th scope="col" class="px-6 py-3">ACCIONES</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in Profesiones" :key="index"
                        class="cursor-pointer  hover:bg-base-300" @click="goDetail(item)">


                            <td class="px-6 py-4">
                                {{ item?.s_codigo_sbs }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.s_nombre }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.s_nombref }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.i_tipo }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.s_descripcion }}
                            </td>
                          <td class="flex actions">
                            <button
                                @click="goDetail(item)"
                                type="button"
                                class="btn btn-sm btn-circle bg-base-200"
                            >
                              <EditIcon />
                            </button>

                            <button
                                @click.stop

                                type="button"
                                class="btn btn-sm btn-circle bg-error text-white"
                            >
                              <ToolTip
                                  v-if="item.i_estado"
                                  text="Desactivar"
                              >
                                <DeleteIcon />
                              </ToolTip>
                              <ToolTip v-else text="Activar">
                                <CloseIcon />
                              </ToolTip>
                            </button>
                          </td>

                        </tr>
                    </tbody>

                </Table>
                <ListEmpty v-if="Profesiones?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="Profesiones?.length && !isLoading
                " :pagination="pagination" @paginate="listarProfesion()" />
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
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import { useProfesionStore } from '../../../store/profesion';
import { configAdministracion } from '@/router/Administracion/AdministracionConfig';
import type { Profesion } from "@/models/types";
import { Title } from '../../../components';
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";

const {listarProfesion, disabledProfesion, enabledProfesion} = useProfesionStore();
const { Profesiones, pagination, isLoading } = toRefs(useProfesionStore());


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Profesion) => {
    router.push({
        name: configAdministracion._PROFESION_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
};

const changeStatus = (item: Profesion) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado
        ? disabledProfesion(item)
        : enabledProfesion(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarProfesion();
        }
    });
};

const filterProfesion = debounce(() => {
    return listarProfesion(search.value);
}, 500);


onMounted(() => {
    listarProfesion();
})
</script>

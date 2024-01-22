<template>
    <Container>
        <Card>
            <Title> Acciones </Title>
            <div
                class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4"
            >
                <div
                    class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
                >
                    <TextInputSearch
                        @input="filterArea()"
                        @keyup="filterArea()"
                        v-model="search"
                        placeholder="Buscar..."
                    />
                </div>
                <div class="text-right">
                    <BtnAdd
                        text="Nueva Accion"
                        :path="configAdministracion._ACCION_.add.path"
                    />
                </div>
            </div>
            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>

                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Decripción</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in Acciones"
                            :key="index"
                            class="cursor-pointer  hover:bg-base-300"
                        >

                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-primary whitespace-nowrap dark:text-white"
                            >
                                {{ item.i_codigo }}
                            </th>
                            <td class="px-6 py-4">
                                {{ item.s_nombre }}
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
                                @click="changeStatus(item)"
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

                <ListEmpty v-if="Acciones.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Acciones.length && !isLoading"
                :pagination="pagination"
                @paginate="listarAccion()"
            />
        </Card>
        <RouterView />
    </Container>
</template>
<script lang="ts" setup>
import { useRouter } from "vue-router";
import { ref, toRefs, onMounted } from "vue";
import {
  Card,
  Container,
  Paginate,
  BtnAdd,
  Skeleton,
  ListEmpty,
  ContainerTable,
  Table,
  Title,
  TextInputSearch, ToolTip,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import THead from "../../../components/THead.vue";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import { useAccionStore } from "../../../store/accion";
import type { Accion } from '../../../models/types';
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";


const { Acciones, pagination, isLoading } = toRefs(useAccionStore());
const { listarAccion, disabledAccion, enabledAccion } = useAccionStore();

const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Accion) => {
    router.push({
        name: configAdministracion._ACCION_.update.name,
        params: { id: item.i_codigo },
    });
};

const changeStatus = (item: Accion) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado ? disabledAccion(item) : enabledAccion(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarAccion();
        }
    });
};

const filterArea = debounce(() => {
    return listarAccion(search.value);
}, 500);

onMounted(() => {
    listarAccion();
});
</script>

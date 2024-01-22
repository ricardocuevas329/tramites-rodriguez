<template>
    <Container>
        <Card>
            <Title> Areas </Title>
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
                        text="Nueva Area"
                        :path="configAdministracion._AREAS_.add.path"
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
                            v-for="(item, index) in Areas"
                            :key="index"
                            class="cursor-pointer  hover:bg-base-300"
                            @click="goDetail(item)"
                        >
                            <th
                                scope="row"
                                class="px-6 py-4 font-medium text-primary whitespace-nowrap dark:text-white"
                            >
                                {{ item.s_codigo }}
                            </th>
                            <td class="px-6 py-4">
                                {{ item.s_nombre }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.s_descarea }}
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

                <ListEmpty v-if="Areas.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Areas.length && !isLoading"
                :pagination="pagination"
                @paginate="listarAreas()"
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
import { useAreaStore } from "../../../store/area";
import THead from "../../../components/THead.vue";
import type { Area } from "../../../models/types";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";

const storeArea = useAreaStore();
const { listarAreas, disabledArea, enabledArea } = useAreaStore();
const { Areas, pagination, isLoading } = toRefs(useAreaStore());

const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Area) => {
    router.push({
        name: configAdministracion._AREAS_.update.name,
        params: { id: item.s_codigo },
    });
};

const changeStatus = (item: Area) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado ? disabledArea(item) : enabledArea(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarAreas();
        }
    });
};

const filterArea = debounce(() => {
    return listarAreas(search.value);
}, 500);

onMounted(() => {
    listarAreas();
});
</script>

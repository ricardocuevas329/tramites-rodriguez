<template>
    <Container>
        <Card>
            <Title> Bienes </Title>
            <div
                class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4"
            >
                <div
                    class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
                >
                    <TextInputSearch
                        @input="filterBanco()"
                        @keyup="filterBanco()"
                        v-model="search"
                        placeholder="Buscar..."
                    />
                </div>
                <div class="text-right">
                    <BtnAdd
                        text="Nuevo Bien"
                        :path="configAdministracion._BIENES_.add.path"
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
                            v-for="(item, index) in Bienes"
                            :key="index"
                            class="cursor-pointer  hover:bg-base-300"
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
                                {{ item.descripcion }}
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

                <ListEmpty v-if="Bienes.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Bienes.length && !isLoading"
                :pagination="pagination"
                @paginate="listarBienes()"
            />
        </Card>
        <RouterView />
    </Container>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import { ref, onMounted, toRefs } from "vue";
import {
  Card,
  Container,
  Paginate,
  BtnAdd,
  Skeleton,
  ListEmpty,
  ContainerTable,
  TextInputSearch, ToolTip,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import { useBienStore } from "../../../store/bienes";
import { Title, Table, THead } from "../../../components";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Bien } from "@/models/types";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";

const { listarBienes, disabledBien, enabledBien } = useBienStore();
const { Bienes, pagination, isLoading } = toRefs(useBienStore());

const router = useRouter();
const search = ref<string>("");

const goDetail = (item: Bien) => {
    router.push({
        name: configAdministracion._BIENES_.update.name,
        params: { id: item.s_codigo },
    });
};

const changeStatus = (item: Bien) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado ? disabledBien(item) : enabledBien(item);
    rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarBienes();
        }
    });
};

const filterBanco = debounce(() => {
    return listarBienes(search.value);
}, 500);

onMounted(() => {
    listarBienes();
});
</script>

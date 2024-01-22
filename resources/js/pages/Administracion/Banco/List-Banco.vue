<template>
    <Container>
        <Card>
            <Title> Bancos </Title>
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
                        text="Nuevo Banco"
                        :path="configAdministracion._BANCO_.add.path"
                    />
                </div>
            </div>
            <ContainerTable v-if="!isLoading">
                <Table
                    class="w-full text-sm text-left text-primary-500 dark:text-gray-400"
                >
                    <THead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">CNL</th>
                            <th scope="col" class="px-6 py-3">PDT</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Abreviatura</th>
                            <th scope="col" class="px-6 py-3">Acciones</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in Bancos"
                            :key="index"
                            class="cursor-pointer  hover:bg-base-300"
                        >
                            <td class="px-6 py-4">
                                {{ item.id_cod }}
                            </td>
                            <td class="px-6 py-4">
                                {{ item.s_cod_pdt }}
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
                <ListEmpty v-if="Bancos.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Bancos.length && !isLoading"
                :pagination="pagination"
                @paginate="listarBancos()"
            />
        </Card>
        <RouterView />
    </Container>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import { useBancoStore } from "../../../store/banco";
import { onMounted, toRefs } from "vue";
import {
  Card,
  Container,
  Paginate,
  BtnAdd,
  Skeleton,
  ListEmpty,
  ContainerTable,
  Table,
  THead,
  Title,
  TextInputSearch, ToolTip,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Banco } from "@/models/types";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";

const { Bancos, pagination, isLoading, search } = toRefs(useBancoStore());
const { listarBancos, disabledBanco, enabledBanco, cleanPagination } =
    useBancoStore();

const router = useRouter();

const goDetail = (item: Banco) => {
    router.push({
        name: configAdministracion._BANCO_.update.name,
        params: { id: item.id_cod },
    });
};

const changeStatus = (item: Banco) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado ? disabledBanco(item) : enabledBanco(item);
    rpta.then((res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            listarBancos();
        }
    });
};

const filterBanco = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination();
    await listarBancos();
};

onMounted(() => {
    listarBancos();
});
</script>

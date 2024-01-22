<template>
    <Container>
        <Card>
            <SelectedCheckCounter v-if="selecteds?.length"
                >{{ selecteds?.length }}
            </SelectedCheckCounter>
            <Title
                >Personal
                <span v-if="pagination?.total">({{ pagination?.total }})</span>
            </Title>

            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-2 my-4"
            >
                <div
                    class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
                >
                    <TextInputSearch
                        @input="onFilter()"
                        @keyup="onFilter()"
                        v-model="search"
                        placeholder="Buscar..."
                    />
                </div>
                <div class="col-span-1">
                    <Options text="Opciones">
                        <ul tabindex="0"
                            class="static  dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                            <li>
                                <a @click="onListData()">
                                    <RefreshIcon/>
                                    Refrescar
                                </a>
                                <a>
                                    <ExportIcon/>
                                    Exportar
                                </a>
                            </li>
                        </ul>
                    </Options>
                </div>
                <div class="md:text-end lg:text-right">
                    <BtnAdd
                        text="Nuevo"
                        :path="configEntidad._PERSONAL_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class=" ">
                                <div class="flex px-2 items-center">
                                    <CheckBox
                                        :checked="isMarkAll"
                                        @input="onSelectedAll(isMarkAll)"
                                    />
                                </div>
                            </th>

                            <th scope="col" class="">Nombres</th>
                            <th scope="col" class="">Correo</th>
                            <th scope="col" class="">Ubigeo</th>
                            <th scope="col" class="">Nacionalidad</th>
                            <th scope="col" class="">
                                Tipo Documento
                            </th>
                            <th scope="col" class="">Documento</th>
                            <th scope="col" class="px-6">Acciones</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                            v-for="(item, index) in Personales"
                            :key="index"
                            @click="goDetail(item)"
                            class="cursor-pointer  hover:bg-base-300"
                        >
                            <td class="w-4 p-4" @click.stop>
                                <div class="flex items-center">
                                    <CheckBox
                                        :checked="
                                            selecteds?.length &&
                                            selecteds[index]?.s_codigo ==
                                                item?.s_codigo
                                                ? true
                                                : false
                                        "

                                    />

                                </div>
                            </td>

                            <td class="">
                                {{ item?.nombre_compuesto }}
                            </td>
                            <td class="">
                                {{ item.s_mail }}
                            </td>
                            <td class="">
                                {{ item.ubigeo?.departamento }}-{{
                                    item.ubigeo?.provincia
                                }}-{{ item.ubigeo?.distrito }}
                            </td>

                            <td class="">
                                {{ item.nacionalidad?.s_gentilicio }}
                            </td>
                            <td class="">
                                {{ item.tipo_documento?.s_abrev }}
                            </td>
                            <td class="">
                                {{ item.s_numero }}
                            </td>

                            <td class="actions flex">
                                <button

                                    @click.stop
                                    @click="onOpenModalPass(item)"
                                    class="btn btn-sm btn-circle bg-base-200"
                                >
                                    <ToolTip text="Cambiar Clave">
                                        <KeyIcon />
                                    </ToolTip>
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-sm btn-circle bg-base-200"
                                >
                                    <ToolTip text="Editar">
                                        <EditIcon />
                                    </ToolTip>
                                </button>
                                <button
                                    @click.stop
                                    @click="changeStatus(item)"

                                    class="btn btn-sm btn-circle bg-error text-white"
                                >
                                    <ToolTip
                                        v-if="item.i_estado"
                                        text="Desactivar"
                                    >
                                        <DeleteIcon  />
                                    </ToolTip>
                                    <ToolTip v-else text="Activar">
                                        <CloseIcon />
                                    </ToolTip>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </Table>
                <ListEmpty v-if="Personales?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate
                v-if="Personales?.length && !isLoading"
                :pagination="pagination"
                @paginate="listarPersonal()"
            />
        </Card>
        <RouterView />
        <PasswordPersonal :idModalPass="idModalPass" :userSelected="userSelected"   />

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
    SelectedCheckCounter,
    THead,
    Table,
    Title,
    TextInputSearch,
    Options,
    ToolTip
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { debounce } from "../../../utils/debounce.js";
import { usePersonalStore } from "../../../store/personal";
import KeyIcon from "vue-material-design-icons/Key.vue";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import { configEntidad } from "../../../router/Entidad/EntidadConfig";
import type { User } from "@/models/types";
import { useTipoDocumentoStore } from "../../../store/tipo-documento";
import { useRoleStore } from "../../../store/role";
import { usePermissionStore } from "../../../store/permission";
import ExportIcon from "vue-material-design-icons/Export.vue";
import { CheckBox } from '../../../components';
import {useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";
import PasswordPersonal from "./Password-Personal.vue"

const { Personales, search, pagination, isLoading } = toRefs(
    usePersonalStore()
);
const { listarPersonal, disabledPersonal, enabledPersonal, cleanPagination } =
    usePersonalStore();
const { listarActivos } = useTipoDocumentoStore();
const { listarRoles } = useRoleStore();
const { listarPermission } = usePermissionStore();

const router = useRouter();
const selecteds = ref<User[]>();
const userSelected = ref<User>();
const isMarkAll = ref<boolean>(false);
const idModalPass = useGenerateKeyRandom();

const goDetail = (item: User) => {
    router.push({
        name: configEntidad._PERSONAL_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
};

const changeStatus = async (item: User) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const { status, message } = item.i_estado
        ? await disabledPersonal(item)
        : await enabledPersonal(item);

    if (status) {
        notify({
            title: "Exito",
            text: message,
        });
        await listarPersonal();
    }
};

const onOpenModalPass = (item: User) => {
    useOpenModal(idModalPass)
    userSelected.value = item
}

const onFilter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination();
    await listarPersonal();
};

const onSelectedAll = (state: boolean) => {
    if (state) {
        return (selecteds.value = Personales.value);
    }
    return (selecteds.value = []);
};

const onListData = () => {
    listarPersonal();
    listarActivos();
    listarRoles();
    listarPermission();
}

onMounted(() => {
    onListData()
});
</script>

<template>
    <Container>
        <Card>
            <Title>Documento Venta</Title>
            <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
                <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
                  <TextInputSearch @input="filterDocumentoVenta()" @keyup="filterDocumentoVenta()" v-model="search"
                   placeholder="Buscar..." />
                </div>
                <div class="text-right">
                <BtnAdd text="Nuevo" :path="configMantenimiento._DOCUMENTO_VENTA_.add.path" />
               </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Codigo</th>
                            <th scope="col" class="px-6 py-3">Nombre</th>
                            <th scope="col" class="px-6 py-3">Impresora</th>
                            <th scope="col" class="px-6 py-3">Abrev.</th>
                            <th scope="col" class="px-6 py-3">Serie</th>
                            <th scope="col" class="px-6 py-3">Tipo</th>
                            <th scope="col" class=" py-3">Acciones.</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr v-for="(item, index) in DocumentoVentas" :key="index" @click="goDetail(item)"
                        class="cursor-pointer  hover:bg-base-300">

                            <td class="px-6">
                                {{ item.s_codigo }}
                            </td>
                            <td class="px-6" >
                                {{ item.s_nombre }}
                            </td>
                            <td class="px-6">
                                {{ item.s_impresora }}
                            </td>
                            <td class="px-6">
                                {{ item.s_abrev }}
                            </td>
                            <td class="px-6">
                                {{ item.s_serie }}
                            </td>
                            <td class="px-6">
                                {{ item.id_tipo_comprobante }}
                            </td>

                            <td class="flex actions">
                                <button   type="button"
                                    class="btn btn-sm btn-circle bg-base-200">
                                    <ToolTip text="Editar">
                                    <EditIcon />
                                    </ToolTip>
                                </button>

                                <button @click.stop  @click="changeStatus(item)" type="button"
                                    class="btn btn-sm btn-circle bg-error text-white">
                                    <ToolTip v-if="item.i_estado"  text="Desactivar">
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
                <ListEmpty v-if="DocumentoVentas?.length == 0" />
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
            <Paginate v-if="DocumentoVentas?.length && !isLoading" :pagination="pagination"
                @paginate="listarDocumentoVenta()" />
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
TextInputSearch,
ToolTip
} from "../../../components";
import { debounce } from "../../../utils/debounce";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import { configMantenimiento } from '../../../router/Mantenimiento/MantenimientoConfig';
import type { DocumentoVenta } from '../../../models/types';
import { useDocumentoVentaStore } from '../../../store/documento-venta';
import { notify } from '@kyvg/vue3-notification';
import CloseIcon from 'vue-material-design-icons/Close.vue';

const { listarDocumentoVenta, disabledDocumentoVenta, enabledDocumentoVenta } = useDocumentoVentaStore();
const {  DocumentoVentas, isLoading , pagination } = toRefs(useDocumentoVentaStore());


const router = useRouter();
const search = ref<string>("");

const goDetail = (item: DocumentoVenta) => {
    if(item.s_codigo){
        router.push({
        name: configMantenimiento._DOCUMENTO_VENTA_.update.name,
        params: {
            id: item.s_codigo,
        },
    });
    }

};

const changeStatus = (item: DocumentoVenta) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }

    const rpta = item.i_estado
        ? disabledDocumentoVenta(item)
        : enabledDocumentoVenta(item);

        rpta.then(async (res) => {
        if (res.status) {
            notify({
                title: "Exito",
                text: res.message,
            });
            await listarDocumentoVenta();
        }
    });
};

const filterDocumentoVenta = debounce(() => {
    return  listarDocumentoVenta(search.value);
}, 500);

onMounted(() => {
    listarDocumentoVenta()
})


</script>

<template>
    <Container>
        <Card>
            <Title> Configuracion </Title>
            <div class="flex items-center justify-between mb-4">
                <BtnEdit
                    v-if="configuracion?.i_codigo"
                    text="Modificar Configuracion"
                    @click="goDetail()"
                />
                <BtnAdd
                    v-else
                    text="AGREGAR Configuracion"
                    @click="goDetail()"
                />
            </div>
            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                        <tr>
                            <th scope="col" class="px-6 py-3">Descripcion</th>
                            <th scope="col" class="px-6 py-3">Dirección</th>
                            <th scope="col" class="px-6 py-3">Empresa</th>
                            <th scope="col" class="px-6 py-3">Logo</th>
                        </tr>
                    </THead>
                    <tbody>
                        <tr
                        class="cursor-pointer  hover:bg-base-300"
                        @click="goDetail()"
                        >
                            <td class="px-6 py-4">
                                {{ configuracion?.s_descripcion }}
                            </td>
                            <td class="px-6 py-4">
                                {{ configuracion?.s_direccion }}
                            </td>
                            <td class="px-6 py-4">
                                {{ configuracion?.s_empresa }}
                            </td>
                            <td class="px-6 py-4">
                                <img
                                    v-if="configuracion?.s_ruta_logo"
                                    class="w-10 h-10 rounded"
                                    :src="configuracion?.s_ruta_logo"
                                    alt="Default avatar"
                                />
                            </td>
                        </tr>
                    </tbody>
                </Table>
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2" />
        </Card>
        <RouterView />
    </Container>
</template>
<script setup lang="ts">
import { useRouter } from "vue-router";
import {
    Card,
    Container,
    BtnAdd,
    Skeleton,
    BtnEdit,
    ContainerTable,
    Table,
    THead,
    Title,
} from "../../../components";
import { useConfiguracionStore } from "../../../store/configuracion";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import { toRefs, onMounted } from "vue";

const { configuracion, isLoading } = toRefs(useConfiguracionStore());
const { listarConfiguracion } = useConfiguracionStore();

const router = useRouter();

const goDetail = () => {
    if (configuracion.value?.i_codigo) {
        return router.push({
            name: configAdministracion._CONFIGURACION_.update.name,
            params: { id: configuracion?.value?.i_codigo },
        });
    }
    return router.push({ name: configAdministracion._CONFIGURACION_.add.name });
};

onMounted(() => {
    listarConfiguracion();
});
</script>

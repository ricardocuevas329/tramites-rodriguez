<template>
    <div class="md:mx-28">
        <div class="flex justify-between pt-4 pb-4 mt-4 mx-2">
            <div>
                <a role="button" class="btn btn-sm">Programación de Firmas</a>
            </div>

        </div>

        <div v-if="!isLoading" class="overflow-x-scroll md:overflow-x-auto lg:overflow-x-clip">
            <Table>
                <THead>
                <tr>
                    <th>FECHA</th>
                    <th>NOMBRES Y APELLIDOS</th>
                    <th>DISTRITO</th>
                    <th>DIRECCION</th>
                    <th></th>
                </tr>
                </THead>
                <tbody>
                <tr>
                    <td>25/10/2023</td>
                    <td>JUAN JOSE</td>
                    <td>SAN JUAN DE LURIGANCHO</td>
                    <td>CALLE LAS LOMAS</td>
                    <th><i class="pi pi-check text-success"></i></th>
                </tr>
                <tr>
                    <td>25/10/2023</td>
                    <td>JUAN JOSE</td>
                    <td>SAN JUAN DE LURIGANCHO</td>
                    <td>CALLE LAS LOMAS</td>
                    <th><i class="pi pi-check text-success"></i></th>
                </tr>
                <tr>
                    <td>25/10/2023</td>
                    <td>JUAN JOSE</td>
                    <td>SAN JUAN DE LURIGANCHO</td>
                    <td>CALLE LAS LOMAS</td>
                    <th><i class="pi pi-check text-success"></i></th>
                </tr>
                <tr>
                    <td>25/10/2023</td>
                    <td>JUAN JOSE</td>
                    <td>SAN JUAN DE LURIGANCHO</td>
                    <td>CALLE LAS LOMAS</td>
                    <th><i class="pi pi-check text-success"></i></th>
                </tr>
                </tbody>
            </Table>
        </div>


    </div>
</template>
<script lang="ts" setup>
import {onMounted, toRefs} from "vue";
import {usePermisoViajeExternalStore} from "@/store/external/permiso-viaje.external";
import {Table, THead} from "@/components"

const {isLoading} = toRefs(
    usePermisoViajeExternalStore()
);
const {listMyRecords} = usePermisoViajeExternalStore();

onMounted(() => {
    listMyRecords();
});
</script>

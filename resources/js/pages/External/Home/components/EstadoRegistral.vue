<template>
  <div class=" ">
    <div class="flex justify-between mb-2 mx-2">
      <div class="flex">
        <BtnBack @click="useCloseModal()"/> <a role="button" class="btn btn-sm">Estado Registral</a>
      </div>

    </div>

    <div v-if="!isLoading" class=" overflow-x-scroll md:overflow-x-auto lg:overflow-x-clip">
      <Table>
        <THead>
        <tr>
          <th>N° TITULO</th>
          <th>FECHA DE PRESENTACION</th>
          <th>ACTO</th>
          <th>ESTADO</th>
          <th>PARTIDA</th>
        </tr>
        </THead>
        <tbody>
        <tr v-if="recordsRegisterPublics?.registro_publico?.length" v-for="(item, k) in recordsRegisterPublics?.registro_publico" :key="k">

          <td>{{ item?.s_titulo }}</td>
          <td>{{ item?.d_fecha }}</td>
          <td> </td>
          <td> {{ item?.s_estadoR }}</td>
          <td> {{ item?.s_partida }}</td>
        </tr>
        <tr v-else>
          <td>Sin Información</td>
        </tr>
        </tbody>

      </Table>
    </div>
  </div>
</template>
<script lang="ts" setup>
import {toRefs} from "vue";
import {usePermisoViajeExternalStore} from "@/store/external/permiso-viaje.external";
import {useClientExternalStore} from "@/store/external/client.external";
import {THead, Table, BtnBack} from "@/components"
import { useCloseModal } from "@/hooks/useUtils";
const {recordsRegisterPublics} = toRefs(useClientExternalStore())
const {isLoading} = toRefs(usePermisoViajeExternalStore())

</script>

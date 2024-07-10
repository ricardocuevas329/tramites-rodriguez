<template>
  <Table>
    <THead>
    <tr>
      <th>Id</th>
      <th>Nombre</th>
      <th>Archivo</th>
      <th>Fecha</th>
    </tr>
    </THead>
    <tbody v-if="data?.length">
      <tr v-for="(item , k) in data" :key="k">
        <td>{{ k+1 }}</td>
        <td>{{ item.name }}</td>
        <td> <a :href="item.file" target="_blank" class="btn btn-xs">VER</a> </td>
        <td>{{ item.created_at }}</td>
      </tr>
    </tbody>
  </Table>
</template>
<script setup lang="ts">
import {Table, THead} from '@/components/Index'
import {type PropType, toRefs} from "vue";
import type {DetalleProcuradorDocument} from "@/models/types";

const props = defineProps({
   data:{
     default: [],
     type: Object as PropType<DetalleProcuradorDocument[]>,
     required: true
   }
})

const { data } = toRefs(props)
</script>

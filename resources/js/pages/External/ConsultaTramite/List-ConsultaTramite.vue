<template>
  <div class="mx-2 lg:mx-6">

    <h1 class="mx-2 text-primary font-bold">
      Consulta de Trámites
    </h1>

    <div class="grid">
      <TextInputSearch @input="filter()"
                       @keyup="filter()"
                       v-model="numKardex" placeholder="Ingrese Numero de Trámite"/>
    </div>

    <div class="divider">RESULTADOS</div>
    <ContainerTable>
      <Table  v-if="!isLoading">
        <THead>
        <tr>
          <th>
            Acciones
          </th>
          <th>
            Fecha
          </th>
          <th>
            Tipo Kardex
          </th>
          <th>
            Numero
          </th>
          <th>
            Fecha Escritura
          </th>
          <th>
            Trámite
          </th>
          <th>
            Empresa/Cliente
          </th>
          <th>
            Fecha Testimonio
          </th>
        </tr>
        </THead>
        <tbody>
        <tr v-for="(item, key) in recordsKardex" :key="key">
          <td class="flex">
            <button @click="onOpenParticipants(item.s_codigo)" class="btn btn-outline btn-xs btn-ghost btn-success">VER <i class="pi pi-user"></i> </button>
          </td> 
          <td>
            {{item.d_feching}}
          </td>
          <td>
            {{item.s_tipokardex}}
          </td>
          <td>
            {{item.s_kardex}}
          </td>
          <td>
            {{item.d_fechescritura}}
          </td>
          <td>
            {{item.s_obstitulo}}
          </td>
          <td>
            {{item.cliente?.nombre_compuesto}} {{item.empresa?.nombre_compuesto}}
          </td>
          <td>
            {{item.d_fechtestimonio}}
          </td>
        </tr>
        </tbody>
      </Table>
      <Skeleton :tipo="2"  v-if="isLoading"/>
    </ContainerTable>
    
    <Compareciente   :id="idModalCompareciente" :kardex="codKardex"  />
 

  </div>
</template>
<script lang="ts" setup>
import {Table,Skeleton,ContainerTable, THead, TextInputSearch, Modal} from "@/components"
import {Compareciente} from './Components'
import {useKardexConsultaExternalStore} from "@/store/external/kardex-consulta.external"
import {ref, toRefs} from "vue";
import {debounce} from "@/utils/debounce";
import { useGenerateKeyRandom, useOpenModal } from '@/hooks/useUtils';

const numKardex = ref<string>('')
const idModalCompareciente = useGenerateKeyRandom()
const codKardex = ref<string>('')

const {searchKardex} = useKardexConsultaExternalStore()
const {recordsKardex, isLoading} = toRefs(useKardexConsultaExternalStore())


const onOpenParticipants = (cod: string) => {
  codKardex.value = cod
   useOpenModal(idModalCompareciente)
}

const filter = debounce(() => {
  return searchKardex({
    number_kardex: numKardex.value
  });
}, 500);


</script>

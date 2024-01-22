<script setup lang="ts">
import type {PropType} from "vue";
import {ContainerTable, ScrollView, Table, THead, ToolTip} from "@/components";
import type {Participante} from "@/models/types";
import DeleteIcon from "vue-material-design-icons/Delete.vue";

defineProps({
  acompanante: {
    default: {},
    require: false,
    type: Object as PropType<Participante[]>,
  },
});

const emit = defineEmits(["onDeleteParticipant"]);

const onDeleteParticipante = (index: number, participant?: Participante) => {
  emit('onDeleteParticipant', {index, participant})
}


</script>
<template>
  <ScrollView>
    <ContainerTable>
      <Table>
        <THead>
        <th scope="col" class="">Nombre</th>
        <th scope="col" class="">Documento</th>
        <th scope="col" class=""></th>
        </THead>
        <tbody>
        <tr
            v-for="(item, index) in acompanante"
            :key="index"
            class="cursor-pointer hover:bg-base-300"
        >

          <td class="actions">
            <ToolTip  position="right"  :text="item.cliente?.nombre_compuesto ?? item.cliente?.s_nombres ">
              {{ item?.cliente?.nombre_compuesto ?? item.cliente?.s_nombres }}
            </ToolTip>
          </td>
          <td class="">
            {{ item?.cliente.s_num_doc }}
          </td>
          <td class="actions">
            <button
                @click="onDeleteParticipante(index, item)"
                type="button"
                class="btn btn-circle btn-xs text-error"
            >
              <ToolTip text="Remover">
                <DeleteIcon/>
              </ToolTip>
            </button>
          </td>
        </tr>
        </tbody>
      </Table>
    </ContainerTable>
  </ScrollView>
</template>

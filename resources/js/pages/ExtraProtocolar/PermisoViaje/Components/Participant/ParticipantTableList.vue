<script setup lang="ts">
import type {PropType} from "vue";
import {ContainerTable, Table, THead, ToolTip,} from "@/components";
import type {Participante} from "@/models/types";
import DeleteIcon from "vue-material-design-icons/Delete.vue";

import {getParticipanteItem} from "@/services/ParticipanteService";

defineProps({
  participants: {
    default: {},
    require: false,
    type: Object as PropType<Participante[]>,
  },
});

const emit = defineEmits(["onDeleteParticipant", "onEditParticipant"]);

const onDelete = (index: number, participant?: Participante) => {
  if (!confirm("¿Estas Completamente Seguro(a)?")) {
    return;
  }
  emit("onDeleteParticipant", {index, participant});
};

const onEdit = (index: number, participant?: Participante) => {
  emit("onEditParticipant", {index, participant});
};
</script>
<template>
  <ContainerTable>
    <Table>
      <THead>
      <th scope="col" class="">Participa</th>
      <th scope="col" class="">Nombres</th>
      <th scope="col" class="">Edad</th>
      <th scope="col" class="">Firma</th>
      <th scope="col" class=""></th>
      </THead>
      <tbody>
      <tr
          v-for="(item, index) in participants"
          :key="index"
          class="cursor-pointer hover:bg-base-300"
          @click="onEdit(index, item)"
      >
        <td class="">
          {{
            item?.participa_como ??
            getParticipanteItem[item?.i_condicion ?? 1]
          }}
        </td>
        <td class="actions">
          <ToolTip position="top" :text="item?.cliente?.nombre_compuesto ?? item?.cliente?.s_nombres + ' '+item?.cliente?.s_paterno">
            {{ item?.cliente?.nombre_compuesto ?? item?.cliente?.s_nombres + ' '+item?.cliente?.s_paterno  }}
          </ToolTip>
        </td>
        <td class="">
          {{ item?.s_edad }}
        </td>
        <td class="">
          <span v-if="item?.s_edad && parseInt(item?.s_edad) >=  18  && item?.i_firma"  class="badge badge-outline badge-xs badge-success py-2">SI</span>
          <span v-if="item?.s_edad && parseInt(item?.s_edad) >=  18  && !item?.i_firma" class="badge badge-outline badge-xs badge-error py-2">NO</span>

        </td>
        <td class="actions flex">
          <button
              @click.stop
              @click="onDelete(index, item)"
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
</template>

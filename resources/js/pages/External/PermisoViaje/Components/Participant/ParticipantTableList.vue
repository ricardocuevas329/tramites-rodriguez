<script setup lang="ts">
import type {PropType} from "vue";
import {ContainerTable, Table, THead, ToolTip,} from "@/components";
import type {PermisoViajeParticipantExternal} from "@/models/types";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import {getParticipanteItem} from "@/services/ParticipanteService";

defineProps({
  participants: {
    default: {},
    require: false,
    type: Object as PropType<PermisoViajeParticipantExternal[]>,
  },
});

const emit = defineEmits(["onDeleteParticipant", "onEditParticipant"]);

const onDelete = (index: number, participant?: PermisoViajeParticipantExternal) => {
  if (!confirm("¿Estas Completamente Seguro(a)?")) {
    return;
  }
  emit("onDeleteParticipant", {index, participant});
};

const onEdit = (index: number, participant?: PermisoViajeParticipantExternal) => {
  emit("onEditParticipant", {index, participant});
};
</script>
<template>
  <ContainerTable>
    <Table>
      <THead>
      <th scope="col" class="px-6 py-3">Participa</th>
      <th scope="col" class="px-6 py-3">Nombres</th>
      <th scope="col" class="px-6 py-3">Edad</th>
      <th scope="col" class="px-6 py-3">Firma</th>
      <th scope="col" class="px-6 py-3"></th>
      </THead>
      <tbody>
      <tr
          v-for="(item, index) in participants"
          :key="index"
          class="cursor-pointer hover:bg-base-300"
          @click="onEdit(index, item)"
      >
        <td class="px-6 text-xs">
          {{ getParticipanteItem[item?.type ?? 1] }}
        </td>
        <td class="px-6 text-xs">
          <ToolTip :text=" item?.cliente.name + ' '+item?.cliente.paternal ">
            {{ item?.cliente.name + ' '+item?.cliente.paternal + ' '+item?.cliente.maternal}}
          </ToolTip>
        </td>
        <td class="px-6 text-xs">
          {{ item?.age }}
        </td>
        <td class="px-6 text-xs">
          {{ item?.with_signature ? "SI" : "NO" }}
        </td>
        <td class="actions flex">
          <button
              @click.stop
              @click="onDelete(index, item)"
              class="btn btn-circle btn-error btn-xs text-white"
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

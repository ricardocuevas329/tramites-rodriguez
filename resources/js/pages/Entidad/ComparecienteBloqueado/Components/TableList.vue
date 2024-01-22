<template>
    <Table v-if="comparecientes.length">
          <THead>
            <th scope="col" class="px-6 py-3">Compareciente</th>
            <th scope="col" class="px-6 py-3">Nombres</th>
            <th scope="col" class="px-6 py-3">Apellido Paterno</th>
            <th scope="col" class="px-6 py-3">Apellido Materno</th>
            <th scope="col" class="px-6 py-3">Opciones</th>
          </THead>
          <tbody>
            <tr
              v-for="(item, index) in comparecientes"
              :key="index"
              class="cursor-pointer  hover:bg-base-300"
            >
              <td class="px-6 text-xs">
                {{ item?.s_compareciente }}
              </td>
              <td class="px-6 text-xs">
                {{ item?.s_nombres }}
              </td>
              <td class="px-6 text-xs">
                {{ item?.s_paterno }}
              </td>
              <td class="px-6 text-xs">
                {{ item?.s_materno }}
              </td>
              <td class="px-6 text-xs">
                <button
                  @click="comparecientes.splice(index, 1)"
                  class="btn btn-circle  btn-xs btn-error text-white "
                >
                  <ToolTip text="Remover">
                    <DeleteIcon />
                  </ToolTip>
                </button>
              </td>
            </tr>
          </tbody>
        </Table>
</template>
<script lang="ts" setup>
import type { PropType } from 'vue';
import type { DetalleBloqueado } from '../../../../models/types';
import { ToolTip, Table, THead } from '../../../../components';
import DeleteIcon from 'vue-material-design-icons/Delete.vue';
defineProps({
    comparecientes: {
        default: {},
        require: true,
        type: Object as PropType<DetalleBloqueado[]>,
    },
});
</script>

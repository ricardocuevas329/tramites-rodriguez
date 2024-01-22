<template>
  <div>
    <ScrollView>
      <Table>
        <THead>
          <th scope="col" class="px-6 py-3">Codigo</th>
          <th scope="col" class="px-6 py-3">Titulo</th>
          <th scope="col" class="px-6 py-3">Modelo</th>
          <th scope="col" class="px-6 py-3">Editar</th>
          <th scope="col" class="px-6 py-3">Eliminar</th>
        </THead>
        <tbody>
          <tr class="cursor-pointer hover:bg-base-300">
            <td class="px-6 text-xs">MO000000000001</td>
            <td class="px-6 text-xs">BAJO PUERTA, NO HAY NADIE</td>
            <td class="px-6 text-xs">SE REALIZO LA DILIGENCIA.......</td>
            <td class="px-6 text-xs">
              <button class="btn btn-circle btn-xs btn-error text-white">
                <ToolTip text="Editar">
                  <EditIcon />
                </ToolTip>
              </button>
            </td>
            <td class="px-6 text-xs">
              <button class="btn btn-circle btn-xs btn-error text-white">
                <ToolTip text="Remover">
                  <DeleteIcon />
                </ToolTip>
              </button>
            </td>
          </tr>
        </tbody>
      </Table>
    </ScrollView>
    <Center>
      <BtnSave />
    </Center>
  </div>
</template>

<script setup lang="ts">
import * as Yup from "yup";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { type PropType, toRefs, watchEffect, ref } from "vue";
import { debounce } from "../../../../utils/debounce";
import type { PermisoViaje, Cliente } from "@/models/types";
import { useDate } from "@/hooks/useDates";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import {
    BtnAdd,
    Table,
    THead,
    ToolTip,
    RadioInput,
    Modal,
    LabelError,
    TextInputNumber,
    BtnSave,
    Center,
    ScrollView,
    TextInput,
    InputSelect,
    Row,
    DropwdownSelect,
} from "../../../../components";
</script>

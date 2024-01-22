<template>
    <Modal @onCloseModal="useCloseModal" :id="id">
        <p class="text-primary font-bold text-center">COMPARECIENTES</p>
        <ContainerTable>
        <Table>
            <THead>
                <tr>
                    <th>Nombres</th>
                    <th>Firma</th>
                    <th>Fecha Firma</th>
                </tr>
            </THead>
  
        <tbody>
            <tr v-for="(item, k) in participants" :key="k">
                <td >{{ item?.compareciente?.nombre_compuesto }}</td>
                <td class="">
                    <span class="badge badge-xs badge-outline badge-success" v-if="item?.i_firma">SI</span>
                    <span class="badge badge-xs badge-outline badge-error" v-else>NO</span>
                </td>
                <td class="">{{ item?.d_fechfirma }}</td>

            </tr>
        </tbody>
        </Table>
        </ContainerTable>
    </Modal>
</template>
<script lang="ts" setup>
import { Table, ContainerTable, THead, Modal } from "@/components";
import { useKardexConsultaExternalStore } from "@/store/external/kardex-consulta.external";
import { toRefs, onMounted, watch, watchEffect } from "vue";
import { useCloseModal } from '@/hooks/useUtils';

const { listParticipants } = useKardexConsultaExternalStore();
const { participants } = toRefs(useKardexConsultaExternalStore());

const props = defineProps({
    id: {
        type: String,
        required: true,
    },
    kardex: {
        type: String,
        required: true,
    },
});

const { kardex } = toRefs(props);

onMounted(() => {
    watch(kardex, (newKardex, oldKardex) => {
        listParticipants({
            kardex: newKardex,
        });
    });
});
</script>

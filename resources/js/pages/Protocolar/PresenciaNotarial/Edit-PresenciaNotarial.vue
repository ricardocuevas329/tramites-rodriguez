<template>
  <Container>
    <div>
      <Card>
        <Title>
          <BtnBack @click="$router.back()"/>
          Edit Notarial
        </Title>

        <ContainerTable v-if="!isLoading">
          <Table>
            <THead>
            <tr class="text-left bg-blue">
              <th>Fecha</th>
              <th>Empresa Solicitante</th>
              <th>Solicitante</th>
              <th>Contacto</th>
            </tr>
            </THead>
            <tbody>
            <tr class="cursor-pointer hover:bg-gray-200"
                v-if="details?.s_codigo">
              <td>{{ details.d_fecha_registro }}</td>
              <td class="actions">{{
                  details.facturado_cliente?.nombre_compuesto
                }}{{ details.facturado_empresa?.nombre_compuesto }}
              </td>
              <td class="actions">{{
                  details.referente_cliente?.nombre_compuesto
                }}{{ details.referente_empresa?.nombre_compuesto }}
              </td>
              <td class="actions">{{
                  details.contacto_cliente?.nombre_compuesto
                }}{{ details.contacto_empresa?.nombre_compuesto }}
              </td>
            </tr>
            </tbody>
          </Table>
          <Center><Title>Detalles</Title></Center>
          <Table>
            <THead>
            <tr class="text-left bg-blue">
              <th>Fecha</th>
              <th>Hora Inicio</th>
              <th>Hora Fin</th>
              <th>Procurador Direc</th>
              <th>Distrito</th>
              <th>Observacion</th>
            </tr>
            </THead>
            <tbody>
            <tr class="cursor-pointer hover:bg-gray-200"
                v-if="details?.detalle?.length" v-for="(item, key) in details?.detalle" :key="key">
              <td>{{ item?.d_fechapresen }}</td>
              <td>{{ item?.s_hora_inicio }}</td>
              <td>{{ item?.s_hora_fin }}</td>
              <td>{{ item?.asistente?.nombre_compuesto ?? 'sin data' }}</td>
              <td>{{ item?.s_lugar }}</td>
              <td>{{ item?.s_observacion }}</td>
            </tr>
            </tbody>
          </Table>
          <ListEmpty text="No se encontraron Datos" v-if="!details?.s_codigo"/>
        </ContainerTable>
        <Skeleton v-if="isLoading" :tipo="2"/>

      </Card>
    </div>


    <router-view></router-view>
  </Container>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import {
  Card,
  Container,
  ContainerTable,
  ListEmpty,
  Skeleton,
  Table,
  THead,
  Title,
  Center
} from "@/components";
import {useRoute} from "vue-router";
import {usePresenciaNotarialStore} from "@/store/presencia-notarial";
import BtnBack from "@/components/BtnBack.vue";
import type {Presencia} from "@/models/types";

const {findPresenciaNotarialById} = usePresenciaNotarialStore();
const details = ref<Presencia>();
const isLoading = ref<boolean>(false)
const route = useRoute()
const cod_selected = ref<string>(route.params.id?.toString())


onMounted(async () => {

  try {
    isLoading.value = true
    const {status, presencial_notarial} = await findPresenciaNotarialById(cod_selected.value)
    if (status) {
      details.value = presencial_notarial
    }
  } catch (e) {
    isLoading.value = false
  } finally {
    isLoading.value = false
  }

});
</script>

<style scoped>

</style>

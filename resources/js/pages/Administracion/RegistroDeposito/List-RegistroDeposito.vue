<template>
  <Container>
    <Card>
      <Title>
        Registro Deposito
      </Title>

      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 xlg:grid-cols-4 gap-2 my-4">
        <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">

          <TextInputSearch @input="filterProfesion()" @keyup="filterProfesion()" v-model="search"
                           placeholder="Buscar..."/>
        </div>
        <div class="text-right">
          <BtnAdd text="Registrar Deposito" :path="configAdministracion._REGISTRO_DEPOSITO_.add.path"/>
        </div>
      </div>

      <ContainerTable v-if="!isLoading">


        <Table>
          <THead>
          <tr>
            <th scope="col">Acciones</th>
            <th scope="col">Kardex</th>
            <th scope="col">Fotos</th>
            <th scope="col">Asesor</th>
            <th scope="col">Tipo</th>
            <th scope="col">Banco</th>
            <th scope="col">F.Ope</th>
            <th scope="col">Num Ope</th>
            <th scope="col">Monto</th>
            <th scope="col">F.Registro</th>
            <th scope="col">F.Aprobacion</th>
            <th scope="col">Aprobado Por</th>
            <th scope="col">Observacion</th>
          </tr>
          </THead>
          <tbody>
          <tr v-for="(item, index) in RegistroDepositos" :key="index"
              class="cursor-pointer  hover:bg-base-300" @click="goDetail(item)">

            <td class="flex actions" @click.stop>
              <div class="dropdown  dropdown-right   dropdown-content  ">

                <label tabindex="0" class="  m-1">
                  <button class="btn btn-sm btn-circle bg-base-200">
                    <DotsVertical/>
                  </button>
                </label>

                <ul class="static  dropdown-content z-[50] -mt-4 menu p-2  bg-base-100 rounded-box ">
                  <div class="flex">

                    <button @click="onGenerateExcel(item)" :disabled="isDownloadDocument"
                            class="btn btn-sm btn-circle bg-base-200">
                      <ToolTip position="right" text="Exportar a Excel">
                        <FileExcel class="text-primary"/>
                      </ToolTip>
                    </button>
                    <button @click="onGeneratePDF(item)" :disabled="isDownloadDocument"
                            class="btn btn-sm btn-circle bg-base-200">
                      <ToolTip position="right" text="Exportar a PDF">
                        <FilePdfBox class="text-red-400"/>
                      </ToolTip>
                    </button>
                    <button @click="goDetail(item)" :disabled="isDownloadDocument"
                            class="btn btn-sm btn-circle bg-base-200">
                      <ToolTip position="right" text="Editar">
                        <EditIcon/>
                      </ToolTip>
                    </button>


                  </div>
                </ul>

              </div>
              <button v-if="!item?.aprobado" @click="onAproveByCod(item, index)" :disabled="isDownloadDocument"
                      class="btn btn-sm btn-circle bg-base-200 text-success">
                <ToolTip position="right" text="Aprobar">
                  <Check/>
                </ToolTip>
              </button>
              <button v-else disabled
                      class="btn btn-sm btn-circle bg-base-200 text-success">
                <Check/>
              </button>
            </td>
            <td>
              {{ item?.kardex?.s_tipokardex }}-{{ item?.kardex?.s_kardex }}
            </td>
            <td>
              <div v-if="item.fotos?.length" class="avatar" v-for="(doc, i) in item?.fotos" :key="i">
                <div v-if="isURL(doc.file)" @click.stop @click="onView(item?.fotos)" class="w-14 rounded">
                  <img :src="doc.file"/>
                </div>
              </div>

            </td>
            <td>
              {{ item.s_asesor }}
            </td>

            <td>
              {{ item.s_tipo }}
            </td>
            <td>
              {{ item.s_banco }}
            </td>
            <td>
              {{ item.d_fecha_ope }}
            </td>
            <td>
              {{ item.s_num_ope }}
            </td>
            <td>
              {{ item.i_monto }}
            </td>
            <td>
              {{ item.d_fecha_reg }}
            </td>
            <td>
              {{ item.d_fecha_aprob }}
            </td>
            <td>
              <span v-if="item?.aprobado?.nombre_compuesto"
                    class="badge badge-xs badge-outline p-2 badge-success">{{ item?.aprobado?.nombre_compuesto }}</span>
              <span v-else class="badge badge-xs badge-outline p-2 badge-error"> NO APROBADO </span>

            </td>
            <td>
              {{ item.s_comentario }}
            </td>
          </tr>
          </tbody>

        </Table>
        <ListEmpty v-if="RegistroDepositos?.length == 0"/>
      </ContainerTable>
      <Skeleton v-if="isLoading" :tipo="2"/>
      <Paginate v-if="RegistroDepositos?.length && !isLoading
                " :pagination="pagination" @paginate="listRegistroDeposito()"/>
    </Card>
    <Galery ref="galeryComponentRef" :files="files"  />
    <RouterView/>
  </Container>
</template>
<script setup lang="ts">
import {useRouter} from "vue-router";
import {onMounted, ref, toRefs} from 'vue';
import {
  BtnAdd,
  Card,
  Container,
  ContainerTable,
  Galery,
  ListEmpty,
  Paginate,
  Skeleton,
  Table,
  TextInputSearch,
  THead,
  Title,
  ToolTip
} from "../../../components";
import {notify} from "@kyvg/vue3-notification";
import {debounce} from "../../../utils/debounce.js";
import {configAdministracion} from '@/router/Administracion/AdministracionConfig';
import type {DepositosDetalle, RegistroDeposito} from "@/models/types";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import {useRegistroDepositoStore} from "@/store/registro-deposito";
import FileExcel from "vue-material-design-icons/FileExcel.vue";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import DotsVertical from "vue-material-design-icons/DotsVertical.vue";
import Check from "vue-material-design-icons/Check.vue";

import {useBancoStore} from "@/store/banco";
import {isURL} from "@/hooks/useUtils";
import {useTipoKardexStore} from "@/store/tipo-kardex";

const {cleanPagination, listRegistroDeposito, disabledRegistroDeposito, enabledRegistroDeposito, onAprove} = useRegistroDepositoStore();
const {search, RegistroDepositos, pagination, isLoading} = toRefs(useRegistroDepositoStore());
const {listAllBancos} = useBancoStore()
const {listTipoKardexActives} = useTipoKardexStore()
const router = useRouter();
const isDownloadDocument = ref<boolean>(false);
const files = ref<DepositosDetalle[]>([]);

const goDetail = (item: RegistroDeposito) => {
  router.push({
    name: configAdministracion._REGISTRO_DEPOSITO_.update.name,
    params: {
      id: item.s_codigo,
    },
  });
};

const galeryComponentRef = ref<any>(null);
const filterProfesion = debounce(() => {
  cleanPagination()
  return listRegistroDeposito();
}, 500);

const onAproveByCod = async (payload: RegistroDeposito, index: number) => {
  if (!confirm("¿estas completamente seguro(a) de aprobar este Depósito?")) {
    return
  }
  const {  status, message} = await onAprove(payload.s_codigo)
  if (status) {
    notify({
      title: message,
      type: 'success'
    })
   await listRegistroDeposito();
  }
}
const onGenerateExcel = (payload: RegistroDeposito) => {

}

const onGeneratePDF = (payload: RegistroDeposito) => {

}

const onView = (docs: DepositosDetalle[]) => {
  files.value = docs;
  galeryComponentRef.value?.onOpen()
}
onMounted(() => {
  if(!RegistroDepositos.value.length){
    listRegistroDeposito();
  }
  listAllBancos()
  listTipoKardexActives()
})


</script>

<template>
  <Container>
    <div v-if="$route.name == configProtocolar._TRAMITE_.listar.name">
      <Card>
        <Title>Trámite</Title>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4  gap-2 my-4">
          <div class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2">
            <TextInputSearch @input="filter()" @keyup="filter()" v-model="search" placeholder="Buscar..."/>
          </div>
          <div class="col-span-1">
            <Options text="Opciones">
              <ul tabindex="0"
                  class="static  dropdown-content z-60 menu p-2 shadow bg-base-100 rounded-box w-52">
                <li>
                  <a @click="filter()">
                    <RefreshIcon/>
                    Refrescar
                  </a>

                </li>
              </ul>
            </Options>
          </div>
        </div>
        <ContainerTable v-if="!isLoading">
          <Table>
            <THead>
            <tr class="bg-blue">
              <th>Accion</th>
              <th>CODIGO</th>
              <th>F. INGRESO</th>
              <th>SOLICITANTE</th>
              <th>N° DOCUMENTO</th>
              <th>ACTO NOTARIAL</th>
              <th>KARDEX</th>
              <th>F. APERTURA</th>
              <th>F. ESCRITURACION</th>
              <th>F. ULTIMA FIRMA</th>
              <th>STATUS</th>
            </tr>
            </THead>
            <tbody>
            <tr class="cursor-pointer hover:bg-gray-200" :class="idSelected === item.id && 'bg-gray-400'"
                v-for="(item, key) in TramiteResults" :key="key" @click="onSelectedRow(item)">
              <td @click.stop class="flex actions">

                <ToolTip text="asignar kardex" position="right">
                  <button :disabled="item?.kardex" @click="onAsignationKardex(item.id)"
                          class="btn btn-circle btn-xs btn-ghost text-success ">
                    <DocumentAttachSharp/>
                  </button>
                </ToolTip>
                <template v-if="!item?.kardex">
                  <ToolTip text="Ver Kardex sin Asignar" position="right">
                    <button @click="viewUnassignedKarkex(item)"
                            class="btn btn-circle btn-xs btn-ghost text-accent ">
                      <DocumentTextSharp/>
                    </button>
                  </ToolTip>
                </template>
              </td>
              <td class="text-center">{{ item.id }}</td>
              <td>{{ item.created_at }}</td>
              <td>{{ item.nombre_compuesto }}</td>
              <td>{{ item.documento }}</td>
              <td> {{ item?.detalle_kardex?.s_obstitulo }}</td>
              <td> {{ item?.detalle_kardex?.s_tipokardex }} - {{ item?.detalle_kardex?.num_kardex }}
              </td>
              <td>{{ item?.detalle_kardex?.d_feching }}</td>
              <td>{{ item?.detalle_kardex?.d_fechescritura }}</td>
              <td> {{ item?.is_date_mayor }}</td>
              <td> {{ item?.situacion_detalle?.s_nombre }}</td>


            </tr>
            </tbody>
          </Table>
          <ListEmpty v-if="TramiteResults?.length == 0"/>
        </ContainerTable>
        <Skeleton v-if="isLoading" :tipo="2"/>
        <Paginate v-if="TramiteResults?.length && !isLoading" :pagination="pagination"
                  @paginate="listTramite()"/>
      </Card>
    </div>

    <Galery ref="galeryComponentRef" :showItemNavigators="false" :files="fileSelected"/>

    <Modal :id="idModalAsignKardex" @onCloseModal="useCloseModal()">

      <h3 class="card-title text-primary">
        <button class="btn btn-xs btn-circle right-0" @click="useCloseModal()">
          <i class="pi pi-arrow-left"></i>
        </button>

        Asignar Kardex
      </h3>
      <div class="divider"></div>
      <ScrollView>
                <span v-if="form.num_kardex.$error?.message" class="text-xs text-error">{{
                    form.num_kardex.$error?.message
                  }}</span>
        <div class="flex w-full">
          <select v-model="form.cod_tramite.$value" v-if="recordsKardex?.length"
                  class="input  select input-primary">
            <option v-for="(item, i) in recordsKardex" :key="i" :value="item.s_abre"> {{
                item.s_abre
              }}
            </option>
          </select>
          <input v-model="form.num_kardex.$value" placeholder="N° Kardex" type="number"
                 class="w-full mx-2 input input-primary">
        </div>
        <div class="text-center my-4">
          <btn-save @click="onSaveAsignationKardex" :disabled="isSubmitAction" :loading="isSubmitAction"/>
        </div>
      </ScrollView>
    </Modal>

   <router-view></router-view>
  </Container>
</template>

<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
import {
  Card,
  Container,
  ContainerTable,
  ListEmpty,
  Options,
  Paginate,
  Skeleton,
  Table,
  TextInputSearch,
  THead,
  Title,
  ToolTip,
  Modal,
  Galery, BtnSave, ScrollView
} from "@/components";
import {debounce} from "../../../utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";
import Button from "primevue/button";
import {useTramiteStore} from "@/store/tramite";
import {useCloseModal, useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";

import type {IUploadFile} from "@/models/components/upload-file.interface";
import {notify} from "@kyvg/vue3-notification";
import {useKardexExternalStore} from "@/store/external/kardex.external";
import DocumentAttachSharp from "@vicons/ionicons5/DocumentAttachSharp";
import DocumentTextSharp from "@vicons/ionicons5/DocumentTextSharp";
import {defineForm, field, isValidForm} from "vue-yup-form";
import * as Yup from "yup";
import {validateMaxDigits} from "@/utils/Regexs";
import {useRouter} from "vue-router";

const {isSubmitAction, recordsKardex} = toRefs(useKardexExternalStore())
const {saveAsignationKardex, listKardexActives} = useKardexExternalStore()
const {search, pagination, isLoading, TramiteResults} = toRefs(useTramiteStore());
const {listTramite, cleanPagination} = useTramiteStore();

const idModalAsignKardex = useGenerateKeyRandom()


const fileSelected = ref<IUploadFile[]>([]);
const idSelected = ref<number>(0)
const galeryComponentRef = ref<any>(null);
const router = useRouter()

const form = defineForm({
  cod_tramite: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  num_kardex: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => Number.isNaN(value) ? null : value)
          .test("maxDigits", "Máximo de 15 dígitos permitidos.", value => {
            return validateMaxDigits(value, 15)
          })
          .positive("Numero no Válido")
          .nullable()
  )
});


const filter = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  cleanPagination()
  await listTramite();
}

const onSelectedRow = async(item) => {

  if (item.detalle_kardex == null) {
    notify({
      title: 'Aún no se ha asignado un kárdex.',
      type: "warn",
    });
  } else {
    await router.push({
      name: configProtocolar._TRAMITE_.detalle.name,
      params: {
        id: item.id,
      }
    })

  }
}

const onAsignationKardex = (cod: number) => {
  idSelected.value = cod
  useOpenModal(idModalAsignKardex)
}

const viewUnassignedKarkex = async(item) => {
    await router.push({
        name: configProtocolar._TRAMITE_.detalleSK.name,
        params: {
            id: item.id,
        }
    })
}


const onSaveAsignationKardex = async () => {
  if (isValidForm(form)) {
    try {
      isSubmitAction.value = true
      const {status, message} = await saveAsignationKardex({
        cod_client: idSelected.value,
        codigo: form.cod_tramite.$value,
        number_kardex: form.num_kardex.$value,
      })
      if (status) {
        isSubmitAction.value = false
        notify({
          title: message,
          type: 'success'
        })
        listTramite()
        useCloseModal()
        cleanFormAssign()
      }
    } catch (e) {
      isSubmitAction.value = false
    } finally {
      isSubmitAction.value = false
    }
  }

}

const cleanFormAssign = async () => {
  form.num_kardex.$value = null
  form.cod_tramite.$value = ""
}


onMounted(() => {
  listKardexActives()
  if (!TramiteResults.value.length) {
    listTramite();
  }
});
</script>



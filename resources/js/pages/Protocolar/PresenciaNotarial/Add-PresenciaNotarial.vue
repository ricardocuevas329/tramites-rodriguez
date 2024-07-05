<template>
  <Container>
    <div>
      <Card>


        <Title>
          <button class="btn btn-xs btn-circle right-0" @click="$router.back()">
            <i class="pi pi-arrow-left"></i>
          </button>
          Nueva Presencia Notarial
        </Title>
        <div class="divider"></div>
        <VirtualScrollForm height="53vh">
          <div class="grid md:grid-cols-3 grid-cols-1">
            <DropwdownSelect
                :placeholder="modelSolicitante?modelSolicitante:'Buscar...'"
                label="nombre_compuesto"
                label2="s_num_doc"
                @keyup="filterSolicitante"
                @onSelecteValue="onSelectedSolicitante"
                v-model="modelSolicitante"
                title="Solicitante"
                :data="ClientsCompanies"
                @keyup.enter="filterSolicitante"
                class="w-full"
                @onClear="onClearSolicitante"
                :errorMessage="form.solicitante.$error?.message"
            />
            <DropwdownSelect
                :placeholder="modelEmpresa?modelEmpresa:'Buscar...'"
                label="nombre_compuesto"
                label2="s_num_doc"
                @keyup="filterEmpresa"
                @onSelecteValue="onSelectedEmpresa"
                v-model="modelEmpresa"
                title="Empresa"
                :data="Empresas"
                @keyup.enter="filterEmpresa"
                class="w-full"
                @onClear="onClearEmpresa"
                :errorMessage="form.empresa.$error?.message"
            />
            <DropwdownSelect
                :placeholder="modelContacto?modelContacto:'Buscar...'"
                label="nombre_compuesto"
                label2="s_num_doc"
                @keyup="filterContacto"
                @onSelecteValue="onSelectedContacto"
                v-model="modelContacto"
                title="Contacto"
                :data="ClientsCompanies"
                @keyup.enter="filterContacto"
                class="w-full"
                @onClear="onClearContacto"
                :errorMessage="form.contacto.$error?.message"
            />

          </div>
          <Center class="gap-1">
            <button @click="onPushFormDetail" class=" btn btn-xs btn-success text-white"
                    :disabled="!isValidForm(detail_form)">+ Agregar a la Lista ({{ details.length }})
            </button>
            <button @click="isChangetab=true" class=" btn btn-xs btn-success text-white" :disabled="isChangetab"><i
                class="pi pi-arrow-left"/></button>
            <button @click="isChangetab=false" class=" btn btn-xs btn-success text-white"
                    :disabled="!isChangetab||!details.length">Ver Lista
            </button>
          </Center>
          <div v-if="isChangetab">
            <div class="grid md:grid-cols-2 grid-cols-1">
              <DropwdownSelect
                  :placeholder="modelServicio?modelServicio:'Buscar...'"
                  label="s_nombre"
                  @keyup="filterServicio"
                  @onSelecteValue="onSelectedServicio"
                  v-model="modelServicio"
                  title="Servicio"
                  :data="ServicesResults"
                  @keyup.enter="filterServicio"
                  class="w-full"
                  compact
                  @onClear="onClearServicio"
                  :errorMessage="detail_form.servicio.$error?.message"
              />

              <TextInput v-model="detail_form.descripcion.$value"
                         :errorMessage="detail_form.descripcion.$error?.message"
                         label="Descripcion"/>
            </div>
            <div class="grid md:grid-cols-2 grid-cols-1">
              <TextInput v-model="detail_form.fecha.$value" :errorMessage="detail_form.fecha.$error?.message"
                         type="date"
                         label="Fecha"/>
              <div class="grid md:grid-cols-2 grid-cols-1">
                <TextInput type="time" v-model="detail_form.hora_inicio.$value"
                           :errorMessage="detail_form.hora_inicio.$error?.message" label="Hora Inicio"/>
                <TextInput type="time" v-model="detail_form.hora_fin.$value"
                           :errorMessage="detail_form.hora_fin.$error?.message" label="Hora Fin"/>
              </div>
            </div>
            <DropwdownSelect
                :placeholder="modelProcurador?modelProcurador:'Buscar...'"
                label="nombre_compuesto"
                label2="s_numero"
                @keyup="filterProcurador"
                @onSelecteValue="onSelectedProcurador"
                v-model="modelProcurador"
                title="Procurador"
                :data="Personales"
                @keyup.enter="filterProcurador"
                class="w-full"
                @onClear="onClearProcurador"
                :errorMessage="detail_form.procurador.$error?.message"
            />
          </div>
          <div v-else>
            <Table v-if="details.length">
              <THead>
              <tr>
                <td>Servicio</td>
                <td>Descripcion</td>
                <td>Fecha</td>
                <td>Hora Inicio</td>
                <td>Hora Fin</td>
                <td>Procurador</td>
                <td>Accion</td>
              </tr>
              </THead>
              <tbody>
              <tr v-for="(item, k) in details" :key="k">
                <td>{{ item?.servicio_name }}</td>
                <td>{{ item?.descripcion }}</td>
                <td>{{ item?.fecha }}</td>
                <td>{{ item?.hora_inicio }}</td>
                <td>{{ item?.hora_fin }}</td>
                <td>{{ item?.procurador_name }}</td>
                <td>
                  <button @click="details.splice(1, k)" class="btn btn-xs btn-circle btn-error text-white"><i
                      class="pi pi-trash"></i></button>
                </td>
              </tr>
              </tbody>
            </Table>
          </div>


        </VirtualScrollForm>

        <div class="text-center my-4">
          <btn-save @click="onSave" :disabled="isSubmitAction" :loading="isSubmitAction"/>
        </div>
      </Card>
    </div>


    <router-view></router-view>
  </Container>
</template>

<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
import {
  Card,
  Container,
  TextInput,
  Title,
  BtnSave,
  VirtualScrollForm, DropwdownSelect,
  Center,
  Table,
  THead
} from "@/components";
import Button from "primevue/button";
import {notify} from "@kyvg/vue3-notification";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as Yup from "yup";
import {usePresenciaNotarialStore} from "@/store/presencia-notarial";
import {debounce} from "@/utils/debounce";
import {useClientCompanyStore} from "@/store/client-company";
import type {Cliente, Empresa, Servicio, User} from "@/models/types";
import {useEmpresaStore} from "@/store/empresa";
import {usePersonalStore} from "@/store/personal";
import {useServicioStore} from "@/store/servicio";
import {useRouter} from "vue-router";
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";


const {savePresenciaNotarial} = usePresenciaNotarialStore()
const {listarPresenciaNotarial} = usePresenciaNotarialStore();
const {searchClientCompany} = useClientCompanyStore()
const {ClientsCompanies} = toRefs(useClientCompanyStore())
const {searchEmpresa} = useEmpresaStore()
const {Empresas} = toRefs(useEmpresaStore())
const {searchPersonal} = usePersonalStore()
const {Personales} = toRefs(usePersonalStore())
const {searchServicesActivesAllFast} = useServicioStore()
const {ServicesResults} = toRefs(useServicioStore())

const isChangetab = ref<boolean>(true);
const isSubmitAction = ref<boolean>(false);
const modelSolicitante = ref<string>('');
const modelEmpresa = ref<string>('');
const modelContacto = ref<string>('');
const modelServicio = ref<string>('');
const modelProcurador = ref<string>('');
const details = ref<any[]>([]);

const router = useRouter()

const form = defineForm({
  solicitante: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  empresa: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  contacto: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
});

const detail_form = defineForm({
  servicio: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  procurador: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  descripcion: field<string>(
      "",
      Yup.string()
          .max(100, "máximo 100 caracteres")
          .required("es requerido")
          .nullable()
  ),
  fecha: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  hora_inicio: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  hora_fin: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
});


const onSave = async () => {
  if (isValidForm(form)) {
    if (!details.value.length) {
      return notify({
        title: "Agregado elementos a la Lista",
        type: 'warn'
      })
    }


    try {
      isSubmitAction.value = true
      let payload = {
        ...toObject(form),
        details: details.value
      }
      const {status, message} = await savePresenciaNotarial(payload)
      if (status) {
        isSubmitAction.value = false
        notify({
          title: message,
          type: 'success'
        })
        cleanForm()
        await listarPresenciaNotarial()
        await router.push({
          name: configProtocolar._PRESENCIA_NOTARIALES_.listar.name
        })
      }
    } catch (e) {
      isSubmitAction.value = false
    } finally {
      isSubmitAction.value = false
    }
  }

}

const onPushFormDetail = () => {
  let payload = {
    solicitante_name: modelSolicitante.value,
    empresa_name: modelEmpresa.value,
    contacto_name: modelContacto.value,
    servicio_name: modelServicio.value,
    procurador_name: modelProcurador.value,
    ...toObject(detail_form)
  }
  details.value.push(payload)
  cleanFormDetail()
  notify({
    title: "Agregado a la Lista Correctamente",
    type: 'success'
  })
}

const cleanForm = () => {
  form.solicitante.$value = ''
  form.empresa.$value = ''
  form.contacto.$value = ''
}

const cleanFormDetail = () => {
  detail_form.servicio.$value = ''
  detail_form.procurador.$value = ''
  detail_form.descripcion.$value = ''
  detail_form.fecha.$value = ''
  detail_form.hora_inicio.$value = ''
  detail_form.hora_fin.$value = ''
  modelServicio.value = ''
  modelProcurador.value = ''
}

const filterSolicitante = debounce(() => {
  return searchClientCompany(modelSolicitante.value);
}, 500);

const onSelectedSolicitante = (payload: Cliente | Empresa) => {
  form.solicitante.$value = payload.s_codigo
  modelSolicitante.value = payload.nombre_compuesto
}

const onClearSolicitante = (success: boolean) => {
  form.solicitante.$value = ''
  modelSolicitante.value = ''
}

const filterEmpresa = debounce(() => {
  return searchEmpresa(modelEmpresa.value);
}, 500);

const onSelectedEmpresa = (payload: Empresa) => {
  form.empresa.$value = payload.s_codigo
  modelEmpresa.value = payload.nombre_compuesto
}

const onClearEmpresa = (success: boolean) => {
  form.empresa.$value = ''
  modelEmpresa.value = ''
}

const filterContacto = debounce(() => {
  return searchClientCompany(modelContacto.value);
}, 500);

const onSelectedContacto = (payload: User) => {
  form.contacto.$value = payload.s_codigo
  modelContacto.value = payload.nombre_compuesto
}

const onClearContacto = (success: boolean) => {
  form.contacto.$value = ''
  modelContacto.value = ''
}

const filterServicio = debounce(() => {
  return searchServicesActivesAllFast(modelServicio.value);
}, 500);

const onSelectedServicio = (payload: Servicio) => {
  detail_form.servicio.$value = payload.s_codigo
  modelServicio.value = payload.s_nombre ?? ''

}

const onClearServicio = () => {
  detail_form.servicio.$value = ''
  modelServicio.value = ''
}

const filterProcurador = debounce(() => {
  return searchPersonal(modelProcurador.value);
}, 500);

const onSelectedProcurador = (payload: User) => {
  detail_form.procurador.$value = payload.s_codigo
  modelProcurador.value = payload.nombre_compuesto
}

const onClearProcurador = () => {
  detail_form.procurador.$value = ''
  modelProcurador.value = ''
}


onMounted(() => {

});
</script>

<style scoped>

</style>

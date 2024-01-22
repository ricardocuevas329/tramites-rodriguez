<template>
  <ModalRouterPage :is-component="useComponent">
    <Content>
      <Head>
        <template v-slot:start>
          <BtnBack @click="router.back()"/>
        </template>
        <template v-slot:center>
          <TitleTable>PROGRAMAR ENVIO</TitleTable>
        </template>
      </Head>
      <ScrollView>
        <div >
          <TextInput
              type="date"
              label="Fecha de programación"
              v-model="form.d_fecha_programacion.$value"
              :error-message="form.d_fecha_programacion.$error?.message"
              :min="todayDefault"
          />

          <LabelInput> Motorizado:<LabelError> {{form.s_motorizado.$error?.message}} </LabelError>  </LabelInput>
            <DropwdownSelect
                id="programacion.motorizados"
                placeholder="Filtrar Personal"
                label="nombre_compuesto"
                label2="s_numero"
                @keyup="filterMotorizado"
                @onSelecteValue="onSelecteValue"
                v-model="searchUserMotorizado"
                :data="Personales"
                @keyup.enter="onFocusInput('s_observacion')"
                @onClear="onClearMotorizado"

             >
              <template v-slot:startIcon>  <Motorbike class="text-success" /></template>
            </DropwdownSelect>

          <TextArea
              type="email"
              label="Observación"
              v-model="form.s_observacion.$value"
              :error-message="form.s_observacion.$error?.message"
          />
        </div>
      </ScrollView>
      <Center>
        <BtnSave  :loading="isSubmit"  :disabled="!isValidForm(form) || isSubmit" @click="onSubmit(toObject(form))"/>
      </Center>
    </Content>
  </ModalRouterPage>
</template>

<script setup lang="ts">
import {useRoute, useRouter} from "vue-router";
import {notify} from "@kyvg/vue3-notification";
import {
  BtnBack,
  BtnSave,
  Center,
  Content,
  DropwdownSelect,
  Head,
  LabelInput,
  ModalRouterPage,
  ScrollView,
  TextArea,
  TextInput,
  TitleTable
} from "../../../components";
import {onMounted, ref, toRefs} from "vue";
import type {Carta, User} from "@/models/types";
import {configExtraProtocolar} from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import {useCartaStore} from "../../../store/carta";
import {debounce} from "@/utils/debounce.js";
import {useInputsEvents} from "../../../hooks/useInputsEvents";
import {defineForm, field, toObject, isValidForm} from "vue-yup-form";
import * as Yup from "yup";
import {useDiligenciaCartaStore} from "../../../store/diligencia-carta";
import type {IDiligenciaProgramada} from "./Interfaces/carta.interface";
import {usePersonalStore} from "@/store/personal";
import LabelError from "@/components/LabelError.vue";
import Motorbike from "vue-material-design-icons/Motorbike.vue";
import {useDate} from "@/hooks/useDates";

const route = useRoute();
const router = useRouter();
const {onFocusInput} = useInputsEvents();
const isSubmit = ref<boolean>(false);
const id = route.params.id.toString();
const formValues = ref<Carta>();
const searchUserMotorizado = ref<string>();
const {listarCarta, findCartaById} = useCartaStore();
const {searchPersonal} = usePersonalStore()
const {Personales} = toRefs(usePersonalStore())
const {saveDiligenciaProgramada, listarDiligencia} = useDiligenciaCartaStore();
const { todayDefault } = useDate();


const {redirect} = defineProps({
  useComponent: {
    type: Boolean,
    default: false,
    required: false,
  },
  redirect: {
    type: Boolean,
    default: true,
    required: false,
  },
});

const filterMotorizado = debounce(() => {
  return searchPersonal(searchUserMotorizado.value);
}, 500);

const onSelecteValue = (e: User) => {
  form.s_motorizado.$value = e.s_codigo;
  searchUserMotorizado.value = e.nombre_compuesto
};

const onClearMotorizado = (success: boolean) => {
  if(success){
    form.s_motorizado.$value = "";
    searchUserMotorizado.value = ""
  }

}

const getCarta = async () => {
  try {
    const {status, Carta} = await findCartaById(id);
    if (status) {
      formValues.value = Carta;
      form.s_num_carta.$value = Carta.s_numcarta;
    }
  } catch (error) {
    await router.push(configExtraProtocolar._CARTA_.listar.path);
  }
};

const form = defineForm({
  d_fecha_programacion: field<string | null | undefined>(
      "",
      Yup.string().required("es requerido")
  ),
  s_num_carta: field<number | null | undefined>(formValues.value?.s_numcarta),
  s_motorizado: field<string | null>("", Yup.string().required("es requerido")),
  s_observacion: field<string | null>(
      "",
      Yup.string().required("es requerido").max(250, "máximo 250 caracteres")
  ),
});

const onSubmit = async (form: IDiligenciaProgramada) => {
  if(!isValidForm(form)) return
  try {
    isSubmit.value = true;
    const {  message, status } = await saveDiligenciaProgramada(form);
      if (status) {
        await router.push(configExtraProtocolar._CARTA_.listar.path);
        notify({
          title: "Exito",
          text: message,
        });
        await listarCarta();
        await listarDiligencia();
      }
  } catch (error) {
  } finally {
    setTimeout(() => {
      isSubmit.value = false;
    }, 1600);
  }
};

onMounted(() => {
  getCarta();
});
</script>

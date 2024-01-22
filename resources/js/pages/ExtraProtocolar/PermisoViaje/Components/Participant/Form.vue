<template>
  <Content>
    <Head>
      <template v-slot:start>
        <BtnBack @click="closeParticipant()"/>
      </template>
      <template v-slot:center>
        <TitleTable
        >{{
            formValues?.index >= 0 ? "EDITAR" : "NUEVO"
          }}
          PARTICIPANTE
        </TitleTable
        >
      </template>
    </Head>
    <ScrollView>
      <InputSelect
          :items="ParticipanteItems"
          label="Participa Como"
          v-model="form.i_condicion.$value"
          :validate-error="isSubmit"
          @input="onFocusInput('participant.id_tipo_documento')"
          id="participant.i_condicion"
          :error-message="form.i_condicion.$error?.message"
          ref="condicionRef"
      />

      <div class="grid grid-cols-1 md:grid-cols-2">
        <InputSelect
            :items="TipoDocumentsClients"
            label="Documento"
            v-model="form.cliente.id_tipo_documento.$value"
            :validate-error="isSubmit"
            :error-message="form.cliente.id_tipo_documento.$error?.message"
            label-data="s_abrev"
            value-data="s_codigo"
            id="participant.id_tipo_documento"
            @input="onFocusInput('participant.s_num_doc')"
        />

       <Row>
         <TextInput
             label="Numero"
             v-model="form.cliente.s_num_doc.$value"
             id="participant.s_num_doc"
             :validate-error="isSubmit"
             :error-message="form.cliente.s_num_doc.$error?.message"
             @keyup.enter="onFocusInput('participant.s_paterno')"
         />
         <ToolTip text="Buscar Participante">
           <button :disabled="isSubmitFindByDocument" @click="onFindByDocument()" class="btn btn-sm btn-circle mt-6 ">
             <MagnifyingGlassIcon  />
           </button>
         </ToolTip>
       </Row>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2">
        <TextInput
            label="Apellido Paterno"
            autofocus
            v-model="form.cliente.s_paterno.$value"
            :validate-error="isSubmit"
            :error-message="form.cliente.s_paterno.$error?.message"
            id="participant.s_paterno"
            @keyup.enter="onFocusInput('participant.s_materno')"
        />

        <TextInput
            label="Apellido Materno"
            v-model="form.cliente.s_materno.$value"
            :validate-error="isSubmit"
            id="participant.s_materno"
            @keyup.enter="onFocusInput('participant.s_nombres')"
            :error-message="form.cliente.s_materno.$error?.message"
        />
      </div>

      <TextInput
          label="Nombres"
          id="participant.s_nombres"
          v-model="form.cliente.s_nombres.$value"
          :validate-error="isSubmit"
          @keyup.enter="onFocusInput('participant.d_fecha_nac')"
          :error-message="form.cliente.s_nombres.$error?.message"
      />

      <div  class="grid grid-cols-1 md:grid-cols-2">
        <TextInput
            type="date"
            :max="maxDate"
            @change="onCalculateAge()"
            label="Fecha de Nacimiento"
            v-model="form.cliente.d_fecha_nac.$value"
            :validate-error="isSubmit"
            id="participant.d_fecha_nac"
            @keyup.enter="onFocusInput('participant.s_edad')"
            :error-message="form.cliente.d_fecha_nac.$error?.message"
        />

        <TextInput
            type="number"
            label="Edad"
            disabled
            v-model="form.s_edad.$value"
            :validate-error="isSubmit"
            :error-message="form.s_edad.$error?.message"
            id="participant.s_edad"
            @keyup.enter="onFocusInput('participant.s_sexo')"
            ref="edadRef"
        />
      </div>
      <div class="grid grid-cols-1 md:grid-cols-2">
        <InputSelect
            :items="SexoItems"
            v-model="form.cliente.s_sexo.$value"
            @input="onFocusInput('participant.s_estado_civil')"
            :validate-error="isSubmit"
            label="Sexo"
            id="participant.s_sexo"
            :error-message="form.cliente.s_sexo.$error?.message"
        />
        <InputSelect
            :items="EstadoCivilItems"
            label="Estado Civil"
            v-model="form.cliente.s_estado_civil.$value"
            :validate-error="isSubmit"
            id="participant.s_estado_civil"
            @input="onFocusInput('participant.s_nacionalidad')"
            :error-message="form.cliente.s_estado_civil.$error?.message"
        />
      </div>

      <InputSelect
          :items="Nacionalidades"
          label="Nacionalidad"
          v-model="form.cliente.s_nacionalidad.$value"
          :validate-error="isSubmit"
          id="participant.s_nacionalidad"
          @input="onFocusInput('participant.distrito')"
          :error-message="form.cliente.s_nacionalidad.$error?.message"
          label-data="s_gentilicio"
          value-data="s_codigo"
      />

      <Center v-if="formValues?.participant?.i_codigo">
        <MapPinIcon class="text-primary-500 w-5"/>
        <span class="text-xs">
                    {{ SelectUbigeo?.distrito }} -
                    {{ SelectUbigeo?.provincia }} -
                    {{ SelectUbigeo?.departamento }}
                </span>
      </Center>

      <DropwdownSelect
          placeholder="Filtrar Localidad"
          label="distrito"
          label2="provincia"
          label3="departamento"
          @keyup="filterUbigeos"
          id="participant.distrito"
          @keyup.enter="onFocusInput('participant.s_direccion')"
          @onSelecteValue="onSelecteValue"
          v-model="searchUbigeos"
          :data="Ubigeos"
      />

      <TextInput
          label="Direccion"
          id="participant.s_direccion"
          @keyup.enter="onFocusInput('participant.i_firma')"
          v-model="form.cliente.s_direccion.$value"
          :validate-error="isSubmit"
          :error-message="form.cliente.s_direccion.$error?.message"
      />

      <div  v-if="isUnderAge" class="flex justify-center items-center py-2">
        <CheckBox
            id="participant.i_firma"
            v-model="form.i_firma.$value"
            name="participant.i_firma"
            @change.native="onFocusInput('participant.s_partida')"
        >¿CON FIRMA?
        </CheckBox
        >
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2" v-if="isRepresentant">
        <TextInput
            label="N° de Partida"
            v-model="form.s_partida.$value"
            :validate-error="isSubmit"
            :error-message="form.s_partida.$error?.message"
            id="participant.s_partida"
            @keyup.enter="onFocusInput('participant.s_sede_reg')"
        />

        <InputSelect
            :items="ZonaRegistrales"
            label="Sede Registral"
            v-model="form.s_sede_reg.$value"
            label-data="s_nombre"
            value-data="s_codigo"
            :validate-error="isSubmit"
            id="participant.s_sede_reg"
            :error-message="form.s_sede_reg.$error?.message"
        />
      </div>
    </ScrollView>

    <Center>
      <BtnSave @click="onSubmit"/>
    </Center>
  </Content>
</template>
<script setup lang="ts">
import {
  BtnBack,
  BtnSave,
  Center,
  CheckBox,
  Content,
  DropwdownSelect,
  Head,
  InputSelect,
  Row,
  ScrollView,
  TextInput,
  TitleTable,
} from "@/components";
import * as Yup from "yup";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import {RegExps} from "@/utils/Regexs";
import {computed, onMounted, type PropType, ref, toRefs, watchEffect, watch} from "vue";
import {debounce} from "../../../../../utils/debounce.js";
import type {Ubigeo} from "@/models/ubigeo";
import {MapPinIcon, MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import {useZonaRegistralStore} from "@/store/zona-registral";
import {useNacionalidadStore} from "@/store/nacionalidad";
import {useTipoDocumentoStore} from "@/store/tipo-documento";
import {useUbigeoStore} from "@/store/ubigeo";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import {useCalculateAge, useDate} from "@/hooks/useDates";
import {SexoItems} from "@/services/SexoService";
import {ParticipanteItems, VALID_PARTICPANT_REPRESENTANTE,} from "@/services/ParticipanteService";
import {EstadoCivilItems} from "@/services/EstadoCivilService";
import type {IParamsDeleteParticipant} from '../../Interfaces/typevieaje.interface';
import {useClienteStore} from "@/store/cliente";
import type {Cliente} from "@/models/types";
import ToolTip from "@/components/ToolTip.vue";
import {useCloseModal} from "@/hooks/useUtils";

const {TipoDocumentsClients } = toRefs(useTipoDocumentoStore());
const {ZonaRegistrales} = toRefs(useZonaRegistralStore());
const {Nacionalidades} = toRefs(useNacionalidadStore());
const { findClienteByDocument } = useClienteStore()
const {Ubigeos} = toRefs(useUbigeoStore());
const {searchUbigeo} = useUbigeoStore();
const {onFocusInput} = useInputsEvents();

const edadRef = ref();
const condicionRef = ref();
const maxDate = ref<string>("");
const searchUbigeos = ref<string>();
const SelectUbigeo = ref<Ubigeo | undefined>(undefined);
const isSubmit = ref<boolean>(false);
const isSubmitFindByDocument = ref<boolean>(false);
const {currentDateMax} = useDate();
const yearMax = 5;

const props = defineProps({
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<IParamsDeleteParticipant>,
  },
});

const {formValues} = toRefs(props);

const isRepresentant = computed(() => {
  return (
      parseInt(condicionRef.value?.modelValue) ===
      VALID_PARTICPANT_REPRESENTANTE
  );
});


const isUnderAge = computed(() => {
    return edadRef.value?.modelValue && parseInt(edadRef.value?.modelValue) >=18 ? true : false;
});

const s_sede_reg_validator = field<string | null | undefined>("", () => {
  return isRepresentant.value
      ? Yup.string()
          .required("es requerido")
          .max(50, "máximo 50 caracteres")
          .nullable()
      : Yup.string().max(50, "máximo 50 caracteres").nullable();
});

const s_partida_validator = field<string | null | undefined>("", () => {
  return isRepresentant.value
      ? Yup.string()
          .required("es requerido")
          .max(50, "máximo 50 caracteres")
          .nullable()
      : Yup.string().max(50, "máximo 50 caracteres").nullable();
});


const id_tipo_documento_validator = field<string | null | undefined>("", () => {
    return isUnderAge.value
        ?  Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres").nullable()
        : Yup.string().max(50, "máximo 50 caracteres").nullable();
});

const id_s_num_doc_validator = field<string | null | undefined>("", () => {
    return isUnderAge.value
        ? Yup.string()
                .required("es requerido")
                .min(4, "minimo 4")
                .max(30, "máximo 30 caracteres").nullable()
        : Yup.string().max(30, "máximo 30 caracteres").nullable();
});

const s_direccion_validator = field<string | null | undefined>("", () => {
    return isUnderAge.value
        ?  Yup.string()
            .required("es requerido")
            .min(4, "minimo 4")
            .max(150, "máximo 150 caracteres").nullable()
        : Yup.string().max(150, "máximo 150 caracteres").nullable();
});

const s_estado_civil_validator = field<string | null | undefined>("", () => {
    return isUnderAge.value
        ?  Yup.string()
            .required("es requerido")
            .min(4, "minimo 4")
            .max(150, "máximo 150 caracteres").nullable()
        : Yup.string().max(150, "máximo 150 caracteres").nullable();
});

const s_localidad_validator = field<string | null | undefined>("", () => {
    return isUnderAge.value
        ?  Yup.string()
            .required("es requerido")
            .max(100, "máximo 100 caracteres")
        : Yup.string().max(100, "máximo 100 caracteres").nullable();
});

const s_sexo_validator = field<string | null | undefined>("", () => {
    return isUnderAge.value
        ?  Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(10, "máximo 10 caracteres").nullable()
        : Yup.string().max(10, "máximo 10 caracteres").nullable()
});

const form = defineForm({
  i_codigo: field<number | null>(null, Yup.string().nullable()),
  i_firma: field<boolean>(false, Yup.boolean().nullable()),
  s_edad: field<string | null>(
      "",
      Yup.string().required("es requerido").nullable()
  ),
  i_condicion: field<number | null | undefined>(
      null,
      Yup.string().required("es requerido").nullable()
  ),
  s_partida: s_partida_validator,
  s_sede_reg: s_sede_reg_validator,
  cliente: {
    s_codigo: field<string | null | undefined>(
        "", Yup.string().nullable()
    ),
    s_nombres: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Nombre no válido")
            .min(3, "minimo 3")
            .max(50, "máximo 50 caracteres")
    ),
    s_paterno: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .min(3, "minimo 3 caracteres")
            .max(50, "máximo 50 caracteres")
    ),
    s_materno: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .min(3, "minimo 3")
            .max(50, "máximo 50 caracteres")
    ),
    id_tipo_documento: id_tipo_documento_validator,
    s_num_doc: id_s_num_doc_validator,
    s_direccion: s_direccion_validator,
    s_estado_civil: s_estado_civil_validator ,
    s_localidad: s_localidad_validator,
    d_fecha_nac: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .max(100, "máximo 100 caracteres")
            .nullable()
    ),
    s_sexo: s_sexo_validator,
    s_nacionalidad: field<string | null>(
        "",
        Yup.string().required("es requerido").nullable()
    ),
    /*s_correo: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .email("Email inVálido")
            .min(5, "minimo 5")
            .max(100, "máximo 100 caracteres")
    ),*/
  },
});




const emit = defineEmits(["onAddParticipant"]);

const onSubmit = () => {
  isSubmit.value = true;
  onValidateFocus();
  if (isValidForm(form)) {
    emit("onAddParticipant", {index: formValues.value?.index ?? null, participant: toObject(form)});
    closeParticipant();
  }
};


const closeParticipant = () => {
  useCloseModal()
};

const onSelecteValue = (payload: Ubigeo) => {
  form.cliente.s_localidad.$value = payload.s_codigo;
  SelectUbigeo.value = payload;
};

const onCalculateAge = () => {
  if (form.cliente.d_fecha_nac.$value) {
    form.s_edad.$value =
        useCalculateAge(form.cliente.d_fecha_nac.$value) ?? "";
  }
};


const onValidateFocus = () => {
  if (form.i_condicion.$error) {
    return onFocusInput("participant.i_condicion");
  }
  if (form.cliente.id_tipo_documento.$error) {
    return onFocusInput("participant.id_tipo_documento");
  }
  if (form.cliente.s_num_doc.$error) {
    return onFocusInput("participant.s_num_doc");
  }

  if (form.cliente.s_paterno.$error) {
    return onFocusInput("participant.s_paterno");
  }
  if (form.cliente.s_materno.$error) {
    return onFocusInput("participant.s_materno");
  }

  if (form.cliente.s_nombres.$error) {
    return onFocusInput("participant.s_nombres");
  }
  if (form.cliente.d_fecha_nac.$error) {
    return onFocusInput("participant.d_fecha_nac");
  }

  if (form.s_edad.$error) {
    return onFocusInput("participant.s_edad");
  }

  if (form.cliente.s_sexo.$error) {
    return onFocusInput("participant.s_sexo");
  }

  if (form.cliente.s_estado_civil.$error) {
    return onFocusInput("participant.s_estado_civil");
  }
  if (form.cliente.s_nacionalidad.$error) {
    return onFocusInput("participant.s_nacionalidad");
  }
  if (form.cliente.s_localidad.$error) {
    return onFocusInput("participant.distrito");
  }
  if (form.cliente.s_direccion.$error) {
    return onFocusInput("participant.s_direccion");
  }
  if (form.s_partida.$error) {
    return onFocusInput("participant.s_partida");
  }
  if (form.s_partida.$error) {
    return onFocusInput("participant.s_partida");
  }
  if (form.s_sede_reg.$error) {
    return onFocusInput("participant.s_sede_reg");
  }

  if (form.cliente.s_direccion.$error) {
    onFocusInput("participant.s_direccion");
  }

 /* if (form.cliente.s_correo.$error) {
    return onFocusInput("participant.s_correo");
  }*/
};

const init = () => {
  if (formValues.value?.participant) {
    let participantPayload = formValues.value.participant
    form.i_codigo.$value = participantPayload?.i_codigo ?? 0
    form.i_firma.$value = !!participantPayload.i_firma;
    form.s_edad.$value = participantPayload.s_edad;
    form.i_condicion.$value = participantPayload.i_condicion;
    form.s_partida.$value = participantPayload.s_partida;
    form.s_sede_reg.$value = participantPayload.s_sede_reg;
    setClienteInfo(participantPayload.cliente)

    let ubigeo = {
      departamento: participantPayload.cliente.ubigeo?.departamento,
      distrito: participantPayload.cliente.ubigeo?.distrito,
      provincia: participantPayload.cliente.ubigeo?.provincia,
      s_codigo: participantPayload.cliente.ubigeo?.s_codigo,
      s_distrito: participantPayload.cliente.ubigeo?.distrito,
    };
    SelectUbigeo.value = ubigeo;
  }
};

const setClienteInfo = (payload:Cliente, ignoreDocument: boolean = false) => {
  form.cliente.s_codigo.$value = payload.s_codigo ?? 0
  form.cliente.d_fecha_nac.$value = payload.d_fecha_nac;
  form.cliente.s_nombres.$value = payload.s_nombres;
  form.cliente.s_paterno.$value = payload.s_paterno;
  form.cliente.s_materno.$value = payload.s_materno;
  if(!ignoreDocument){
    form.cliente.id_tipo_documento.$value = payload.id_tipo_documento;
    form.cliente.s_num_doc.$value = payload.s_num_doc ?? '';
  }
  form.cliente.s_sexo.$value = payload.s_sexo;
  form.cliente.s_estado_civil.$value =
      payload.s_estado_civil;
  form.cliente.s_nacionalidad.$value =
      payload.s_nacionalidad;
  form.cliente.s_localidad.$value = payload.s_localidad;
  form.cliente.s_direccion.$value = payload.s_direccion;
  onCalculateAge();
}

const onFindByDocument = async() => {
  let id_doc = form.cliente.id_tipo_documento.$value
  let num_doc = form.cliente.s_num_doc.$value
  if(id_doc && num_doc){

    try {
      isSubmitFindByDocument.value = true
      const { status, Cliente, message } = await findClienteByDocument(id_doc, num_doc)
      if(status){
        setClienteInfo(Cliente)
      }
    } catch (e) {
      setClienteInfo({}, true)
    } finally {
      setTimeout(()=>{
        isSubmitFindByDocument.value = false
      },1300)
    }
  }

}

const filterUbigeos = debounce(() => {
  return searchUbigeo(searchUbigeos.value);
}, 500);

onMounted(() => {
    watch(formValues, (newFormValues) => {
        formValues.value = newFormValues
        init()
    });
  let maxDateYear = currentDateMax(yearMax);
  maxDate.value = maxDateYear;
  init();
});

</script>

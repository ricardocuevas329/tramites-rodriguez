<template>
  <Container>
    <Card>
      <div class="flex">
        <BtnBack @click="router.push(configExtraProtocolar._DILIGENCIA_CARTA_.listar.path)"/>
        <TitleTable class="mt-2 mx-2">CIRCUNSTANCIAS DE DILIGENCIA DE CARTAS NOTARIALES</TitleTable>
      </div>
      <ScrollView>

        <div class="flex">
          <span class="text-xs">Diligenciado por:</span> <div class="badge badge-sm w-full truncate badge-neutral">{{ motorizado }}</div>

        </div>
        <br>
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-3 gap-2">
          <TextInputNumber disabled
                           label="Nº Carta Notarial"
                           v-model="form.s_num_carta.$value"
                           id="diligencia.carta.s_num_carta"
                           :validate-error="isSubmit"
                           :error-message="form.s_num_carta.$error?.message"
                           @keyup.enter="onFocusInput('diligencia.carta.s_recibido_dni')"
          />
          <TextInput
              label="DNI"
              v-model="form.s_recibido_dni.$value"
              id="diligencia.carta.s_recibido_dni"
              :validate-error="isSubmit"
              :error-message="form.s_recibido_dni.$error?.message"
              @keyup.enter="onFocusInput('diligencia.carta.s_recibido_por')"
          />
          <TextInput
              label="Recibido por"
              v-model="form.s_recibido_por.$value"
              id="diligencia.carta.s_recibido_por"
              :validate-error="isSubmit"
              :error-message="form.s_recibido_por.$error?.message"
              @keyup.enter="onFocusInput('diligencia.carta.s_relacion_destinatario')"
          />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2">
          <TextInput
              label="Relacion con el destinatario"
              v-model="form.s_relacion_destinatario.$value"
              id="diligencia.carta.s_relacion_destinatario"
              :validate-error="isSubmit"
              :error-message="form.s_relacion_destinatario.$error?.message"
              @keyup.enter="onFocusInput('diligencia.carta.s_pisos')"
          />
          <TextInputNumber
              label="Pisos"
              v-model="form.s_pisos.$value"
              id="diligencia.carta.s_pisos"
              :validate-error="isSubmit"
              :error-message="form.s_pisos.$error?.message"
              @keyup.enter="onFocusInput('diligencia.carta.i_edificio')"
          />
        </div>
        <LabelInput>Inmueble:</LabelInput>
        <div class="grid grid-cols-1  gap-2 pb-4 px-2">
          <ul class=" ">
            <li class="w-full bg-base">
              <div class="flex items-center pl-3">
                <RadioInput
                    name="diligencia.inmueble"
                    value="edificio"
                    v-model="form.inmueble.$value"
                    @change="onFocusInput('diligencia.carta.s_color')"
                    label="Edificio"/>

              </div>
            </li>
            <li class="w-full bg-base">
              <div class="flex items-center pl-3">
                <RadioInput name="diligencia.inmueble"
                            value="casa"
                            v-model="form.inmueble.$value"
                            @change="onFocusInput('diligencia.carta.s_color')"
                            label="Casa"
                />
              </div>

            </li>
            <li class="w-full bg-base">
              <div class="flex items-center pl-3">
                <RadioInput
                    name="diligencia.inmueble"
                    value="buzon"
                    v-model="form.inmueble.$value"
                    @change="onFocusInput('diligencia.carta.s_color')"
                    label="Buzon"
                />

              </div>
            </li>
            <li class="w-full bg-base">
              <div class="flex items-center pl-3">
                <RadioInput
                    name="diligencia.inmueble"
                    value="bajo_puerta"
                    v-model="form.inmueble.$value"
                    @change="onFocusInput('diligencia.carta.s_color')"
                    label="Bajo puerta"
                />

              </div>
            </li>
          </ul>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2">
          <TextInput
              label="Color"
              v-model="form.s_color.$value"
              id="diligencia.carta.s_color"
              :validate-error="isSubmit"
              :error-message="form.s_color.$error?.message"
              @keyup.enter="onFocusInput('diligencia.carta.s_puertas')"
          />
          <TextInput
              label="Puertas"
              v-model="form.s_puertas.$value"
              id="diligencia.carta.s_puertas"
              :validate-error="isSubmit"
              :error-message="form.s_puertas.$error?.message"
              @keyup.enter="onFocusInput('diligencia.carta.s_ventanas')"
          />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-2 gap-2">
          <TextInput
              label="Ventanas"
              v-model="form.s_ventanas.$value"
              id="diligencia.carta.s_ventanas"
              :validate-error="isSubmit"
              :error-message="form.s_ventanas.$error?.message"
              @keyup.enter="onFocusInput('diligencia.carta.s_proyeccion')"
          />
          <TextInput
              label="Proyección"
              v-model="form.s_proyeccion.$value"
              id="diligencia.carta.s_proyeccion"
              :validate-error="isSubmit"
              :error-message="form.s_proyeccion.$error?.message"
              @keyup.enter="onFocusInput('diligencia.carta.s_observacion')"
          />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-1 lg:grid-cols-1 gap-2">
          <TextArea
              label="Observación"
              v-model="form.s_observacion.$value"
              :validate-error="isSubmit"
              :error-message="form.s_observacion.$error?.message"
              id="diligencia.carta.s_observacion"
          />
        </div>
        <div class="relative">
          <LabelError v-if="isSubmit && fotos.length == 0">Es Requerido</LabelError>
          <span ref="refFotos"></span>
          <UploaderFiles
              :files="fotos"
              endPointDelete="/api/permiso-viaje/document/"
              :maxFiles="4"
              maxFileSize="15MB"
              maxTotalFileSize="60MB"
              @getFiles="getFiles"
              accept="image/*"
              label="Arrastra o Agrega las imagenes"
          />
        </div>
      </ScrollView>
      <Center>
        <BtnSave :loading="isSubmitForm" :disabled="isSubmitForm" @click="onSubmit"/>
      </Center>
    </Card>
  </Container>
</template>

<script setup lang="ts">
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as Yup from "yup";
import {useRouter} from "vue-router";
import {notify} from "@kyvg/vue3-notification";
import {onMounted, ref, toRefs, watch} from "vue";
import {
  BtnBack,
  BtnSave,
  Card,
  Center,
  Container,
  LabelError,
  LabelInput,
  ScrollView,
  TextArea,
  TextInput,
  TextInputNumber,
  UploaderFiles,
  TitleTable
} from "../../../components";
import {useCartaStore} from "../../../store/carta";
import type {IUploadFile} from "../../../models/components/upload-file.interface";
import {configExtraProtocolar} from "../../../router/ExtraProtocolar/ExtraProtocolarConfig";
import {useInputsEvents} from "../../../hooks/useInputsEvents";
import {validateMaxDigits} from "../../../utils/Regexs";
import type {IDiligenciaCartaForm} from "../Carta/Interfaces/diligenciaCarta.inteface";
import {useGetPropsRoute} from "@/utils/RoutersUtils";
import RadioInput from "@/components/RadioInput.vue";
import {useDiligenciaCartaStore} from "@/store/diligencia-carta";

const refFotos = ref<HTMLElement>()
const router = useRouter();
const {onFocusInput} = useInputsEvents();
const {isSubmitForm} = toRefs(useCartaStore());
const {listarDiligencia} = useDiligenciaCartaStore()
const {saveCartaDiligencia, listarCarta} = useCartaStore();
const fotos = ref<IUploadFile[]>([]);
const isSubmit = ref<boolean>(false);
const {params_route} = useGetPropsRoute();
const motorizado = ref<string>('');

const form = defineForm({
  s_num_carta: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => (Number.isNaN(value) ? null : value))
          .test("maxDigits", "Máximo de 10 dígitos permitidos.", (value) => {
            return validateMaxDigits(value, 10);
          })
          .positive("Numero no Válido")
          .nullable()
  ),
  s_recibido_por: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .min(3, "Minimo 3 caracteres")
          .max(50, "máximo 50 caracteres")
  ),
  s_recibido_dni: field<string>(
      "",
      Yup.string().required("es requerido").max(20, "máximo 20 caracteres")
  ),
  s_relacion_destinatario: field<string>(
      "",
      Yup.string().required("es requerido").max(50, "máximo 50 caracteres")
  ),
  inmueble: field<string>('', Yup.string().required("es requerido").nullable()),
  s_pisos: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => (Number.isNaN(value) ? null : value))
          .test("maxDigits", "Máximo de 10 dígitos permitidos.", (value) => {
            return validateMaxDigits(value, 10);
          })
          .positive("Numero no Válido")
          .nullable()
  ),
  s_color: field<string>("", Yup.string().required("es requerido").max(50, "máximo 50 caracteres").nullable()),
  s_puertas: field<string>("", Yup.string().required("es requerido").max(50, "máximo 50 caracteres").nullable()),
  s_ventanas: field<string>("", Yup.string().required("es requerido").max(50, "máximo 50 caracteres").nullable()),
  s_proyeccion: field<string>(
      "",
      Yup.string().max(50, "máximo 50 caracteres").nullable()
  ),
  s_observacion: field<string>(
      "",
      Yup.string().max(250, "máximo 250 caracteres").nullable()
  ),
});

const getFiles = (files: IUploadFile[]) => {
  fotos.value = files;
};

const onValidateFocus = () => {
  if (fotos.value.length == 0) {
    setTimeout(() => {
      const inputElement = refFotos.value;
      if (inputElement) {
        inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
      }
    }, 800)
    return
  }
  if (form.s_num_carta.$error) {
    return onFocusInput("diligencia.carta.s_num_carta");
  }
  if (form.s_recibido_dni.$error) {
    return onFocusInput("diligencia.carta.s_recibido_dni");
  }
  if (form.s_recibido_por.$error) {
    return onFocusInput("diligencia.carta.s_recibido_por");
  }

  if (form.s_relacion_destinatario.$error) {
    return onFocusInput("diligencia.carta.s_relacion_destinatario");
  }

  if (form.s_pisos.$error) {
    return onFocusInput("diligencia.carta.s_pisos");
  }
  if (form.s_color.$error) {
    return onFocusInput("diligencia.carta.s_color");
  }
  if (form.s_puertas.$error) {
    return onFocusInput("diligencia.carta.s_puertas");
  }
  if (form.s_ventanas.$error) {
    return onFocusInput("diligencia.carta.s_ventanas");
  }
  if (form.s_proyeccion.$error) {
    return onFocusInput("diligencia.carta.s_proyeccion");
  }
  if (form.s_observacion.$error) {
    return onFocusInput("diligencia.carta.s_observacion");
  }
};

const onSubmit = async () => {
  isSubmit.value = true;
  try {
    onValidateFocus();
    if (isValidForm(form)) {
      if (fotos.value.length === 0) {
        return notify({
          type: "warn",
          title: "Ups!",
          text: "Agrega al menos 1 Foto!",
        });
      }
      isSubmitForm.value = true;
      const formData: IDiligenciaCartaForm = {
        ...toObject(form),
        fotos: fotos.value,
      };
      const {status, message} = await saveCartaDiligencia(formData);
      if (status) {
        notify({
          title: "Exito",
          text: message,
        });
        await listarCarta()
        await listarDiligencia();
        await router.push(configExtraProtocolar._DILIGENCIA_CARTA_.listar.path);
      }
    }
  } catch (error) {
  } finally {
    setTimeout(() => {
      isSubmitForm.value = false;
    }, 1300);
  }
};

onMounted(() => {
  watch(params_route, (newValue, oldValue) => {

    if (newValue?.id_carta && newValue?.motorizado) {
      form.s_num_carta.$value = newValue.id_carta
      motorizado.value = newValue.motorizado
    }
  });

})

</script>

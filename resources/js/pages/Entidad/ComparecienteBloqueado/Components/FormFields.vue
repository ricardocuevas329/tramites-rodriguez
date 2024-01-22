<template>
  <div>
    <ScrollView>
      <InputSelect
        @input="onFocusInput('compareciente.bloqueado.s_numero')"
        :items="Referencias"
        label="Referencia"
        v-model="formValues.s_referencia"
        :validate-error="isSubmit"
        :error-message="form.s_referencia.$error?.message"
        label-data="s_desc"
        value-data="i_codigo"
        id="compareciente.bloqueado.s_referencia"
      />

      <TextInput
        :validate-error="isSubmit"
        @keyup.enter="onFocusInput('compareciente.bloqueado.s_condicion')"
        id="compareciente.bloqueado.s_numero"
        label="Numero"
        v-model="formValues.s_numero"
        :error-message="form.s_numero.$error?.message"
      />

      <InputSelect
        :validate-error="isSubmit"
        id="compareciente.bloqueado.s_condicion"
        :items="Condiciones"
        label="Condicion"
        v-model="formValues.s_condicion"
        :error-message="form.s_condicion.$error?.message"
        @input="onFocusInput('compareciente.bloqueado.s_observacion')"
        label-data="s_desc"
        value-data="i_codigo"
      />

      <TextInput
        :validate-error="isSubmit"
        label="Observacion"
        type="text"
        :maxLength="200"
        v-model="formValues.s_observacion"
        :error-message="form.s_observacion.$error?.message"
        id="compareciente.bloqueado.s_observacion"
        @keyup.enter="onFocusInput('compareciente.bloqueado.uploadfilecomparecientebloqueadofile')"
      />

      <LabelInput>Ruta:  <LabelError v-if="isSubmit && !formValues.s_ruta">agrega un archivo</LabelError> </LabelInput>
      <div>
        <Center v-if="foundFile" class="relative">
          <div
            @click.prevent="onDeleteFile"
            class="absolute bg-red-200 rounded-lg text-red-500 cursor-pointer mx-2 my-1"
          >
            <ToolTip text="eliminar archivo">
              <CloseIcon />
            </ToolTip>
          </div>
        </Center>
        <UploadOnlyFile
          id-focus="compareciente.bloqueado.uploadfilecomparecientebloqueadofile"
          :text="formValues?.s_ruta ? 'Actualizar Archivo' : 'Subir/Arrastrar Archivo'"
          :name="formValues?.file?.name"
          id="comparecientebloqueadofile"
          @onGetImageBase64="onGetImageBase64"
        />
      </div>
    </ScrollView>
    <Center>
      <BtnSave :disabled="disabled" @click="onSubmit" />
    </Center>
  </div>
</template>
<script setup lang="ts">
import {
  BtnSave,
  Center,
  ScrollView,
  TextInput,
  InputSelect,
  UploadOnlyFile,
} from "../../../../components";
import * as Yup from "yup";
import { defineForm, field, isValidForm } from "vue-yup-form";
import { ref, toRefs, watchEffect } from "vue";
import type { PropType } from "vue";
import type { ComparecienteBloqueado, DetalleBloqueado } from "@/models/types";
import { useEstadoStore } from "../../../../store/estado";
import CloseIcon from "vue-material-design-icons/Close.vue";
import { ToolTip, LabelError, LabelInput } from "../../../../components";
import { useInputsEvents } from "@/hooks/useInputsEvents";
import { useGetOnlyFileSelected } from "@/hooks/useUtils";
import type { ICustomComparecienteBloqueado } from "../Interface/compareciente.interface";

const { onFocusInput } = useInputsEvents();
const { Referencias, Condiciones } = toRefs(useEstadoStore());

const isSubmit = ref<boolean>(false);
const fileBase64 = ref<string>("");
const foundFile = ref<boolean>(false);
const nameFile = ref<string>("");

const props = defineProps({
  disabled: {
    required: true,
    type: Boolean,
    default: false,
  },
  formValues: {
    default: {},
    require: true,
    type: Object as PropType<ICustomComparecienteBloqueado>,
  },
});

const { formValues } = toRefs(props);
const emit = defineEmits(["onSubmit", "onDeleteFile"]);

const form = defineForm({
  s_referencia: field<string | null | undefined>(
    "",
    Yup.string().required("es requerido")
  ),
  s_numero: field<string | null | undefined>(
    "",
    Yup.string().nullable().min(3, "Minimo 3 caracteres").max(70, "máximo 70 caracteres")
  ),
  s_condicion: field<string | null | undefined>(
    "",
    Yup.string().required("es requerido")
  ),
  s_observacion: field<string | null | undefined | unknown>(
    "",
    Yup.string().nullable().max(250, "máximo 250 caracteres")
  ),
  s_ruta: field<string | null>("", Yup.string().nullable()),
  comparecientes: field<DetalleBloqueado[]>([]),
});

const onSubmit = () => {
  isSubmit.value = true;
  onValidateFocus()
  if (!formValues.value.s_ruta) return;
  if (isValidForm(form)) {
    emit("onSubmit", formValues.value);
  }
};

const onGetImageBase64 = async (file: string) => {
    if (file) {
      fileBase64.value = file;
      formValues.value.s_ruta = file;
      formValues.value.file = useGetOnlyFileSelected("comparecientebloqueadofile");
    }
};

const onDeleteFile = () => {
  emit("onDeleteFile");
};

const init = (payload: ComparecienteBloqueado) => {
  foundFile.value = false;
  if (payload) {
    form.s_referencia.$value = payload.s_referencia?.toString();
    form.s_numero.$value = payload.s_numero;
    form.s_condicion.$value = payload.s_condicion?.toString();
    form.s_observacion.$value = payload.s_observacion;
    form.s_ruta.$value = payload.s_ruta;
    form.comparecientes.$value = payload.comparecientes;
    if (payload.s_codigo && payload.s_ruta) {
      let nameruta = payload.s_ruta.split("compareciente-bloqueados/");

      nameFile.value = nameruta ? nameruta[1] : `archivo-${payload.s_codigo}`;
      /**@ts-ignore */
      formValues.value.file = {
        name: nameFile.value,
      };
      foundFile.value = true;
    }
  }
};

const onValidateFocus = () => {
    if (form.s_referencia.$error) {
        return onFocusInput("compareciente.bloqueado.s_referencia");
    }
    if (form.s_numero.$error) {
        return onFocusInput("compareciente.bloqueado.s_numero");
    }
    if (form.s_condicion.$error) {
        return onFocusInput("compareciente.bloqueado.s_condicion");
    }
    if (form.s_ruta.$error) {
        return onFocusInput("compareciente.bloqueado.uploadfilecomparecientebloqueadofile");
    }

};


watchEffect(() => {
  if (formValues?.value) {
    init(formValues.value);
  }
});
</script>

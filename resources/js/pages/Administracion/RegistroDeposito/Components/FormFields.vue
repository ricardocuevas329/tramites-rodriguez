<template>
  <div>
    <div>
      <span class="mx-4 text-xs">Asesor: </span>
      <span class="badge badge-primary badge-md text-xs">{{ user?.nombre_compuesto }}</span>
    </div>
    <ScrollView>
      <div class=" grid grid-cols-1 md:grid-cols-2 ">

        <div class=" grid grid-cols-2   ">

          <InputSelect :items="TipoKardexs"
                       labelData="s_abre"
                       valueData="s_abre"
                       label="Tipo Kardex"
                       id="registro.tipo_kardex"
                       v-model="form.tipo_kardex.$value" :validateError="isSubmit"
                       :error-message="form.tipo_kardex.$error?.message"/>

          <TextInput label="N° Trámite" v-model="form.s_kardex.$value" :validateError="isSubmit"
                     id="registro.deposito.s_kardex"
                     :error-message="form.s_kardex.$error?.message"/>

        </div>

        <InputSelect :items="itemsTipoTramite" label="Tipo"
                     id="registro.deposito.s_tipo"
                     v-model="form.s_tipo.$value" :validateError="isSubmit"
                     :error-message="form.s_tipo.$error?.message"/>

      </div>
      <div class=" grid grid-cols-1 md:grid-cols-2 ">
        <InputSelect @onGetLabel="onGetLabelBank" :items="AllBancos" label="Banco"
                     id="registro.deposito.s_banco"
                     valueData="id_cod" labelData="s_nombre"
                     v-model="form.s_banco.$value" :validateError="isSubmit"
                     :error-message="form.s_banco.$error?.message"/>


        <TextInput type="date" label="Fecha Ope" v-model="form.d_fecha_ope.$value" :validateError="isSubmit"
                   :error-message="form.d_fecha_ope.$error?.message" id="registro.deposito.d_fecha_ope"/>

      </div>
      <div class=" grid grid-cols-1 md:grid-cols-2 ">
        <TextInputNumber label="Numero Ope" v-model="form.s_num_ope.$value" :validateError="isSubmit"
                         :error-message="form.s_num_ope.$error?.message" id="registro.deposito.s_num_ope"/>

        <TextInputNumber label="Monto" v-model="form.i_monto.$value" :validateError="isSubmit"
                         :error-message="form.i_monto.$error?.message" id="registro.deposito.i_monto"/>

      </div>
      <UploaderFiles :files="fotos"
                     endPointDelete="/api/register-deposit/document/" :maxFiles="MAXFILES"
                     maxFileSize="15MB"
                     maxTotalFileSize="60MB"
                     accept="image/*" @getFiles="onGetFiles"
                     label="Arrastra o Agrega tus Imagenes"
                     :key="keyUploaderFiles"
                     @deleteFile="onDeleteFile"
                     @selectFile="onSelectFile"

      />

    </ScrollView>
    <Center>
      <BtnSave :loading="disabled" :disabled="disabled" @click="onSubmit"/>
    </Center>
    <Galery ref="galeryComponentRef"  :showItemNavigators="false"  :files="fileSelected"  />
  </div>
</template>
<script setup lang="ts">

import TextInputNumber from "@/components/TextInputNumber.vue";
import {BtnSave, Center, InputSelect, ScrollView, TextInput, UploaderFiles, Galery} from "@/components";
import * as Yup from "yup";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import {validateMaxDigits} from "../../../../utils/Regexs";
import {onMounted, type PropType, ref, toRefs, watch} from "vue";
import type {RegistroDeposito} from '@/models/types';
import {useSesionStore} from "@/store/sesion";
import {useBancoStore} from "@/store/banco";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {useTipoKardexStore} from "@/store/tipo-kardex";
import {useDate} from "@/hooks/useDates";
import {useGenerateKeyRandom} from "@/hooks/useUtils";
import {useRegistroDepositoStore} from "@/store/registro-deposito";

const itemsTipoTramite = [{id: 'NOTARIAL', label: 'NOTARIAL'}, {id: 'REGISTRAL', label: 'REGISTRAL'}, {id: 'AMBOS', label: 'AMBOS'}]
const MAXFILES = 4
const {user} = toRefs(useSesionStore())
const {AllBancos} = toRefs(useBancoStore())
const {TipoKardexs} = toRefs(useTipoKardexStore())
const {RegistroDepositos} = toRefs(useRegistroDepositoStore());
const {formatDateFR} = useDate()
const fotos = ref<IUploadFile[]>([])
const isSubmit = ref<boolean>(false)
const keyUploaderFiles = ref<string>('')
const galeryComponentRef = ref<any>(null);
const fileSelected = ref<IUploadFile[]>([]);
const props = defineProps({
  disabled: {
    required: true,
    type: Boolean,
    default: false,
  },
  formValues: {
    default: {},
    require: false,
    type: Object as PropType<RegistroDeposito>,
  },
});

const form = defineForm({
  tipo_kardex: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  s_kardex: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .max(40, "máximo 40 caracteres")
          .nullable()
  ),
  s_tipo: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  s_banco: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  d_fecha_ope: field<string>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
  s_num_ope: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => Number.isNaN(value) ? null : value)
          .test("maxDigits", "Máximo de 50 dígitos permitidos.", value => {
            return validateMaxDigits(value, 50)
          })
          .positive("Numero no Válido")
          .nullable()
  ),

  i_monto: field<number | null>(
      null,
      Yup.number()
          .required("es requerido")
          .transform((value) => Number.isNaN(value) ? null : value)
          .test("maxDigits", "Máximo de 9 dígitos permitidos.", value => {
            return validateMaxDigits(value, 9)
          })
          .positive("Numero no Válido")
          .nullable()
  ),
  banco_name: field<string | null>(
      "",
      Yup.string()
          .required("es requerido")
          .nullable()
  ),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
  isSubmit.value = true
  if (isValidForm(form)) {
    let formData = {
      fotos: fotos.value,
      ...toObject(form)
    }
    emit("onSubmit", formData);
  }
};
const {formValues} = toRefs(props)

const init = (payload: RegistroDeposito) => {
  let str_s_kardex = payload?.s_kardex?.toString();
  if (str_s_kardex) {
    let num_kardex = str_s_kardex.match(/\d+/)
    if (num_kardex) {
      let kardex = num_kardex[0] ?? ''
      form.s_kardex.$value = kardex
    }
  }
  form.tipo_kardex.$value = payload?.kardex?.s_tipokardex;
  let bank =  payload?.s_banco?.toString();
  let bankPart = bank?.split(' -');
  if (bankPart?.length === 2) {
      form.s_banco.$value =  bankPart[0].trim();
      form.banco_name.$value =  bankPart[1];
  }
  form.s_tipo.$value = payload.s_tipo;
  form.d_fecha_ope.$value = payload.d_fecha_ope ? formatDateFR(payload.d_fecha_ope) : '';
  form.s_num_ope.$value = payload.s_num_ope ? parseInt(payload.s_num_ope) : null;
  form.i_monto.$value = payload.i_monto
  fotos.value = payload.fotos
  keyUploaderFiles.value = useGenerateKeyRandom()
};

const onGetFiles = (docs: IUploadFile[]) => {
  fotos.value = docs
}

const onDeleteFile = (file: IUploadFile) => {
  let index = RegistroDepositos.value.findIndex(element => element.s_codigo === file.id_reference_relation);
  if (index !== -1) {
    RegistroDepositos.value[index].fotos = RegistroDepositos.value[index].fotos.filter(element => element.s_codigo !== file.id_primary);
  }
}


const onSelectFile = (doc:any) => {
  fileSelected.value = [doc.file];
  galeryComponentRef.value?.onOpen()

}

const onGetLabelBank = (name: string) => {
  form.banco_name.$value = name
}

onMounted(() => {
  watch(formValues, (newValue, oldValue) => {
    init(newValue)
  });
})

</script>

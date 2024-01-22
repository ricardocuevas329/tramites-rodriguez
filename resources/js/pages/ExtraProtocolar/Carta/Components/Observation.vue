<template>
  <div>
    <ScrollView>
      <TextArea
        type="email"
        label="Observación"
        v-model="form.s_observacion.$value"
        :error-message="isSubmit && form.s_observacion.$error?.message"
      />
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
    TextArea,
} from "../../../../components";
import * as Yup from "yup";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { type PropType, toRefs, watchEffect, ref } from 'vue';
import type { Carta, Empresa } from "@/models/types";

const isSubmit = ref<string>('');

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<Carta>,
    },
});

const { formValues } = toRefs(props);

const form = defineForm({
    s_observacion: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(200, "máximo 200 caracteres")
    ),
});


const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    isSubmit.value = 'submit'
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};


const init = (data: Carta) => {
    form.s_observacion.$value = data.s_observacion;
 };

watchEffect(() => {

    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

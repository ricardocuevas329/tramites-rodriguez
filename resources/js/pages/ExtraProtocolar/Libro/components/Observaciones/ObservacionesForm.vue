<template>
    <ScrollView>
        <TextArea
            label="Observacion"
            v-model="form.observacion.$value"
            :error-message="form.observacion.$error?.message"
        />
        <div class="grid grid-cols-2 gap-4">
            <div>
                <LabelInput>
                    Tipo de Pago
                </LabelInput>
                <Center>
                    <div class="flex">
                        <CheckBox  v-model="form.contado.$value" name="true">{{ form.contado.$value ? 'Credito' : 'Contado' }}</CheckBox>
                    </div>
                </Center>
            </div>
            <div>
                <LabelInput>
                    Precio Total: S/
                </LabelInput>
                <button v-if="total" class="btn btn-xs">
                    {{ total.toFixed(2) }}
                </button>
            </div>
        </div>

    </ScrollView>
</template>
<script setup lang="ts">
import {Center, CheckBox, LabelInput, ScrollView, TextArea, TextInput} from "@/components";
import * as Yup from "yup";
import {defineForm, field} from "vue-yup-form";
import {type PropType, toRefs, watchEffect} from "vue";
import type {IFormFieldLibro} from "@/pages/ExtraProtocolar/Libro/Interfaces/libro.interface";
import {useDate} from "@/hooks/useDates";
const props = defineProps({
    total: {
        default: 0,
        required: false,
        type: Number
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<IFormFieldLibro>,
    },
});


const form = defineForm({
    observacion: field<string | null>(
        "",
        Yup.string()
            .max(200, "máximo 200 caracteres")
            .nullable()
    ),
    contado: field<boolean>(
        false,
        Yup.boolean()
    ),
});


const {formValues} = toRefs(props);

const init = (data: IFormFieldLibro) => {
  form.observacion.$value = data.observacion
  form.contado.$value =   !!data.contado
};



watchEffect(() => {
    if (formValues.value) {
        init(formValues.value);
    }
});


defineExpose({form});


</script>

<template>
    <div>
        <Center>
            <Row>
                <span> Fecha:</span>
                <div class="mx-1 my-1 badge badge-primary badge-outline">{{ date }}</div>
            </Row>
        </Center>
        <Center>
            <ul class="steps">
                <li @click="onSelectedStep(1)" class="step cursor-pointer text-xs"
                    :class="statusValidStep1 && step == 1 ? 'step-primary' : 'step-neutral' ">Tipo de
                    Viaje
                </li>
                <li @click="onSelectedStep(2)" class="step cursor-pointer text-xs"
                    :class="statusValidStep1 && step == 2 ? 'step-primary'  : 'step-neutral' ">¿Con quién
                    Viaja?
                </li>
                <li @click="onSelectedStep(3)" class="step cursor-pointer text-xs"
                    :class="statusValidStep2 && step == 3 ? 'step-primary' : 'step-neutral' ">Lugar y
                    Linea
                </li>
                <li @click="onSelectedStep(4)" class="step cursor-pointer text-xs"
                    :class="statusValidStep3 && step == 4 ? 'step-primary' : 'step-neutral' ">Detalles
                </li>
                <li @click="onSelectedStep(5)" class="step cursor-pointer text-xs"
                    :class="statusValidStep4 && step == 5 ? 'step-primary' : 'step-neutral' ">Comentarios
                </li>
            </ul>
        </Center>
        <ScrollView>
            <TransitionExpand>
                <div v-show="step == 1">
                    <InputSelect
                        :items="tipoViajeItems"
                        label="Tipo de Viaje"
                        v-model="formValues.i_tipo"
                        :validate-error="isSubmit"
                        :error-message="form.i_tipo.$error?.message"
                        id="permiso.viaje.i_tipo"
                        @input="onFocusInput('permiso.viaje.s_ruta')"
                        @change="onCheckValidateStep(1)"
                    />
                </div>
            </TransitionExpand>
            <TransitionExpand>
                <div v-show="step == 2">
                    <LabelInput>Seleccione:
                        <LabelError v-if="form.con_quien_viaja.$error?.message"> {{
                                form.con_quien_viaja.$error?.message
                            }}
                        </LabelError>
                    </LabelInput>
                    <Row>
                        <div class="flex w-full items-center pl-4">
                            <RadioInput
                                name="permiso.viaje.con_quien_viaja"
                                v-model="form.con_quien_viaja.$value"
                                value="solo"
                                label="Solo"
                                @change="onCheckValidateStep(2)"
                            />
                        </div>
                        <div class="flex w-full items-center pl-4">
                            <RadioInput
                                name="permiso.viaje.con_quien_viaja"
                                v-model="form.con_quien_viaja.$value"
                                value="acompañado"
                                label="Acompañado"
                                @change="onCheckValidateStep(2)"
                            />
                        </div>
                    </Row>
                </div>
            </TransitionExpand>
            <TransitionExpand>
                <div v-if="step == 3">
                    <TextInput
                        label="Lugar de Viaje"
                        v-model="formValues.s_ruta"
                        :validate-error="isSubmit"
                        :error-message="form.s_ruta.$error?.message"
                        @blur="onAddPrefix"
                        @keyup="routeWriting = false"
                        @click="routeWriting = true"
                        id="permiso.viaje.s_ruta"
                        @keyup.enter="onFocusInput('permiso.viaje.s_linea')"
                        autocomplete="off"
                    />
                    <TextInput
                        label="Linea Area,Terrestre o Maritima"
                        v-model="formValues.s_linea"
                        :validate-error="isSubmit"
                        :error-message="form.s_linea.$error?.message"
                        id="permiso.viaje.s_linea"
                        @keyup.enter="onFocusInput('permiso.viaje.s_transporte')"

                    />
                    <InputSelect
                        :items="transporteItems"
                        label="Transporte"
                        v-model="formValues.s_transporte"
                        :validate-error="isSubmit"
                        :error-message="form.s_transporte.$error?.message"
                        id="permiso.viaje.s_transporte"
                        @input="onFocusInput('permiso.viaje.i_numero')"
                        @change="onCheckValidateStep(3)"
                    />
                </div>
            </TransitionExpand>
            <TransitionExpand>
                <div v-if="step == 4">
                  <div class="grid grid-cols-1 md:grid-cols-2 ">

                        <TextInputNumber
                            label="N° Formato"
                            v-model="formValues.i_numero"
                            :validate-error="isSubmit"
                            :error-message="form.i_numero.$error?.message"
                            @keyup.enter="onFocusInput('permiso.viaje.i_tipo')"
                            id="permiso.viaje.i_numero"
                        />
                        <InputSelect
                            :items="situacionViajeItems"
                            label="Situacion de Viaje"
                            v-model="formValues.i_retorno"
                            :validate-error="isSubmit"
                            :error-message="form.i_retorno.$error?.message"
                            id="permiso.viaje.i_retorno"
                            @input="onFocusInput('permiso.viaje.d_fecha_sal')"
                        />
                    </div>

                  <div class="grid grid-cols-1 md:grid-cols-2 ">
                        <TextInput
                            type="date"
                            label="Fecha de Salida"
                            v-model="formValues.d_fecha_sal"
                            :validate-error="isSubmit"
                            :error-message="form.d_fecha_sal.$error?.message"
                            @keyup.enter="onFocusInput('permiso.viaje.d_fecha_ret')"
                            id="permiso.viaje.d_fecha_sal"
                        />

                        <TextInput
                            type="date"
                            label="Fecha de Retorno"
                            v-model="formValues.d_fecha_ret"
                            :error-message="form.d_fecha_ret.$error?.message"
                            @keyup.enter="onFocusInput('permiso.viaje.s_observacion')"
                            id="permiso.viaje.d_fecha_ret"
                        />
                    </div>


                    <InputSelect
                        :items="formatosItems"
                        label="Formatos"
                        v-model="formValues.s_formato"
                        :validate-error="isSubmit"
                        :error-message="form.s_formato.$error?.message"
                        id="permiso.viaje.s_formato"
                        @keyup.enter="onFocusInput('permiso.viaje.s_observacion')"
                        @change="onCheckValidateStep(4)"
                    />

                </div>
            </TransitionExpand>
            <TransitionExpand>
                <div v-if="step == 5">
                    <TextArea
                        label="Observacion General"
                        v-model="formValues.s_observacion"
                        :validate-error="isSubmit"
                        id="permiso.viaje.s_observacion"
                        :error-message="form.s_observacion.$error?.message"

                    />
                </div>
            </TransitionExpand>
        </ScrollView>

    </div>
</template>
<script setup lang="ts">
import * as Yup from "yup";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import {computed, type PropType, ref, watchEffect,} from "vue";
import type {Participante, PermisoViaje} from "@/models/types";
import {
    Center,
    InputSelect,
    LabelError,
    LabelInput,
    RadioInput,
    Row,
    ScrollView,
    TextArea,
    TextInput,
    TextInputNumber
} from "@/components";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import type {ITypeViaje,} from "@/pages/ExtraProtocolar/PermisoViaje/Interfaces/typevieaje.interface";
import {formatosItems, situacionViajeItems, tipoViajeItems, transporteItems,} from "@/services/PermisoViajeService";
import {useDate} from "@/hooks/useDates";
import {validateMaxDigits} from "@/utils/Regexs";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {TransitionExpand} from '@morev/vue-transitions';

const {onFocusInput} = useInputsEvents();
const {today} = useDate()
const isSubmit = ref<boolean>(false);
const date = ref<string | null>("");
const prefix = "LIMA-";
const suffix = "-LIMA";
const routeWriting = ref<boolean>(false);
const step = ref<number>(1);


const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<PermisoViaje>,
    },
});
const {formValues, disabled} = props
const form = defineForm({
    i_codigo: field<number | null | undefined>(null, Yup.number().nullable()),
    i_numero: field<number | null | undefined>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("maxDigits", "Máximo de 10 dígitos permitidos.", value => {
                return validateMaxDigits(value, 10)
            })
            .positive("Numero no Válido")
            .nullable()
    ),
    i_solo: field<number | null | undefined>(null, Yup.number().nullable()),
    i_tipo: field<string | number | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .max(70, "máximo 70 caracteres")
            .nullable()
    ),
    i_retorno: field<number | null | undefined>(
        null,
        Yup.string()
            .required("es requerido")
            .max(10, "máximo 10 caracteres")
            .nullable()
    ),
    s_linea: field<string | null | undefined>(
        "",
        Yup.string()
            //.required("es requerido")
            .max(120, "máximo 120 caracteres")
            .nullable()
    ),
    s_formato: field<string | null | undefined>(
        "",
        Yup.string()
            //.required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),

    s_observacion: field<string | null | undefined>(
        "",
        Yup.string()
            //.required("es requerido")
            .max(800, "máximo 800 caracteres")
            .nullable()
    ),
    s_ruta: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    s_transporte: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    d_fecha_ret: field<string | null | undefined>(
        "",
        Yup.string()
            //.required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    d_fecha_sal: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    participantes: field<Participante[]>([]),
    acompanantes: field<Participante[]>([]),
    con_quien_viaja: field<ITypeViaje>(
        "",
        Yup.string().required("es requerido")
    ),
    files: field<IUploadFile[]>([]),
});

const emit = defineEmits(["onSubmit"]);

const onSubmit = () => {
    onValidateFocus();
    isSubmit.value = true;
    verifyValidationStep()
    if (isValidForm(form)) {
        if (form.i_solo.$value != null) {
            form.i_solo.$value = form.con_quien_viaja.$value == "solo" ? 1 : 0;
        }
        emit("onSubmit", toObject(form));
    }
};

const init = (payload: PermisoViaje) => {
    date.value = payload.i_codigo
        ? payload?.d_fecha_reg
        : today.value?.toString();
    form.i_codigo.$value = payload.i_codigo;
    form.i_numero.$value = payload.i_numero;
    form.i_retorno.$value = payload.i_retorno;
    form.i_solo.$value = payload.i_solo;
    form.i_tipo.$value = payload.i_tipo?.toString();
    form.s_formato.$value = payload.s_formato;
    form.s_observacion.$value = payload.s_observacion;
    form.s_ruta.$value = payload.s_ruta;
    form.s_transporte.$value = payload.s_transporte;
    form.d_fecha_ret.$value = payload.d_fecha_ret;
    form.d_fecha_sal.$value = payload.d_fecha_sal;
    form.s_linea.$value = payload.s_linea;
    if (payload.i_solo != null) {
        if (payload.i_solo == 1) {
            form.con_quien_viaja.$value = "solo"
        } else {
            form.con_quien_viaja.$value = "acompañado"
        }
    }

    form.participantes.$value = payload?.participantes;
    form.acompanantes.$value = payload?.acompanantes;
    form.files.$value = payload?.files;
};


const onValidateFocus = () => {
    if (form.i_numero.$error) {
        return onFocusInput("permiso.viaje.i_numero");
    }
    if (form.i_tipo.$error) {
        return onFocusInput("permiso.viaje.i_tipo");
    }
    if (form.s_ruta.$error) {
        return onFocusInput("permiso.viaje.s_ruta");
    }
    if (form.s_transporte.$error) {
        return onFocusInput("permiso.viaje.s_transporte");
    }
    if (form.i_retorno.$error) {
        return onFocusInput("permiso.viaje.i_retorno");
    }
    if (form.s_linea.$error) {
        return onFocusInput("permiso.viaje.s_linea");
    }
    if (form.d_fecha_sal.$error) {
        return onFocusInput("permiso.viaje.d_fecha_sal");
    }
    if (form.s_formato.$error) {
        return onFocusInput("permiso.viaje.s_formato");
    }
    if (form.s_observacion.$error) {
        return onFocusInput("permiso.viaje.s_observacion");
    }


};

const onAddPrefix = () => {
    if (!routeWriting.value) {
        let text = "";
        let textSearch = formValues?.s_ruta;
        if (
            textSearch?.indexOf(prefix) == -1 &&
            textSearch?.indexOf(suffix) == -1
        ) {
            text = prefix + textSearch + suffix;
        } else if (
            textSearch?.indexOf(prefix) !== -1 &&
            textSearch?.indexOf(suffix) == -1
        ) {
            text = textSearch + suffix;
        } else if (
            textSearch?.indexOf(suffix) !== -1 &&
            textSearch?.indexOf(prefix) == -1
        ) {
            text = prefix + textSearch;
        } else {
            text = textSearch ?? "";
        }
        if (textSearch?.trim() === '') {
            formValues.s_ruta = ''
        } else {
            formValues.s_ruta = text.toUpperCase().trim();
        }

    }
};

const onGenerateObservation = () => {
    // form.s_observacion =
}

const onSetStep = (stepNumber: number) => {
    return step.value = stepNumber
}

const onSelectedStep = (stepNumber: number) => {
    if (stepNumber == 1) {
        if (statusValidStep1.value) {
            onSetStep(1)
        }
    }

    if (stepNumber == 2) {
        if (statusValidStep1.value) {
            onSetStep(2)
        }
        if (statusValidStep2.value) {
            onSetStep(2)
        }
    }

    if (stepNumber == 3) {
        if (statusValidStep2.value) {
            onSetStep(3)
        }
        if (statusValidStep3.value) {
            onSetStep(3)
        }
    }

    if (stepNumber == 4) {
        if (statusValidStep3.value) {
            onSetStep(4)
        }
        if (statusValidStep4.value) {
            onSetStep(4)
        }
    }
    if (stepNumber == 5) {
        if (statusValidStep4.value) {
            onSetStep(5)
        }
    }
}

const onCheckValidateStep = (stepNumber: number) => {

    if (stepNumber == 1) {
        if (statusValidStep1.value) {
          setTimeout(()=>{
            onSetStep(2)
         }, 1000)
        }
    }
    if (stepNumber == 2) {
        if (statusValidStep2.value) {
          setTimeout(()=>{
            onSetStep(3)
          }, 1000)
        }
    }
    if (stepNumber == 3) {
        if (statusValidStep3.value) {
          setTimeout(()=>{
            onSetStep(4)
          }, 1000)
        }
    }

    if (stepNumber == 4) {
        if (statusValidStep4.value) {
          setTimeout(()=>{
            onSetStep(5)
          }, 1000)
        }
    }

}

const statusValidStep1 = computed(() => {
    return form.i_tipo.$error?.errors.length === undefined;
})

const statusValidStep2 = computed(() => {
    return form.con_quien_viaja.$error?.errors.length === undefined;
})

const statusValidStep3 = computed(() => {
    return form.s_ruta.$error?.errors.length === undefined &&
        form.s_linea.$error?.errors.length === undefined &&
        form.s_transporte.$error?.errors.length === undefined;
})

const statusValidStep4 = computed(() => {
    return form.i_numero.$error?.errors.length === undefined &&
        form.i_retorno.$error?.errors.length === undefined &&
        form.d_fecha_sal.$error?.errors.length === undefined &&
        form.d_fecha_ret.$error?.errors.length === undefined &&
        form.s_formato.$error?.errors.length === undefined
})

const statusValidStep5 = computed(() => {
    return form.s_observacion.$error?.errors.length === undefined;
})

const verifyValidationStep = () => {
    if (statusValidStep1.value) {
        onSetStep(2)
    }
    if (statusValidStep2.value) {
        onSetStep(3)
    }
    if (statusValidStep3.value) {
        onSetStep(4)
    }
    if (statusValidStep4.value) {
        onSetStep(5)
    }
}

watchEffect(() => {
    init(formValues);
});

defineExpose({onSubmit, form, onValidateFocus});
</script>

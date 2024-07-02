<template>
    <div>
        <div class=" mx-2 ">
            <TransitionSlide group tag="ul">
                <ul v-if="participantes.length" v-for="(item, i) in participantes">
                    <li :key="i" class="flex  ">
                        <div class="tooltip" :data-tip="item.nombre?.toUpperCase()">
                            <button class="btn btn-xs btn-success ">
                                <div class="flex">
                                    {{ item?.rol_label }}
                                    <CloseCircle @click="participantes.splice(i, 1)"
                                                 class="w-4  rounded-sm hover:bg-green-100  "/>
                                </div>
                            </button>
                        </div>
                        <br>
                        <div v-for="(file, idx) in item.files" class="avatar mt-1 mx-1 cursor-pointer" :key="idx">
                            <div class="w-10  rounded-lg">
                                <img v-if="file.type.includes('image/')" alt=""
                                     :src="'data:image/png;base64,'+file?.base64"/>
                                <DocumentAttach class="w-10 text-secondary " v-if="!file.type.includes('image/')"/>
                            </div>
                        </div>
                    </li>

                </ul>
            </TransitionSlide>
        </div>
        <ScrollView>
            <div>
                <div class="chat chat-start">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt=""
                                 src="@/assets/icons/asistent.jpg"/>
                        </div>
                    </div>
                    <span v-if="!loadings.tipo_viaje" class="loading loading-dots loading-md"></span>
                    <TransitionScale>
                        <div v-if="loadings.tipo_viaje" class="chat-bubble bg-primary">Hola {{user?.nombre_compuesto }}! ¿Dime, a donde viaja?</div>
                    </TransitionScale>
                </div>
                <div class="chat chat-end gap-2" v-if="loadings.tipo_viaje">
                    <button @click="onNextStepTipoViaje(1, 2)" class="btn btn-outline btn-success">INTERIOR DEL PAÍS
                        <Check v-if="form.type.$value == 1 " class="w-8"/>
                    </button>
                    <br>
                    <button @click="onNextStepTipoViaje(2, 2)" class="btn btn-outline btn-success">EXTERIOR DEL
                        PAÍS
                        <Check v-if="form.type.$value == 2 " class="w-8"/>
                    </button>
                    <span ref="refWhereTravel"></span>
                </div>
            </div>

            <div v-if="step > STEP_INIT  && step <= STEP_END ">

                <div class="chat chat-start">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt=""
                                 src="@/assets/icons/asistent.jpg"/>
                        </div>
                    </div>
                    <span v-if="!loadings.con_quien" class="loading loading-dots loading-md"></span>
                    <TransitionScale>
                        <div v-if="loadings.con_quien" class="chat-bubble bg-primary">¿Viajará solo o acompañado?</div>
                    </TransitionScale>
                </div>
                <div class="chat chat-end gap-2" v-if="loadings.con_quien">

                    <button @click="onNextStepConquienViaja('solo', 3)" class="btn btn-outline btn-success">SOLO
                        <Check v-if="form.travel.$value == 'solo'" class="w-8"/>
                    </button>

                    <br>

                    <button @click="onNextStepConquienViaja('acompanado', 3)" class="btn btn-outline btn-success">
                        ACOMPAÑADO
                        <Check v-if="form.travel.$value == 'acompanado'"/>
                    </button>
                    <span ref="refAloneCompany"></span>
                </div>

            </div>

            <div v-if="step > STEP_INIT   && step <= STEP_END">

                <div class="chat chat-start">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt=""
                                 src="@/assets/icons/asistent.jpg"/>
                        </div>
                    </div>
                    <span v-if="!loadings.lugar_viaje" class="loading loading-dots loading-md"></span>
                    <TransitionScale>
                        <div v-if="loadings.lugar_viaje" class="chat-bubble bg-primary">¿a que ciudad desea viajar?
                        </div>
                    </TransitionScale>
                </div>
                <div class="chat chat-end " v-if="loadings.lugar_viaje">

                    <div>
                        <TextInput
                            :showLabel="false"
                            v-model="form.route.$value"
                            :validate-error="isSubmitForm"
                            :error-message="form.route.$error?.message"
                            @blur="onAddPrefix"
                            @keyup="onRouteKeyup()"
                            @click="routeWriting = true"
                            id="permiso.viaje.route"
                            @keyup.enter="onNextStepRoute( null, 4)"
                            autocomplete="off"
                            placeholder="Ingresa Ciudad"
                        />

                        <span ref="refWhereCityTravel"></span>
                    </div>
                </div>

            </div>
            <div v-if="step > STEP_INIT  && step <= STEP_END">

                <div class="chat chat-start">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt=""
                                 src="@/assets/icons/asistent.jpg"/>
                        </div>
                    </div>
                    <span v-if="!loadings.transport" class="loading loading-dots loading-md"></span>
                    <TransitionScale>
                        <div v-if="loadings.transport" class="chat-bubble bg-primary">Elije el Transporte</div>
                    </TransitionScale>
                </div>
                <div class="chat chat-end " v-if="loadings.transport">

                    <div class="flex flex-col gap-2">

                        <button v-if="transporteItems.length" v-for="(item , k) in transporteItems" :k="k"
                                @click="onNextStepTransport(item.id, 5)" class="btn btn-outline btn-success">
                            {{ item.label }}
                            <Check v-if="form.transport.$value == item.id" class="w-8"/>
                        </button>
                        <span ref="refTransport"></span>
                    </div>
                </div>

            </div>

            <div v-if="step > STEP_INIT  && step <= STEP_END">

                <div class="chat chat-start">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt=""
                                 src="@/assets/icons/asistent.jpg"/>
                        </div>
                    </div>
                    <span v-if="!loadings.linea" class="loading loading-dots loading-md"></span>
                    <TransitionScale>
                        <div v-if="loadings.linea" class="chat-bubble bg-primary">¿Ingrese el nombre de la linea
                            Area,Terrestre o
                            Marítima
                        </div>
                    </TransitionScale>
                </div>
                <div class="chat chat-end " v-if="loadings.linea">

                    <div>
                        <TextInput
                            :showLabel="false"
                            v-model="form.line.$value"
                            :validate-error="isSubmitForm"
                            :error-message="form.line.$error?.message"
                            @blur="onAddPrefix"
                            id="permiso.viaje.line"
                            @keyup="onLineaKeyup()"
                            @keyup.enter="onNextStepLinea(  6)"
                            autocomplete="off"
                            placeholder="Ingresa Linea"
                        />

                        <span ref="refLine"></span>
                    </div>
                </div>

            </div>


            <div v-if="step > STEP_INIT  && step <= STEP_END">

                <div class="chat chat-start">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt=""
                                 src="@/assets/icons/asistent.jpg"/>
                        </div>
                    </div>
                    <span v-if="!loadings.rol" class="loading loading-dots loading-md"></span>
                    <TransitionScale>
                        <div v-if="loadings.rol" class="chat-bubble bg-primary">Agregue Participantes
                        </div>
                    </TransitionScale>
                </div>
                <div class="chat chat-end " v-if="loadings.rol">

                    <div class="flex flex-col gap-2">
                        <span ref="refParticipant"></span>
                        <button v-if="participantsItems.length" v-for="(item, k) in participantsItems" :key="k"
                                :disabled="participantes.some((p)=> p.rol_label === item.label)"
                                @click="onNextStepParticipantRol( form.rol.$value == item.id ? null : item.id, 7)"
                                class="btn btn-outline btn-success">
                            {{ item.label }}
                            <Check v-if="form.rol.$value == item.id" class="w-8"/>
                        </button>

                        <TextInput v-if="form.rol.$value"
                                   :showLabel="false"
                                   autocomplete="off"
                                   :placeholder="'INGRESA DATOS '+ participantLabel"
                                   v-model="formInfo.participanteData.$value"
                                   :validate-error="isSubmitForm"
                                   :error-message="formInfo.participanteData.$error?.message"

                        />


                        <UploaderFiles :files="[]" :key="form.rol.$value?.toString()" :maxFiles="2"   maxFileSize="50MB"
                                       maxTotalFileSize="200MB" @getFiles="getFiles" accept="image/* , application/pdf"
                                       :label="`ARRASTRA O AGREGA DNI ${participantLabel}`"/>


                        <button ref="refParticipantData" :disabled="!!formInfo.participanteData.$error?.errors.length"
                                @click="onSaveRolParticipant"
                                class="btn btn-sm btn-success ">
                            Grabar Participante
                        </button>


                    </div>
                </div>

            </div>
            <div v-if="step > STEP_INIT  && step <= STEP_END  ">

                <div class="chat chat-start">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt=""
                                 src="@/assets/icons/asistent.jpg"/>
                        </div>
                    </div>
                    <span v-if="!loadings.dates" class="loading loading-dots loading-md"></span>
                    <TransitionScale>
                        <div v-if="loadings.dates" class="chat-bubble bg-primary">¿Que dia saldrás y cuando
                            regresarás?
                        </div>
                    </TransitionScale>
                </div>
                <div class="chat chat-end " v-if="loadings.dates">

                    <div class="flex flex-col gap-2">

                        <TextInput
                            type="date"
                            label="Salida"
                            v-model="form.date_sal.$value"
                            :validate-error="isSubmitForm"
                            :min="todayDefault"
                            :error-message="form.date_sal.$error?.message"
                            @keyup.enter="onFocusInput('permiso.viaje.date_ret')"
                            id="permiso.viaje.date_sal"
                            @input="onNextStepContact(9)"
                        />
                        <TextInput
                            type="date"
                            label="Retorno"
                            v-model="form.date_ret.$value"
                            :error-message="form.date_ret.$error?.message"
                            :min="form.date_sal.$value"
                            @keyup.enter="onFocusInput('permiso.viaje.obervation')"
                            id="permiso.viaje.date_ret"
                            @input="onNextStepContact(9)"
                        />

                        <span ref="refDates"></span>
                    </div>
                </div>


            </div>
            <div v-if="step > STEP_INIT  && step <= STEP_END">

                <div class="chat chat-start">
                    <div class="chat-image avatar">
                        <div class="w-10 rounded-full">
                            <img alt=""
                                 src="@/assets/icons/asistent.jpg"/>
                        </div>
                    </div>
                    <span v-if="!loadings.contact" class="loading loading-dots loading-md"></span>
                    <TransitionScale>
                        <div v-if="loadings.contact" class="chat-bubble bg-primary">Agrega tu información de contacto.
                        </div>
                    </TransitionScale>
                </div>
                <div class="chat chat-end " v-if="loadings.contact">

                    <div class="flex flex-col gap-2">
                        <TextArea
                            label="Observacion"
                            v-model="form.obervation.$value"
                            :validate-error="isSubmitForm"
                            id="permiso.viaje.obervation"
                            :error-message="form.obervation.$error?.message"
                        />
                        <TextInputNumber
                            label="Ingresa tu Numero de Celular"
                            v-model="form.phone.$value"
                            :validate-error="isSubmitForm"
                            id="permiso.viaje.phone"
                            :error-message="form.phone.$error?.message"

                        />
                        <TextInput
                            label="Ingresa tu Correo"
                            v-model="form.email.$value"
                            :validate-error="isSubmitForm"
                            id="permiso.viaje.email"
                            :error-message="form.email.$error?.message"
                        />
                        <span ref="refContact"></span>
                    </div>
                </div>

            </div>
        </ScrollView>
        <Center v-if="step>=7">
            <BtnSave text="Enviar Solicitud" :loading="isSubmit" :disabled="isSubmit" @click="onSubmit"/>
        </Center>
    </div>
</template>
<script setup lang="ts">
import {notify} from "@kyvg/vue3-notification";
import * as Yup from "yup";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import {computed, onMounted, ref, toRefs} from "vue";
import {BtnSave, Center, ScrollView, TextArea, TextInput, UploaderFiles} from "@/components";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import {participantsItems, transporteItems,} from "@/services/PermisoViajeService";
import {useDate} from "@/hooks/useDates";
import type {IUploadFile} from "@/models/components/upload-file.interface";
import {RegExps, validateMaxDigits} from "@/utils/Regexs";
import {TransitionScale, TransitionSlide,} from "@morev/vue-transitions"
import Check from 'vue-material-design-icons/Check.vue'
import CloseCircle from "@vicons/ionicons5/CloseCircle";
import DocumentAttach from "@vicons/ionicons5/DocumentAttach";
import {debounce} from "@/utils/debounce.js";
import TextInputNumber from "@/components/TextInputNumber.vue";
import {usePermisoViajeStore} from "@/store/permiso-viaje";
import {useAuthExternalStore} from "@/store/external/auth.external";

type IParticipant = {
    nombre: string | null,
    files: IUploadFile[],
    rol: number | null,
    rol_label: string
}


const STEP_INIT = 1
const STEP_END = 9
const PROGRESS_POINT_INIT = 12.5
const TIME_OUT_INIT = 400
const TIME_OUT_SECOND = 100
const refWhereTravel = ref<HTMLElement>()
const refAloneCompany = ref<HTMLElement>()
const refWhereCityTravel = ref<HTMLElement>()
const refLine = ref<HTMLElement>()
const refTransport = ref<HTMLElement>()
const refParticipant = ref<HTMLElement>()
const refParticipantData = ref<HTMLElement>()
const refDates = ref<HTMLElement>()
const refContact = ref<HTMLElement>()

const { user } = toRefs(useAuthExternalStore())
const {onFocusInput} = useInputsEvents();
const {todayDefault} = useDate()
const {isSubmit} = toRefs(usePermisoViajeStore());
const isSubmitForm = ref<boolean>(false);
const prefix = "LIMA-";
const suffix = "-LIMA";
const routeWriting = ref<boolean>(false);
const step = ref<number>(1);
const loadings = ref({
    tipo_viaje: false,
    con_quien: false,
    lugar_viaje: false,
    linea: false,
    transport: false,
    rol: false,
    dates: false,
    contact: false
});

const participantes = ref<IParticipant[]>([])
const filesAdded = ref<IUploadFile[]>([])
const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
});

const form = defineForm({
    type: field<number | null>(
        null,
        Yup.string()
            .required("es requerido")
            .max(70, "máximo 70 caracteres")
            .nullable()
    ),
    rol: field<number | null>(
        null,
        Yup.string()
            //.required("es requerido")
            .max(10, "máximo 10 caracteres")
            .nullable()
    ),
    line: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .max(120, "máximo 120 caracteres")
            .nullable()
    ),
    obervation: field<string | null>(
        "",
        Yup.string()
            //.required("es requerido")
            .max(300, "máximo 300 digitos")
            .nullable()
    ),
    route: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    transport: field<number | null>(
        null,
        Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    date_ret: field<string | null>(
        "",
        Yup.string()
            //.required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    date_sal: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    participantes: field<IParticipant[]>([]),
    travel: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .nullable()
    ),
    phone: field<number | null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("maxDigits", "Máximo de 9 dígitos permitidos.", value => {
                return validateMaxDigits(value, 9)
            })
            .nullable()
    ),
    email: field<string | null>(
        "",
        Yup.string()
            .email("Correo no válido")
            .max(100, "máximo 100 digitos")
            .nullable()
    ),
    participanteDataFiles: field<number>(
        0,
        Yup.number()
        //.required("es requerido")
    ),
});

const formInfo = defineForm({
    participanteData: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Nombres no válido")
            .max(100, "máximo 100 digitos")
            .nullable())

});

const emit = defineEmits(["onSubmit", "onCompleteProgress"]);

const onSubmit = () => {
    onValidateFocus();
    isSubmitForm.value = true;
    verifyValidationStep()
    if (isValidForm(form)) {
        let formData = {...toObject(form), participantes: participantes.value}
        emit("onSubmit", formData);
    }
};

const onSaveRolParticipant = () => {
    form.participanteDataFiles.$value = filesAdded.value.length
    if (form.participanteDataFiles.$value == 0) {
        return notify({
            title: 'Atención!',
            text: "Adjunte tus Documentos!",
            type: 'warn'
        });
    }

    if (form.participanteDataFiles.$value >= 1) {
        loadings.value.dates = true
        setTimeout(() => {
            const inputElement = refDates.value;
            if (inputElement) {
                inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
            }

            onNextStepDates(8)
        }, TIME_OUT_INIT + TIME_OUT_SECOND + TIME_OUT_SECOND)
    }

    participantes.value.push({
        nombre: formInfo.participanteData.$value,
        files: filesAdded.value,
        rol: form.rol.$value,
        rol_label: participantLabelRol.value
    })
    filesAdded.value = []
    formInfo.participanteData.$value = ''
    form.rol.$value = null
    form.participanteDataFiles.$value = 0

    setTimeout(() => {
        const inputElement = refParticipant.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    }, TIME_OUT_INIT + TIME_OUT_SECOND)


}


const onValidateFocus = () => {

    if (form.route.$error) {
        return onFocusInput("permiso.viaje.route");
    }
    if (form.transport.$error) {
        return onFocusInput("permiso.viaje.transport");
    }
    if (form.rol.$error) {
        return onFocusInput("permiso.viaje.rol");
    }
    if (form.line.$error) {
        return onFocusInput("permiso.viaje.line");
    }
    if (form.date_ret.$error) {
        return onFocusInput("permiso.viaje.date_ret");
    }
    if (form.date_sal.$error) {
        return onFocusInput("permiso.viaje.date_sal");
    }
    if (form.obervation.$error) {
        return onFocusInput("permiso.viaje.obervation");
    }
    if (form.phone.$error) {
        return onFocusInput("permiso.viaje.phone");
    }
    if (form.email.$error) {
        return onFocusInput("permiso.viaje.email");
    }
};

const onAddPrefix = () => {
    if (!routeWriting.value) {
        let text = "";
        let textSearch = form.route.$value;
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
            form.route.$value = ''
        } else {
            form.route.$value = text.toUpperCase().trim();
        }

    }
    onNextStepRoute(null, 4)
};


const onSetStep = (stepNumber: number) => {
    return step.value = stepNumber
}


const statusValidType = computed(() => {
    return form.type.$error?.errors.length === undefined;
})

const statusValidTravel = computed(() => {
    return form.travel.$error?.errors.length === undefined;
})

const statusValidRoute = computed(() => {
    return form.route.$error?.errors.length === undefined
})

const statusValidLinea = computed(() => {
    return form.line.$error?.errors.length === undefined
})

const statusValidTransport = computed(() => {
    return form.transport.$error?.errors.length === undefined;
})

const statusValidRol = computed(() => {
    return form.rol.$error?.errors.length === undefined;
})

const statusValidDates = computed(() => {
    return form.date_ret.$error?.errors.length === undefined
        && form.date_sal.$error?.errors.length === undefined;
})

const statusValidContact = computed(() => {
    return form.phone.$error?.errors.length === undefined
        && form.email.$error?.errors.length === undefined
        && form.obervation.$error?.errors.length === undefined;
})
const verifyValidationStep = () => {
    let total1 = statusValidType.value ? PROGRESS_POINT_INIT : 0
    let total2 = statusValidTravel.value ? PROGRESS_POINT_INIT : 0
    let total3 = statusValidRoute.value ? PROGRESS_POINT_INIT : 0
    let total4 = statusValidLinea.value ? PROGRESS_POINT_INIT : 0
    let total5 = statusValidTransport.value ? PROGRESS_POINT_INIT : 0
    let total6 = statusValidRol.value ? PROGRESS_POINT_INIT : 0
    let total7 = statusValidDates.value ? PROGRESS_POINT_INIT : 0
    let total8 = statusValidContact.value ? PROGRESS_POINT_INIT : 0
    emit("onCompleteProgress", total1 + total2 + total3 + total4 + total5 + total6 + total7 + total8)
}


const onNextStepTipoViaje = (val: number, step: number) => {
    form.type.$value = val
    onSetStep(step)

    setTimeout(() => {
        loadings.value.con_quien = true
    }, TIME_OUT_INIT)

    setTimeout(() => {
        const inputElement = refAloneCompany.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    }, TIME_OUT_INIT + TIME_OUT_SECOND)

    verifyValidationStep()
}

const onNextStepConquienViaja = (val: string, step: number) => {
    form.travel.$value = val
    onSetStep(step)

    setTimeout(() => {
        loadings.value.lugar_viaje = true
    }, TIME_OUT_INIT)

    setTimeout(() => {
        const inputElement = refWhereCityTravel.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    }, TIME_OUT_INIT + TIME_OUT_SECOND)
    verifyValidationStep()
}

const onNextStepRoute = (val: null, step: number) => {
    if (form.route.$error?.message) {
        return;
    }
    onSetStep(step)

    setTimeout(() => {
        loadings.value.transport = true
    }, TIME_OUT_INIT)
    setTimeout(() => {
        const inputElement = refTransport.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    }, TIME_OUT_INIT + TIME_OUT_SECOND)
    verifyValidationStep()
}

const onNextStepLinea = (step: number) => {
    isSubmitForm.value = true
    if (form.line.$error?.message) {
        return;
    }
    onSetStep(step)
    setTimeout(() => {
        loadings.value.rol = true
    }, TIME_OUT_INIT)

    setTimeout(() => {
        const inputElement = refParticipant.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }
    }, TIME_OUT_INIT + TIME_OUT_SECOND)
    verifyValidationStep()

}

const onNextStepTransport = (val: number, step: number) => {
    form.transport.$value = val
    onSetStep(step)

    setTimeout(() => {
        loadings.value.linea = true
    }, TIME_OUT_INIT)

    setTimeout(() => {
        const inputElement = refLine.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }

    }, TIME_OUT_INIT + TIME_OUT_SECOND)
    verifyValidationStep()

}

const onNextStepParticipantRol = (val: number | null, step: number) => {

    form.rol.$value = val
    onSetStep(step)
    setTimeout(() => {
        const inputElement = refParticipantData.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }

    }, TIME_OUT_INIT + TIME_OUT_SECOND)
    verifyValidationStep()
}
const onNextStepDates = (step: number) => {

    onSetStep(step)
    setTimeout(() => {
        const inputElement = refDates.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }

    }, TIME_OUT_INIT + TIME_OUT_SECOND)
    verifyValidationStep()
}

const onNextStepContact = (step: number) => {
    loadings.value.contact = true
    onSetStep(step)
    setTimeout(() => {
        const inputElement = refContact.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }

    }, TIME_OUT_INIT + TIME_OUT_SECOND)
    verifyValidationStep()
}

const participantLabel = computed(() => {

    const participant = participantsItems.find(item => item.id === form.rol.$value);
    if (participant) {
        return participant.label == 'MADRE' ? 'DE LA ' + participant.label : 'DEL ' + participant.label;
    }
    return "";

})

const participantLabelRol = computed(() => {

    const participant = participantsItems.find(item => item.id === form.rol.$value);
    if (participant) {
        return participant.label;
    }
    return "";

})
const getFiles = (files: IUploadFile[]) => {
    filesAdded.value = files
    setTimeout(() => {
        const inputElement = refParticipantData.value;
        if (inputElement) {
            inputElement.scrollIntoView({behavior: 'smooth', block: 'center'});
        }

    }, TIME_OUT_INIT + TIME_OUT_SECOND)
}

const onRouteKeyup = debounce(() => {
    routeWriting.value = false
    return onNextStepRoute(null, 4);
}, 500);

const onLineaKeyup = debounce(() => {
    onNextStepLinea(5)
}, 500);


onMounted(() => {
    setTimeout(() => {
        loadings.value.tipo_viaje = true
    }, TIME_OUT_INIT)
})

defineExpose({onSubmit, form, onValidateFocus});
</script>

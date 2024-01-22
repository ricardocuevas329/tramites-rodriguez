<template>
    <Content>
        <Head>
            <template v-slot:start>
                <BtnBack @click="closeParticipant()" />
            </template>
            <template v-slot:center>
                <TitleTable>
                    {{
                        formValues?.index >= 0 ? "EDITAR" : "NUEVO"
                    }}
                    PARTICIPANTE</TitleTable
                >
            </template>
        </Head>

        <ScrollView>
            <InputSelect
                :items="ParticipanteItems"
                label="Participa Como"
                v-model="form.type.$value"
                :validate-error="isSubmit"
                @input="onFocusInput('participant.type_doc')"
                id="participant.type"
                :error-message="form.type.$error?.message"
                ref="condicionRef"
            />

            <Row>
                <InputSelect
                    :items="TipoDocumentos"
                    label="Documento"
                    v-model="form.cliente.type_doc.$value"
                    :validate-error="isSubmit"
                    :error-message="form.cliente.type_doc.$error?.message"
                    label-data="s_abrev"
                    value-data="s_codigo"
                    id="participant.type_doc"
                    @input="onFocusInput('participant.num_doc')"
                />

                <Row>
                    <TextInput
                        label="Numero"
                        v-model="form.cliente.num_doc.$value"
                        id="participant.num_doc"
                        :validate-error="isSubmit"
                        :error-message="form.cliente.num_doc.$error?.message"
                        @keyup.enter="onFocusInput('participant.paternal')"
                    />
                    <ToolTip text="Buscar Participante">
                        <button
                            :disabled="isSubmitFindByDocument"
                            @click="onFindByDocument()"
                            class="btn btn-sm btn-circle mt-6"
                        >
                            <MagnifyingGlassIcon />
                        </button>
                    </ToolTip>
                </Row>
            </Row>

            <Row>
                <TextInput
                    label="Apellido Paterno"
                    autofocus
                    v-model="form.cliente.paternal.$value"
                    :validate-error="isSubmit"
                    :error-message="form.cliente.paternal.$error?.message"
                    id="participant.paternal"
                    @keyup.enter="onFocusInput('participant.maternal')"
                />

                <TextInput
                    label="Apellido Materno"
                    v-model="form.cliente.maternal.$value"
                    :validate-error="isSubmit"
                    id="participant.maternal"
                    @keyup.enter="onFocusInput('participant.name')"
                    :error-message="form.cliente.maternal.$error?.message"
                />
            </Row>

            <TextInput
                label="Nombres"
                id="participant.name"
                v-model="form.cliente.name.$value"
                :validate-error="isSubmit"
                @keyup.enter="onFocusInput('participant.birthday')"
                :error-message="form.cliente.name.$error?.message"
            />

            <Row>
                <TextInput
                    type="date"
                    :max="maxDate"
                    @change="onCalculateAge()"
                    label="Fecha de Nacimiento"
                    v-model="form.cliente.birthday.$value"
                    :validate-error="isSubmit"
                    id="participant.birthday"
                    @keyup.enter="onFocusInput('participant.age')"
                    :error-message="form.cliente.birthday.$error?.message"
                />

                <TextInput
                    type="number"
                    label="Edad"
                    disabled
                    v-model="form.age.$value"
                    :validate-error="isSubmit"
                    :error-message="form.age.$error?.message"
                    id="participant.age"
                    @keyup.enter="onFocusInput('participant.sex')"
                />
            </Row>
            <Row>
                <InputSelect
                    :items="SexoItems"
                    v-model="form.cliente.sex.$value"
                    @input="onFocusInput('participant.status_civil')"
                    :validate-error="isSubmit"
                    label="Sexo"
                    id="participant.sex"
                    :error-message="form.cliente.sex.$error?.message"
                />
                <InputSelect
                    :items="EstadoCivilItems"
                    label="Estado Civil"
                    v-model="form.cliente.status_civil.$value"
                    :validate-error="isSubmit"
                    id="participant.status_civil"
                    @input="onFocusInput('participant.nationality')"
                    :error-message="form.cliente.status_civil.$error?.message"
                />
            </Row>

            <InputSelect
                :items="Nacionalidades"
                label="Nacionalidad"
                v-model="form.cliente.nationality.$value"
                :validate-error="isSubmit"
                id="participant.nationality"
                @input="onFocusInput('participant.distrito')"
                :error-message="form.cliente.nationality.$error?.message"
                label-data="s_gentilicio"
                value-data="s_codigo"
            />

            <Center v-if="SelectUbigeo?.distrito">
                <MapPinIcon class="text-primary-500 w-5" />
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
                @keyup.enter="onFocusInput('participant.address')"
                @onSelecteValue="onSelecteValue"
                v-model="searchUbigeos"
                :data="Ubigeos"
            />

            <TextInput
                label="Direccion"
                id="participant.address"
                @keyup.enter="onFocusInput('participant.with_signature')"
                v-model="form.cliente.address.$value"
                :validate-error="isSubmit"
                :error-message="form.cliente.address.$error?.message"
            />

            <div class="flex justify-center items-center py-2">
                <CheckBox
                    id="participant.with_signature"
                    v-model="form.with_signature.$value"
                    name="participant.with_signature"
                    @change.native="onFocusInput('participant.num_partida')"
                    >¿CON FIRMA?
                </CheckBox>
            </div>

            <Row v-if="isRepresentant">
                <TextInput
                    label="N° de Partida"
                    v-model="form.num_partida.$value"
                    :validate-error="isSubmit"
                    :error-message="form.num_partida.$error?.message"
                    id="participant.num_partida"
                    @keyup.enter="onFocusInput('participant.sede_registral')"
                />

                <InputSelect
                    :items="ZonaRegistrales"
                    label="Sede Registral"
                    v-model="form.sede_registral.$value"
                    label-data="s_nombre"
                    value-data="s_codigo"
                    :validate-error="isSubmit"
                    id="participant.sede_registral"
                    :error-message="form.sede_registral.$error?.message"
                />
            </Row>
        </ScrollView>

        <Center>
            <BtnSave @click="onSubmit" />
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
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { RegExps } from "@/utils/Regexs";
import {
    computed,
    onMounted,
    type PropType,
    ref,
    toRefs,
    watchEffect,
} from "vue";
import { debounce } from "../../../../../utils/debounce.js";
import type { Ubigeo } from "@/models/ubigeo";
import { MapPinIcon, MagnifyingGlassIcon } from "@heroicons/vue/20/solid";
import { useZonaRegistralStore } from "@/store/zona-registral";
import { useInputsEvents } from "@/hooks/useInputsEvents";
import { useCalculateAge, useDate } from "@/hooks/useDates";
import { SexoItems } from "@/services/SexoService";
import {
    ParticipanteItems,
    VALID_PARTICPANT_REPRESENTANTE,
} from "@/services/ParticipanteService";
import { EstadoCivilItems } from "@/services/EstadoCivilService";
import type { IParamsDeleteParticipant } from "../../Interfaces/typevieaje.interface";
import type { Cliente, PermisoViajeParticipantExternal } from "@/models/types";
import { useTipoDocumentoExternalStore } from "@/store/external/tipo-documento.external";
import { useNacionalidadExternalStore } from "@/store/external/nacionalidad.external";
import { useUbigeoExternalStore } from "@/store/external/ubigeo.external";
import { useCloseModal } from "@/hooks/useUtils";
import { usePermisoViajeExternalStore } from "../../../../../store/external/permiso-viaje.external";
import { ToolTip } from "../../../../../components/Index";

const { TipoDocumentos } = toRefs(useTipoDocumentoExternalStore());
const { ZonaRegistrales } = toRefs(useZonaRegistralStore());
const { Nacionalidades } = toRefs(useNacionalidadExternalStore());
const { Ubigeos } = toRefs(useUbigeoExternalStore());
const { searchUbigeo } = useUbigeoExternalStore();
const { findClienteByDocument } = usePermisoViajeExternalStore();

const { onFocusInput } = useInputsEvents();

const condicionRef = ref();
const maxDate = ref<string>("");
const searchUbigeos = ref<string>();
const SelectUbigeo = ref<Ubigeo | undefined>(undefined);
const isSubmit = ref<boolean>(false);
const isSubmitFindByDocument = ref<boolean>(false);
const { currentDateMax } = useDate();
const yearMax = 5;

const props = defineProps({
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<IParamsDeleteParticipant>,
    },
});

const isRepresentant = computed(() => {
    return (
        parseInt(condicionRef.value?.modelValue) ===
        VALID_PARTICPANT_REPRESENTANTE
    );
});

const sede_registral_validator = field<string | null | undefined>("", () => {
    return isRepresentant.value
        ? Yup.string()
              .required("es requerido")
              .max(50, "máximo 50 caracteres")
              .nullable()
        : Yup.string().max(50, "máximo 50 caracteres").nullable();
});

const num_partida_validator = field<string | null | undefined>("", () => {
    return isRepresentant.value
        ? Yup.string()
              .required("es requerido")
              .max(50, "máximo 50 caracteres")
              .nullable()
        : Yup.string().max(50, "máximo 50 caracteres").nullable();
});

const form = defineForm({
    with_signature: field<boolean>(false, Yup.boolean().nullable()),
    age: field<string | null>(
        "",
        Yup.string().required("es requerido").nullable()
    ),
    type: field<number | null | undefined>(
        null,
        Yup.string().required("es requerido").nullable()
    ),
    num_partida: num_partida_validator,
    sede_registral: sede_registral_validator,
    cliente: {
        s_codigo: field<string | null | undefined>("", Yup.string().nullable()),
        name: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .matches(RegExps.compositeName, "Nombre no válido")
                .min(3, "minimo 3")
                .max(50, "máximo 50 caracteres")
        ),
        paternal: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .matches(RegExps.compositeName, "Apellido no válido")
                .min(3, "minimo 3 caracteres")
                .max(50, "máximo 50 caracteres")
        ),
        maternal: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .matches(RegExps.compositeName, "Apellido no válido")
                .min(3, "minimo 3")
                .max(50, "máximo 50 caracteres")
        ),
        type_doc: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .max(50, "máximo 50 caracteres")
        ),
        num_doc: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                //.matches(RegExps.isNumeric, "Documento no válido")
                .min(4, "minimo 4")
                .max(30, "máximo 30 caracteres")
        ),
        address: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .min(4, "minimo 4")
                .max(150, "máximo 150 caracteres")
        ),
        status_civil: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .max(20, "máximo 20 caracteres")
        ),
        locality: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .max(100, "máximo 100 caracteres")
        ),
        birthday: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .max(100, "máximo 100 caracteres")
                .nullable()
        ),
        sex: field<string | null | undefined>(
            "",
            Yup.string()
                .required("es requerido")
                .min(1, "minimo 1")
                .max(10, "máximo 10 caracteres")
        ),
        nationality: field<string | null>(
            "",
            Yup.string().required("es requerido").nullable()
        ),
    },
});

const emit = defineEmits(["onAddParticipant"]);

const onSubmit = () => {
    isSubmit.value = true;
    onValidateFocus();
    if (isValidForm(form)) {
        emit("onAddParticipant", {
            index: formValues.value?.index ?? null,
            participant: toObject(form),
        });
        closeParticipant();
    }
};
const { formValues } = toRefs(props);

const closeParticipant = () => {
    useCloseModal();
};

const onSelecteValue = (payload: Ubigeo) => {
    form.cliente.locality.$value = payload.s_codigo;
    SelectUbigeo.value = payload;
};

const onCalculateAge = () => {
    if (form.cliente.birthday.$value) {
        form.age.$value = useCalculateAge(form.cliente.birthday.$value) ?? "";
    }
};

const onValidateFocus = () => {
    if (form.type.$error) {
        return onFocusInput("participant.type");
    }
    if (form.cliente.type_doc.$error) {
        return onFocusInput("participant.type_doc");
    }
    if (form.cliente.num_doc.$error) {
        return onFocusInput("participant.num_doc");
    }

    if (form.cliente.paternal.$error) {
        return onFocusInput("participant.paternal");
    }
    if (form.cliente.maternal.$error) {
        return onFocusInput("participant.maternal");
    }

    if (form.cliente.name.$error) {
        return onFocusInput("participant.name");
    }
    if (form.cliente.birthday.$error) {
        return onFocusInput("participant.birthday");
    }

    if (form.age.$error) {
        return onFocusInput("participant.age");
    }

    if (form.cliente.sex.$error) {
        return onFocusInput("participant.sex");
    }

    if (form.cliente.status_civil.$error) {
        return onFocusInput("participant.status_civil");
    }
    if (form.cliente.nationality.$error) {
        return onFocusInput("participant.nationality");
    }
    if (form.cliente.locality.$error) {
        return onFocusInput("participant.distrito");
    }
    if (form.cliente.address.$error) {
        return onFocusInput("participant.address");
    }
    if (form.num_partida.$error) {
        return onFocusInput("participant.num_partida");
    }
    if (form.num_partida.$error) {
        return onFocusInput("participant.num_partida");
    }
    if (form.sede_registral.$error) {
        return onFocusInput("participant.sede_registral");
    }

    if (form.cliente.address.$error) {
        onFocusInput("participant.address");
    }
};

const init = () => {
    if (formValues.value.participant) {
        let participantPayload = formValues.value.participant;
        form.with_signature.$value = !!participantPayload.with_signature;
        form.age.$value = participantPayload.age;
        form.type.$value = participantPayload.type;
        form.num_partida.$value = participantPayload.num_partida;
        form.sede_registral.$value = participantPayload.sede_registral;
        setClienteInfo(participantPayload.cliente);

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

const setClienteInfo = (
    payload: PermisoViajeParticipantExternal,
    ignoreDocument: boolean = false
) => {
    form.cliente.birthday.$value = payload.birthday;
    form.cliente.name.$value = payload.name;
    form.cliente.paternal.$value = payload.paternal;
    form.cliente.maternal.$value = payload.maternal;
    if (!ignoreDocument) {
        form.cliente.type_doc.$value = payload.type_doc;
        form.cliente.num_doc.$value = payload.num_doc;
    }
    form.cliente.sex.$value = payload.sex;
    form.cliente.status_civil.$value = payload.status_civil;
    form.cliente.nationality.$value = payload.nationality;
    form.cliente.locality.$value = payload.locality;
    form.cliente.address.$value = payload.address;
    onCalculateAge();
};

const onFindByDocument = async () => {
    let id_doc = form.cliente.type_doc.$value;
    let num_doc = form.cliente.num_doc.$value;
    if (id_doc && num_doc) {
        try {
            isSubmitFindByDocument.value = true;
            const { status, Cliente, message } = await findClienteByDocument(
                id_doc,
                num_doc
            );
            if (status) {
                form.cliente.birthday.$value = Cliente.d_fecha_nac;
                form.cliente.name.$value = Cliente.s_nombres;
                form.cliente.paternal.$value = Cliente.s_paterno;
                form.cliente.maternal.$value = Cliente.s_materno;
                form.cliente.type_doc.$value = Cliente.id_tipo_documento;
                form.cliente.num_doc.$value = Cliente.s_num_doc;
                form.cliente.sex.$value = Cliente.s_sexo;
                form.cliente.status_civil.$value = Cliente.s_estado_civil;
                form.cliente.locality.$value = Cliente.s_localidad;
                form.cliente.address.$value = Cliente.s_direccion;
                onCalculateAge();
            }
        } catch (e) {
            setClienteInfo({}, true);
        } finally {
            setTimeout(() => {
                isSubmitFindByDocument.value = false;
            }, 1300);
        }
    }
};
const filterUbigeos = debounce(() => {
    return searchUbigeo(searchUbigeos.value);
}, 500);

onMounted(() => {
    let maxDateYear = currentDateMax(yearMax);
    maxDate.value = maxDateYear;
    init();
});

watchEffect(() => {
    init();
});
</script>

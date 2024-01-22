<template>
    <div>
        <ScrollView>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <InputSelect
                    id="personal.id_tipo_documento"
                    :items="TipoDocumentos"
                    label="Tipo Documento"
                    v-model="formValues.id_tipo_documento"
                    :validate-error="isSubmit"
                    :error-message="form.id_tipo_documento.$error?.message"
                    label-data="s_abrev"
                    value-data="s_codigo"
                    @input="onFocusInput('personal.s_numero')"
                />
                <TextInput
                    id="personal.s_numero"
                    label="Documento"
                    v-model="formValues.s_numero"
                    :validate-error="isSubmit"
                    :error-message="form.s_numero.$error?.message"
                    @keyup.enter="onFocusInput('personal.s_nombres')"
                />
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2">
                <InputSelect
                    label="Sexo"
                    :items="SexoItems"
                    :validate-error="isSubmit"
                    v-model="form.s_sexo.$value"
                    :error-message="form.s_sexo.$error?.message"
                    id="personal.s_sexo"
                    @input="onFocusInput('personal.estado_civil')"
                />

                <InputSelect
                    :items="EstadoCivilItems"
                    label="Estado Civil"
                    v-model="form.estado_civil.$value"
                    id="personal.estado_civil"
                    validate
                    :validate-error="isSubmit"
                    @input="onFocusInput('cliente.s_nombres')"
                    :error-message="form.estado_civil.$error?.message"
                />
            </div>

            <TextInput
                label="Nombres"
                id="personal.s_nombres"
                v-model="formValues.s_nombres"
                :validate-error="isSubmit"
                :error-message="form.s_nombres.$error?.message"
                @keyup.enter="onFocusInput('personal.s_nombre_seg')"
            />
            <TextInput
                id="personal.s_nombre_seg"
                label="Segundo Nombre"
                :validate-error="isSubmit"
                v-model="formValues.s_nombre_seg"
                :error-message="form.s_nombre_seg.$error?.message"
                @keyup.enter="onFocusInput('personal.s_paterno')"
            />

            <TextInput
                id="personal.s_paterno"
                label="Apellido Paterno"
                :validate-error="isSubmit"
                v-model="formValues.s_paterno"
                :error-message="form.s_paterno.$error?.message"
                @keyup.enter="onFocusInput('personal.s_materno')"
            />

            <TextInput
                id="personal.s_materno"
                label="Apellido Materno"
                :validate-error="isSubmit"
                v-model="formValues.s_materno"
                :error-message="form.s_materno.$error?.message"
                @keyup.enter="onFocusInput('personal.searchUbigeos')"
            />

            <LabelInput
                >Ubicación:
                <LabelError style="font-weight: 400" class="relative">
                    {{ form.s_distrito.$error?.message }}
                </LabelError>
            </LabelInput>

            <Center v-if="formValues.s_codigo">
                <MapPinIcon class="text-primary-500 w-5" />
                <span class="text-xs">
                    {{ SelectUbigeo?.distrito }} -
                    {{ SelectUbigeo?.provincia }} -
                    {{ SelectUbigeo?.departamento }}
                </span>
            </Center>
            <DropwdownSelect
                id="personal.searchUbigeos"
                placeholder="Filtrar ubicación"
                label="distrito"
                label2="provincia"
                label3="departamento"
                @keyup="filterUbigeos"
                @onSelecteValue="onSelecteValue"
                v-model="searchUbigeos"
                :data="ubigeoStore.Ubigeos"
                @keyup.enter="onFocusInput('s_direccion')"
            />

            <TextInput
                id="personal.s_direccion"
                label="Direccion"
                :validate-error="isSubmit"
                v-model="formValues.s_direccion"
                :error-message="form.s_direccion.$error?.message"
                @keyup.enter="onFocusInput('s_mail')"
            />

            <TextInput
                id="personal.s_mail"
                label="Email"
                :validate-error="isSubmit"
                v-model="formValues.s_mail"
                :error-message="form.s_mail.$error?.message"
                @keyup.enter="onFocusInput('s_user')"
            />

            <TextInput
                id="personal.s_user"
                label="User"
                :validate-error="isSubmit"
                v-model="formValues.s_user"
                :error-message="form.s_user.$error?.message"
            />


            <TextInput
                autocomplete="off"
                name="personal.s_pass"
                id="personal.s_pass"
                type="password"
                label="Clave"
                :validate-error="isSubmit"
                v-model="formValues.s_pass"
                :error-message="form.s_pass.$error?.message"
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
    TextInput,
    InputSelect,
    Row,
    LabelInput,
    LabelError,
    DropwdownSelect,
} from "../../../../components";
import * as Yup from "yup";
import { defineForm, field, isValidForm, toObject } from "vue-yup-form";
import { RegExps } from "../../../../utils/Regexs";
import { type PropType, toRefs, watchEffect, ref } from 'vue';
import { useTipoDocumentoStore } from "../../../../store/tipo-documento";
import { useUbigeoStore } from "../../../../store/ubigeo";
import { debounce } from "../../../../utils/debounce";
import type { Ubigeo } from "../../../../models/ubigeo";
import { MapPinIcon } from "@heroicons/vue/20/solid";
import type { Permission, Role, User } from "@/models/types";
import { useInputsEvents } from "../../../../hooks/useInputsEvents";
import { SexoItems } from "@/services/SexoService";
import { EstadoCivilItems } from "@/services/EstadoCivilService";

const { TipoDocumentos } = toRefs(useTipoDocumentoStore());
const ubigeoStore = useUbigeoStore();
const searchUbigeos = ref<string>();
const SelectUbigeo = ref<Ubigeo | undefined>(undefined);
const isSubmit = ref<boolean>(false);
const { onFocusInput } = useInputsEvents();

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<User>,
    },
});

const emit = defineEmits(["onSubmit"]);
const { formValues, disabled } = toRefs(props);

const form = defineForm({
    s_nombres: field<string | null | undefined | unknown>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, {
                excludeEmptyString: true,
                message: "Nombre no válido",
            })
            .min(3, "minimo 3")
            .max(70, "máximo 70 caracteres")
            .nullable()
    ),
    s_nombre_seg: field<string | null | undefined | unknown>(
        "",
        Yup.string()
            //.required("es requerido")
            .matches(RegExps.compositeName, "Nombre no válido")
            .max(70, "máximo 70 caracteres")
            .nullable()
    ),
    s_paterno: field<string | null | undefined | unknown>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .min(3, "minimo 3 caracteres")
            .max(50, "máximo 50 caracteres")
    ),
    s_materno: field<string | null | undefined | unknown>(
        "",
        Yup.string()
            //.required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    id_tipo_documento: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .max(50, "máximo 50 caracteres")
            .nullable()
    ),
    s_numero: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .matches(RegExps.isNumeric, "Documento no válido")
            .min(8, "minimo 8")
            .max(12, "máximo 12 caracteres")
            .nullable()
    ),
    s_direccion: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(4, "minimo 4")
            .max(100, "máximo 100 caracteres")
    ),
    s_mail: field<string | null | undefined | unknown>(
        "",
        Yup.string()
            .required("es requerido")
            .email("Email Válido")
            .min(5, "minimo 5")
            .max(70, "máximo 70 caracteres")
    ),
    s_user: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(20, "máximo 20 caracteres")
    ),
    s_distrito: field<string | null | undefined>(
        "",
        Yup.string().required("es requerido").nullable()
    ),
    roles: field<Role[]>([]),
    permissions: field<Permission[]>([]),
    s_pass: field<string | null | undefined>(
        "",
        formValues.value.s_codigo
            ? Yup.string().min(3, "minimo 3").max(250, "máximo 250 caracteres")
            : Yup.string()
                  .required("es requerido")
                  .min(3, "minimo 3")
                  .max(250, "máximo 250 caracteres")
    ),
    s_sexo: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(1, "minimo 1")
            .max(1, "máximo 1 caracteres")
            .nullable()
    ),
    estado_civil: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(20, "máximo 20 caracteres")
    ),
});

const onSubmit = () => {
    isSubmit.value = true;
    onValidateFocus();
    if (isValidForm(form)) {
        emit("onSubmit", toObject(form));
    }
};

const init = (payload: User) => {
    form.s_nombres.$value = payload.s_nombres;
    form.s_nombre_seg.$value = payload.s_nombre_seg;
    form.s_paterno.$value = payload.s_paterno;
    form.s_materno.$value = payload.s_materno;
    form.s_direccion.$value = payload.s_direccion;
    form.s_mail.$value = payload.s_mail;
    form.s_user.$value = payload.s_user;
    form.id_tipo_documento.$value = payload.id_tipo_documento;
    form.s_numero.$value = payload.s_numero;
    form.s_distrito.$value = payload.s_distrito;
    form.roles.$value = payload.roles;
    form.permissions.$value = payload.permissions;
    form.s_pass.$value = payload.s_pass;
    form.s_sexo.$value = payload.s_sexo;
    form.estado_civil.$value = payload?.estado_civil;
    /**@ts-ignore */
    SelectUbigeo.value = payload.ubigeo;
};

const onValidateFocus = () => {
    if (form.id_tipo_documento.$error) {
        return onFocusInput("personal.id_tipo_documento");
    }
    if (form.s_numero.$error) {
        return onFocusInput("personal.s_numero");
    }
    if (form.s_nombres.$error) {
        return onFocusInput("personal.s_nombres");
    }
    if (form.s_nombre_seg.$error) {
        return onFocusInput("personal.s_nombre_seg");
    }
    if (form.s_paterno.$error) {
        return onFocusInput("personal.s_paterno");
    }
    if (form.s_materno.$error) {
        return onFocusInput("personal.s_materno");
    }

    if (form.s_distrito.$error) {
        return onFocusInput("personal.searchUbigeos");
    }

    if (form.s_direccion.$error) {
        return onFocusInput("personal.s_direccion");
    }
    if (form.s_mail.$error) {
        return onFocusInput("personal.s_mail");
    }
    if (form.s_user.$error) {
        return onFocusInput("personal.s_user");
    }

    if (form.s_pass.$error) {
        return onFocusInput("personal.s_pass");
    }
    if (form.s_sexo.$error) {
        return onFocusInput("personal.s_sexo");
    }
    if (form.estado_civil.$error) {
        return onFocusInput("personal.estado_civil");
    }
};

const filterUbigeos = debounce(() => {
    return ubigeoStore.searchUbigeo(searchUbigeos.value);
}, 500);

const onSelecteValue = (e: Ubigeo) => {
    formValues.value.s_distrito = e.s_codigo ?? "";
    SelectUbigeo.value = e;
};

watchEffect(() => {
    if (formValues?.value) {
        init(formValues.value);
    }
});
</script>

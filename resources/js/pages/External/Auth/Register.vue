<template>

    <div
        class="grid md:gap-6 md:mx-2 lg:mx-36  grid-flow-row lg:grid-flow-col grid-cols-1 md:grid-cols-2 lg:grid-cols-2   ">
        <div>
            <div
                class="py-4 md:shadow-lg px-4  md:px-10"
            >

                <div class="mb-8 flex flex-col ">
                    <h1 class="text-xl text-primary font-bold pb-5">REGISTRO DE USUARIO</h1>
                    <span class="text-gray-500">NUEVO ACCESO</span>
                </div>
                <form>
                    <TextInput
                        label="Correo"
                        v-model="form.email.$value"
                        :validate-error="isSubmit"
                        id="register.email"
                        @keyup.enter="onFocusInput('register.id_tipo_documento')"
                        :error-message="form.email.$error?.message"
                    />
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <InputSelect
                            :items="TipoDocumentos"
                            label="Tipo Documento"
                            v-model="form.id_tipo_documento.$value"
                            :validate-error="isSubmit"
                            :error-message="form.id_tipo_documento.$error?.message"
                            label-data="s_abrev"
                            value-data="s_codigo"
                            id="register.id_tipo_documento"
                            @input="onFocusInput('register.documento')"
                            @onGetLabel="onGetLabel"
                        />

                        <TextInput
                            label="Documento"
                            v-model="form.documento.$value"
                            :validate-error="isSubmit"
                            id="register.documento"
                            @keyup.enter="onFocusInput('register.documento')"
                            :error-message="form.documento.$error?.message"
                        />
                    </div>
                    <TextInput
                        :label="isPersonJuridic?'Razón Social':'Nombres'"
                        v-model="form.nombres.$value"
                        :validate-error="isSubmit"
                        id="register.nombres"
                        @keyup.enter="onFocusInput('register.paterno')"
                        :error-message="form.nombres.$error?.message"
                    />
                    <div class="grid grid-cols-1 md:grid-cols-2" v-if="!isPersonJuridic">
                        <TextInput
                            label="Apellido Paterno"
                            v-model="form.paterno.$value"
                            :validate-error="isSubmit"
                            id="register.paterno"
                            @keyup.enter="onFocusInput('register.materno')"
                            :error-message="form.paterno.$error?.message"
                        />
                        <TextInput
                            label="Apellido Materno"
                            v-model="form.materno.$value"
                            :validate-error="isSubmit"
                            id="register.materno"
                            @keyup.enter="onFocusInput('register.numero')"
                            :error-message="form.materno.$error?.message"
                        />
                    </div>

                    <TextInputNumber
                        label="Numero de Celular"
                        v-model="form.numero.$value"
                        :validate-error="isSubmit"
                        id="register.numero"
                        @keyup.enter="onFocusInput('register.numero')"
                        :error-message="form.numero.$error?.message"
                    />
                    <div class="grid grid-cols-1 md:grid-cols-2">
                        <TextInput
                            label="Cree una contraseña"
                            v-model="form.password1.$value"
                            :validate-error="isSubmit"
                            id="register.password1"
                            @keyup.enter="onFocusInput('register.password2')"
                            :error-message="form.password1.$error?.message"
                            type="password"
                            autocomplete="off"
                        />
                        <TextInput
                            label="Repita la contraseña"
                            v-model="form.password2.$value"
                            :validate-error="isSubmit"
                            id="register.password2"
                            @keyup.enter="onFocusInput('register.accept')"
                            :error-message="form.password2.$error?.message"
                            type="password"
                            autocomplete="off"
                        />
                    </div>
                    <div class="flex items-center gap-2">
                        <input
                            id="register.accept"
                            aria-describedby="register.accept"
                            type="checkbox"
                            class="checkbox text-3xl checkbox-secondary bg-base-100 "
                            required
                            v-model="form.accept.$value"

                        />

                        <label
                            for="register.accept"
                            class="cursor-pointer text-xs"
                        >Acepto Términos y Condiciones y otorgo mi consentimiento para el tratamiento de mis datos
                            personales</label
                        >
                    </div>
                    <div v-if="!form.accept.$value" class="mt-4 alert alert-warning">
                        <svg xmlns="http://www.w3.org/2000/svg" class="stroke-current shrink-0 h-6 w-6" fill="none" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                        <span>Debes aceptar los términos y condiciones para continuar con el registro.</span>
                    </div>

                    <div class="mt-8 flex justify-center  ">

                        <router-link
                            to="acceder"
                            class="btn btn-primary btn-ghost"
                        >
                            Acceder
                        </router-link>
                        <BtnSave
                            type="button"
                            :disabled="loading"
                            @click.prevent="onSubmit"
                            class="btn btn-primary"
                            :showIcon="false"
                            :loading="loading"
                            text="Registrar"
                        />
                    </div>
                </form>

            </div>
        </div>

        <div class=" ">
            <div class="card w-full bg-base-100 shadow-xl">

                <div class="card-body">
                    <h2 class="card-title text-primary">
                        <AlertIcon/>
                        ¿Por qué registrarme?
                    </h2>
                    <p>Es importante estar registrado, porque las constancias de pago serán enviadas a tu correo
                        electrónico, así mismo podrás revisar tu historial de trámites desde la opción "Mis
                        trámites".</p>
                </div>
            </div>
        </div>

    </div>


</template>
<script setup lang="ts">
import {InputSelect, Row, TextInput,BtnSave} from "@/components";
import {computed, onMounted, ref, toRefs} from "vue";
import axios from "axios";
import {useSesionStore} from "@/store/sesion";
import {useRouter} from "vue-router";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import * as yup from "yup";
import {notify} from "@kyvg/vue3-notification";
import {useConfiguracionStore} from "@/store/configuracion";
import ServiceStorage from "@/services/LocalStorageService";
import {useTipoDocumentoExternalStore} from "@/store/external/tipo-documento.external";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import AlertIcon from "vue-material-design-icons/Alert.vue"
import {useAuthExternalStore} from "@/store/external/auth.external";
import {VALID_PARTICPANT_REPRESENTANTE} from "@/services/ParticipanteService";
import * as Yup from "yup";
import {RegExps, validateMaxDigits} from "@/utils/Regexs";
import TextInputNumber from "@/components/TextInputNumber.vue";


const SEARCH_JURIDIC_DOCUMENT = ['RUC', 'R.U.C']
const {onFocusInput} = useInputsEvents()
const loading = ref<boolean>(false);
const remember = ref<boolean>(false);
const router = useRouter();
const sesion = useSesionStore();
const {listarConfiguracion} = useConfiguracionStore();
const {listarTipoDocumentosActivos} = useTipoDocumentoExternalStore();
const {TipoDocumentos} = toRefs(useTipoDocumentoExternalStore());
const { register } = useAuthExternalStore()
const isSubmit = ref<boolean>(false);
const tipo_doc_juridic = ref<string>('');

const isPersonJuridic = computed(() => {
    return SEARCH_JURIDIC_DOCUMENT.includes(tipo_doc_juridic.value);
});

const name_validator = field<string | null | undefined>("", () => {
    return !isPersonJuridic.value
        ? Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Nombre no válido")
            .max(50, "máximo 50 caracteres")
            .nullable()
        : Yup.string().required("es requerido").max(50, "máximo 50 caracteres").nullable();
});
const paternal_validator = field<string | null | undefined>("", () => {
    return !isPersonJuridic.value
        ? Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .max(50, "máximo 50 caracteres")
            .nullable()
        : Yup.string().max(50, "máximo 50 caracteres").nullable();
});
const maternal_validator = field<string | null | undefined>("", () => {
    return !isPersonJuridic.value
        ? Yup.string()
            .required("es requerido")
            .matches(RegExps.compositeName, "Apellido no válido")
            .max(50, "máximo 50 caracteres")
            .nullable()
        : Yup.string().max(50, "máximo 50 caracteres").nullable();
});

const password1 = field(
    "", () =>
    yup
        .string()
        .required("es requerido")
        .min(3, "minimo 3")
        .max(100, "máximo 100 caracteres")
)

const password2 =  field(
    "", () =>
    yup
        .string()
        .required("es requerido")
        .min(3, "minimo 3")
        .max(100, "máximo 100 caracteres")
        .oneOf([password1.$value], "las claves no coinciden")
)

const form = defineForm({
    id_tipo_documento: field(
        "",
        yup
            .string()
            .required("es requerido")
            .min(3, "minimo 3")
            .max(200, "máximo 200 caracteres")
    ),
    email: field(
        "",
        yup
            .string()
            .email("Correo Inválido")
            .required("es requerido")
            .min(3, "minimo 3")
            .max(100, "máximo 200 caracteres")
    ),
    documento: field(
        "",
        yup
            .string()
            .required("es requerido")
            .min(5, "mínimo 5")
            .max(20, "máximo 20 caracteres")
    ),
    nombres: name_validator,
    paterno: paternal_validator,
    materno: maternal_validator,
    numero: field<number|null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("maxDigits", "Máximo de 9 dígitos permitidos.", value => {
                return validateMaxDigits(value, 9)
            }).nullable()
    ),
    password1,
    password2,
    accept: field(
        "",
        yup
            .boolean()
            .required("es requerido")
    ),
});

const onSubmit = async () => {
    isSubmit.value = true;
    onValidateFocus()
    if(!form.accept.$value) return
    try {
        if (isValidForm(form)) {
            loading.value = true;

               const { status, message  } = await register( toObject(form))

                    if (status) {

                        notify({
                            title: "Bien Hecho!",
                            text: message,
                            type: "success",
                        });
                      //  sesion.saveUserSesion(rpta.data);
                        router.push("/acceder");
                        listarConfiguracion();
                    }

        }
    } catch (error) {
        notify({
            title: "Intentelo Nuevamente!",
            text: "Ocurrió algo!",
            type: "warn",
        });
    } finally {
        setTimeout(() => {
            loading.value = false;
        }, 1600);
    }
};
const userStorage = ServiceStorage.getKeyServiceStorage("user");
if (userStorage != null) {
    remember.value = true;
   // form.user.$value = userStorage;
}

const onGetLabel = (label) => {
    tipo_doc_juridic.value = label
}

const onValidateFocus = () => {
    if (form.id_tipo_documento.$error) {
        return onFocusInput("register.id_tipo_documento");
    }
    if (form.documento.$error) {
        return onFocusInput("register.documento");
    }
    if (form.nombres.$error) {
        return onFocusInput("register.nombres");
    }
    if (form.paterno.$error) {
        return onFocusInput("register.paterno");
    }
    if (form.materno.$error) {
        return onFocusInput("register.materno");
    }
    if (form.numero.$error) {
        return onFocusInput("register.numero");
    }
    if (form.password1.$error) {
        return onFocusInput("register.password1");
    }
    if (form.password2.$error) {
        return onFocusInput("register.password2");
    }
    if (form.accept.$error) {
        return onFocusInput("register.accept");
    }
    if (form.email.$error) {
        return onFocusInput("register.email");
    }
}

onMounted((() => {
    listarTipoDocumentosActivos()
}))
</script>


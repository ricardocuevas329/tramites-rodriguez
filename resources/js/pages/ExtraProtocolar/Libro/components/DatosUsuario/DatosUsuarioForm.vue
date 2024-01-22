<template>
    <ScrollView>
        <div class="flex">
            <DropwdownSelect
                placeholder="Buscar Solicitante..."
                label="nombre_compuesto"
                label2="s_num_doc"
                @keyup="filterEntidad"
                @onSelecteValue="onSelectedEntidad"
                v-model="searchEntidad"
                :showValue="true"
                :data="ClientsCompanies"
                @keyup.enter="filterEntidad"
                class="w-full"
                @onClear="onClearEntidad"
            />


        </div>
        <TransitionSlide>
            <div class="mx-4 mb-4">
                <h5 v-if="form.nombre.$value" class="text-sm">
                    Nombre:
                    <span class="badge badge-xs">{{ form.nombre.$value }}</span>
                </h5>
                <h5 v-if="form.paterno.$value" class="text-sm my-1">
                    Apellido Paterno:
                    <span class="badge badge-xs">{{ form.paterno.$value }}  </span>
                </h5>
                <h5 v-if="form.materno.$value" class="text-sm">
                    Apellido Materno:
                    <span class="badge badge-xs">{{ form.materno.$value }}</span>
                </h5>
            </div>
        </TransitionSlide>
        <TextInput
            label="Correo"
            v-model="form.correo.$value"
            :error-message="form.correo.$error?.message"
            :validate-error="isSubmitInput"
            id="libros.correo"
        />
        <TextInputNumber
            label="Telefono"
            v-model="form.telefono.$value"
            :error-message="form.telefono.$error?.message"
            :validate-error="isSubmitInput"
            id="libros.telefono"
        />

        <div class="grid grid-cols-1 md:grid-cols-2">
            <Row>
                <TextInputNumber
                    label="RUC"
                    v-model="form.ruc.$value"
                    :error-message="form.ruc.$error?.message"
                    :validate-error="isSubmitInput"
                    id="libros.ruc"
                    @onClear="cleanRuc"
                    @keyup.enter="onFindByRuc()"
                />
                <ToolTip text="Buscar Empresa">
                    <button :disabled="isSubmitFindByDocument" @click="onFindByRuc()"
                            class="btn btn-sm btn-circle mt-6 ">
                        <MagnifyingGlassIcon/>
                    </button>
                </ToolTip>
            </Row>
            <TextInput
                label="Razon Social"
                :modelValue="empresaDataRuc?.s_nombre"
                :error-message="form.ruc_id_doc.$error?.message"
                :validate-error="isSubmitInput"
                disabled
            />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2">
            <Row>
                <TextInputNumber
                    label="Representa (DNI)"
                    v-model="form.dni_representa.$value"
                    :error-message="form.dni_representa.$error?.message"
                    :validate-error="isSubmitInput"
                    id="libros.dni_representa"
                    @onClear="cleanDniRepresenta"
                    @keyup.enter="onFindByDniRepresenta()"
                />
                <ToolTip text="Buscar Representante">
                    <button :disabled="isSubmitFindByDocument" @click="onFindByDniRepresenta()"
                            class="btn btn-sm btn-circle mt-6 ">
                        <MagnifyingGlassIcon/>
                    </button>
                </ToolTip>
            </Row>
            <TextInput
                label="Persona Natural"
                :modelValue="personaDataRepresenta?.nombre_compuesto"
                :error-message="form.dni_representa_id_doc.$error?.message"
                :validate-error="isSubmitInput"
                disabled

            />
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2">
            <Row>
                <TextInputNumber
                    label="Facturado a (RUC)"
                    v-model="form.ruc_facturado.$value"
                    :error-message="form.ruc_facturado.$error?.message"
                    :validate-error="isSubmitInput"
                    id="libros.ruc_facturado"
                    @keyup.enter="onFindByRucFacturado()"
                    @onClear="cleanRucFacturado"
                />
                <ToolTip text="Buscar Empresa">
                    <button :disabled="isSubmitFindByDocument" @click="onFindByRucFacturado()"
                            class="btn btn-sm btn-circle mt-6 ">
                        <MagnifyingGlassIcon/>
                    </button>
                </ToolTip>
            </Row>
            <TextInput
                label="Razon Social"
                :modelValue="empresaDataFacturado?.s_nombre"
                disabled
                :error-message="form.ruc_facturado_id_cod.$error?.message"
                :validate-error="isSubmitInput"
            />
        </div>
    </ScrollView>
</template>
<script setup lang="ts">
import {DropwdownSelect, Row, ScrollView, TextInput} from "@/components";
import * as Yup from "yup";
import {defineForm, field} from "vue-yup-form";
import {type PropType, ref, toRefs, watchEffect} from "vue";
import type {Cliente, Empresa} from "@/models/types";
import ToolTip from "@/components/ToolTip.vue";
import {MagnifyingGlassIcon} from "@heroicons/vue/20/solid";
import {useClienteStore} from "@/store/cliente";
import {RegExps, validateMaxDigits, validateMinDigits} from "@/utils/Regexs";
import {useEmpresaStore} from "@/store/empresa";
import TextInputNumber from "@/components/TextInputNumber.vue";
import {useInputsEvents} from "@/hooks/useInputsEvents";
import type {IFormFieldLibro} from "@/pages/ExtraProtocolar/Libro/Interfaces/libro.interface";
import {TransitionSlide} from "@morev/vue-transitions"
import {useClientCompanyStore} from "@/store/client-company";
import {debounce} from "@/utils/debounce.js";
import type {IUploadFile} from "@/models/components/upload-file.interface";

const {onFocusInput} = useInputsEvents();
const {findClienteByDni} = useClienteStore()
const {findEmpresaByRuc} = useEmpresaStore()
const {searchClientCompany} = useClientCompanyStore()
const {ClientsCompanies} = toRefs(useClientCompanyStore())

const isSubmitFindByDocument = ref<boolean>(false);
const empresaDataRuc = ref<Empresa | null>(null);
const personaDataRepresenta = ref<Cliente | null>(null);
const empresaDataFacturado = ref<Empresa | null>(null);
const isSubmitInput = ref<boolean>(false);
const searchEntidad = ref<string>('');

const props = defineProps({
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<IFormFieldLibro>,
    },
});

const {formValues} = toRefs(props);

const form = defineForm({
    dni: field<string | null>(
        "",
        Yup.string()
            .nullable()
    ),
    telefono: field<number | null>(
        null,
        Yup.number()
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("maxDigits", "Máximo de 15 dígitos.", value => {
                return validateMaxDigits(value, 15)
            }).nullable()
    ),
    nombre: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3 caracteres")
            .max(100, "máximo 100 caracteres").nullable()
    ),
    paterno: field<string | null | undefined>(
        "",
        Yup.string()
            .matches(RegExps.compositeName, "Nombre no válido")
            .max(100, "máximo 100 caracteres").nullable()
    ),
    materno: field<string | null | undefined>(
        "",
        Yup.string()
            .matches(RegExps.compositeName, "Nombre no válido")
            .max(100, "máximo 100 caracteres").nullable()
    ),
    correo: field<string | null | undefined>(
        "",
        Yup.string()
            .required("es requerido")
            .email("correo no válido")
            .min(5, "minimo 5")
            .max(100, "máximo 100 caracteres").nullable()
    ),
    ruc: field<number | null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("maxDigits", "Máximo de 11 dígitos.", value => {
                return validateMaxDigits(value, 11)
            }).nullable()
    ),
    dni_representa: field<number | null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("maxDigits", "Máximo de 8 dígitos.", value => {
                return validateMaxDigits(value, 8)
            }).nullable()
    ),
    ruc_facturado: field<number | null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .test("minDigits", "Minimo de 11 dígitos.", value => {
                return validateMinDigits(value, 11)
            })
            .test("maxDigits", "Máximo de 11 dígitos.", value => {
                return validateMaxDigits(value, 11)
            }).nullable()
    ),
    dni_id_doc: field<string>(
        '',
        Yup.string()
            .nullable()
    ),
    ruc_id_doc: field<string>(
        '',
        Yup.string()
            .required("es requerido")
            .nullable()
    ),
    dni_representa_id_doc: field<string>(
        '',
        Yup.string()
            .required("es requerido")
            .nullable()
    ),
    ruc_facturado_id_cod: field<string>(
        '',
        Yup.string()
            .required("es requerido")
            .nullable()
    ),
    files: field<IUploadFile[]>([]),
});

const onSubmit = () => {
    isSubmitInput.value = true
};

const init = (data: IFormFieldLibro) => {
    form.dni.$value = data.dni
    form.nombre.$value = data.nombre
    form.paterno.$value = data.paterno
    form.materno.$value = data.materno
    form.ruc.$value = data.ruc
    form.dni_representa.$value = data.dni_representa
    form.ruc_facturado.$value = data.ruc_facturado
    form.correo.$value = data.correo
    form.telefono.$value = data.telefono
    form.dni_id_doc.$value = data.dni_id_cod
    form.ruc_id_doc.$value = data.ruc_id_cod
    form.ruc_facturado_id_cod.$value = data.ruc_facturado_id_cod
    form.dni_representa_id_doc.$value = data.dni_representa_id_cod
    /* @ts-ignore */
    empresaDataRuc.value = {
        s_nombre: data.razon_social ? data.razon_social : ''
    }
    /* @ts-ignore */
    personaDataRepresenta.value = {
        nombre_compuesto: data.persona_natural ? data.persona_natural : ''
    }
    /* @ts-ignore */
    empresaDataFacturado.value = {
        s_nombre: data.razon_social2 ? data.razon_social2 : ''
    }

};

const setClienteInfo = (payload: Cliente | Empresa) => {
    if (payload?.s_nombres) {
        form.nombre.$value = payload.s_nombres;
        form.paterno.$value = payload.s_paterno;
        form.materno.$value = payload.s_materno;
    } else {
        form.nombre.$value = payload.s_nombre;
        form.paterno.$value = '';
        form.materno.$value = '';
    }

}


const onFindByRuc = async () => {
    let num_doc = form.ruc.$value
    if (num_doc) {

        try {
            isSubmitFindByDocument.value = true
            const {status, Empresa} = await findEmpresaByRuc(num_doc.toString())
            if (status) {
                empresaDataRuc.value = Empresa
                form.ruc_id_doc.$value = Empresa.s_codigo
            }
        } catch (e) {
            empresaDataRuc.value = null
            form.ruc_id_doc.$value = ''
        } finally {
            setTimeout(() => {
                isSubmitFindByDocument.value = false
            }, 1000)
        }
    }

}

const onFindByDniRepresenta = async () => {
    let num_doc = form.dni_representa.$value
    if (num_doc) {

        try {
            isSubmitFindByDocument.value = true
            const {status, Cliente} = await findClienteByDni(num_doc.toString())
            if (status) {
                personaDataRepresenta.value = Cliente
                form.dni_representa_id_doc.$value = Cliente.s_codigo
            }
        } catch (e) {
            form.dni_representa_id_doc.$value = ''
        } finally {
            setTimeout(() => {
                isSubmitFindByDocument.value = false
            }, 1000)
        }
    }

}



const onFindByRucFacturado = async () => {
    let num_doc = form.ruc_facturado.$value
    if (num_doc) {

        try {
            isSubmitFindByDocument.value = true
            const {status, Empresa} = await findEmpresaByRuc(num_doc.toString())
            if (status) {
                empresaDataFacturado.value = Empresa
                form.ruc_facturado_id_cod.$value = Empresa.s_codigo
            }
        } catch (e) {
            form.ruc_facturado_id_cod.$value = ''
        } finally {
            setTimeout(() => {
                isSubmitFindByDocument.value = false
            }, 1000)
        }
    }

}

const onValidateFocus = () => {
    if (form.dni.$error) {
        return onFocusInput("libros.dni");
    }
    if (form.nombre.$error) {
        return onFocusInput("libros.nombre");
    }

    if (form.correo.$error) {
        return onFocusInput("libros.correo");
    }

    if (form.telefono.$error) {
        return onFocusInput("libros.telefono");
    }

    if (form.ruc.$error) {
        return onFocusInput("libros.ruc");
    }

    if (form.materno.$error) {
        return onFocusInput("libros.materno");
    }
    if (form.paterno.$error) {
        return onFocusInput("libros.paterno");
    }

    if (form.ruc_facturado.$error) {
        return onFocusInput("libros.ruc_facturado");
    }

    if (form.dni_representa.$error) {
        return onFocusInput("libros.dni_representa");
    }

};

const onSelectedEntidad = (payload: Cliente | Empresa) => {
    form.dni.$value = payload.s_codigo;
    form.dni_id_doc.$value = payload.s_codigo;
    setClienteInfo(payload);
    searchEntidad.value = payload.nombre_compuesto
};

const onClearEntidad = (success: boolean) => {
    if (success) {
        form.dni.$value = null
        form.dni_id_doc.$value = ''
        searchEntidad.value = ''
        form.nombre.$value = '';
        form.paterno.$value = '';
        form.materno.$value = '';
    }
}

const filterEntidad = debounce(() => {
    return searchClientCompany(searchEntidad.value);
}, 500);



const cleanDniRepresenta = () => {
    if (personaDataRepresenta.value) {
        personaDataRepresenta.value.nombre_compuesto = ''
    }
    form.dni_representa_id_doc.$value = ''
}

const cleanRucFacturado = () => {
    if (empresaDataFacturado.value) {
        empresaDataFacturado.value.s_nombre = ''
    }
    form.ruc_facturado_id_cod.$value = ''
}

const cleanRuc = () => {
    if (empresaDataRuc.value) {
        empresaDataRuc.value.s_nombre = ''
    }
    form.ruc_id_doc.$value = ''

}


watchEffect(() => {
    if (formValues.value.isEdit) {
        init(formValues.value);
    }
});


defineExpose({onSubmit, form, onValidateFocus, isSubmitFindByDocument});

</script>

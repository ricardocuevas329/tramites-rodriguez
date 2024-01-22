<template>
    <Row>
        <div class="absolute badge badge-xs badge-success"> {{ librosLegalizados.length }}
            {{ librosLegalizados.length == 1 ? 'LIBRO' : 'LIBROS' }}
        </div>
    </Row>

    <ScrollView>

        <DropwdownSelect
            placeholder="Filtrar Libro"
            label="s_nombre"
            @keyup="filterLibros"
            @onSelecteValue="onSelecteValue"
            v-model="searchLibro"
            :data="servicios"
            autocomplete="off"
        />


        <div class="grid grid-cols-1 md:grid-cols-2  ">

            <TextInput
                label="Denominado"
                v-model="form.denominado.$value"
                :error-message="form.denominado.$error?.message"
                @keyup.enter="onAddLibro()"
            />

            <InputSelect v-model="form.formas.$value"
                         :items="LibroFormasItems"
                         :error-message="form.formas.$error?.message"
                         @keyup.enter="onAddLibro()"
                         label="Formas"/>

        </div>
        <div class="grid grid-cols-1 md:grid-cols-2  ">
            <div class="grid grid-cols-2">
                <TextInputNumber
                    label="N° Folios"
                    v-model="form.folios.$value"
                    :error-message="form.folios.$error?.message"
                    @keyup.enter="onAddLibro()"

                />
                <TextInputNumber
                    label="Precio"
                    v-model="form.precios.$value"
                    :error-message="form.precios.$error?.message"
                    @keyup.enter="onAddLibro()"
                />
            </div>

            <TextInputNumber
                label="Numero"
                v-model="form.numero.$value"
                :error-message="form.numero.$error?.message"
                @keyup.enter="onAddLibro()"
            />
        </div>

        <Center>
            <ToolTip position="right" text="Agregar">
                <button :disabled="!isValidForm(form)" @click="onAddLibro()"
                        class="btn btn-sm  btn-primary mt-6">
                    {{ libroSelected ? 'Actualizar' : 'Agregar' }} Libro
                    <PlusCircleIcon class="text-white w-8"/>
                </button>
            </ToolTip>
            <ToolTip position="right" text="Remover">
                <button @click="onDeletedSelected()"
                        class="btn btn-sm btn-circle mt-6 ">
                    <MinusIcon class="text-error"/>
                </button>
            </ToolTip>
        </Center>
        <ContainerTable v-if="librosLegalizados.length">
            <Table>
                <THead>
                <tr>
                    <th scope="col"></th>
                    <th scope="col">Libro</th>
                    <th scope="col">Denominado</th>
                    <th scope="col">Formas</th>
                    <th scope="col">Precio</th>
                    <th scope="col">Folios</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Numero</th>
                    <th scope="col">Total</th>
                </tr>
                </THead>
                <tbody>
                <tr
                    v-for="(item, index) in librosLegalizados"
                    :key="index"
                    class="cursor-pointer  hover:bg-base-300"
                    @click="onSelected(index, item)"
                >
                    <td @click.stop @click="onDeleteLibro(index)" class="actions cursor-pointer">
                        <ToolTip text="Eliminar Libro">
                            <TrashIcon class="text-error w-4"/>
                        </ToolTip>
                    </td>
                    <td>
                        {{ item.libro }}
                    </td>
                    <td>
                        {{ item.denominado }}
                    </td>
                    <td>
                        {{ item.formas }}
                    </td>
                    <td>
                        {{ item.precios }}
                    </td>
                    <td>
                        {{ item.folios }}
                    </td>
                    <td>
                        {{ item.cantidad }}
                    </td>
                    <td>
                        {{ item?.numero ?? '' }}
                    </td>
                    <td v-if="item.precios && item.cantidad">
                        {{ (parseInt(item.precios) * item.cantidad).toFixed(2) }}
                    </td>
                </tr>

                </tbody>
            </Table>
        </ContainerTable>
    </ScrollView>

    <div class="text-right text-xs mx-4">TOTAL: {{ total.toFixed(2) }}</div>

</template>
<script setup lang="ts">
import {
    Center,
    ContainerTable,
    DropwdownSelect,
    InputSelect,
    Row,
    ScrollView,
    Table,
    TextInput,
    TextInputNumber,
    THead,
    ToolTip
} from "@/components";
import * as Yup from "yup";
import {defineForm, field, isValidForm, toObject} from "vue-yup-form";
import {computed, type PropType, ref, toRefs, watchEffect} from "vue";
import {MinusIcon, PlusCircleIcon, TrashIcon} from "@heroicons/vue/20/solid";
import {LibroFormasItems} from "@/services/LibroService";
import {validateMaxDigits} from "@/utils/Regexs";
import type {IFormFieldLibro, IlibrosLegalizados} from "@/pages/ExtraProtocolar/Libro/Interfaces/libro.interface";
import {notify} from "@kyvg/vue3-notification";
import type {Servicio} from "@/models/types";
import {debounce} from "@/utils/debounce.js";
import {useLibroStore} from "@/store/libro";


const {filterLibro, getPrice} = useLibroStore()
const {servicios} = toRefs(useLibroStore())
const librosLegalizados = ref<IlibrosLegalizados[]>([]);
const libroSelected = ref<IlibrosLegalizados | null>();
const indexSelected = ref<number>(0);
const searchLibro = ref<string>('');
const isSubmit = ref<boolean>(false);

const props = defineProps({
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<IFormFieldLibro>,
    },
});


const form = defineForm({
    libro: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .max(60, "máximo 60 caracteres").nullable()
    ),
    denominado: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3 caracteres")
            .max(800, "máximo 800 caracteres").nullable()
    ),
    formas: field<string | null>(
        "",
        Yup.string()
            .required("es requerido")
            .min(3, "minimo 3 caracteres")
            .max(60, "máximo 60 caracteres").nullable()
    ),
    folios: field<number | null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .min(1, "Mínimo 1")
            .test("maxDigits", "Máximo de 10 dígitos permitidos.", value => {
                return validateMaxDigits(value, 10)
            }).nullable()
    ),
    precios: field<number | null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .min(1, "Mínimo 1")
            .test("maxDigits", "Máximo de 10 dígitos permitidos.", value => {
                return validateMaxDigits(value, 10)
            }).nullable()
    ),
    cantidad: field<number | null>(
        1,
        Yup.number()
            .transform((value) => Number.isNaN(value) ? null : value)
            .min(1, "Mínimo 1")
            .test("maxDigits", "Máximo de 10 dígitos permitidos.", value => {
                return validateMaxDigits(value, 10)
            }).nullable()
    ),
    numero: field<number | null>(
        null,
        Yup.number()
            .required("es requerido")
            .transform((value) => Number.isNaN(value) ? null : value)
            .min(1, "Mínimo 1")
            .test("maxDigits", "Máximo de 20 dígitos permitidos.", value => {
                return validateMaxDigits(value, 20)
            }).nullable()
    ),


});


const {formValues} = toRefs(props);

const cleanData = () => {
    libroSelected.value = null
    indexSelected.value = 0
    form.libro.$value = '';
    form.denominado.$value = '';
    form.formas.$value = '';
    form.precios.$value = null;
    form.folios.$value = null;
    form.numero.$value = null;
    searchLibro.value = ''
};

const setForm = (selected: IlibrosLegalizados) => {
    form.libro.$value = selected.libro
    form.denominado.$value = selected.denominado
    form.formas.$value = selected.formas
    form.precios.$value = selected.precios ?? null
    form.cantidad.$value = selected.cantidad
    form.folios.$value = selected.folios
    form.numero.$value = selected.numero
};


const onAddLibro = () => {
    isSubmit.value = true
    if (isValidForm(form)) {

        if (libroSelected.value) {
            notify({
                title: "Bien Hecho!",
                text: "Libro Actualizado!",
                type: "success"
            })
            librosLegalizados.value[indexSelected.value] = toObject(form)
            cleanData()
            return
        }
        notify({
            title: "Bien Hecho!",
            text: "Libro Agregado!",
            type: "success"
        })
        librosLegalizados.value.push(toObject(form))
        cleanData()
    }
}

const onDeletedSelected = () => {
    libroSelected.value = null
    cleanData()
}

const onSelected = (index: number, selected: IlibrosLegalizados) => {
    indexSelected.value = index
    libroSelected.value = selected
    setForm(selected)
}

const onDeleteLibro = (index: number) => {
    librosLegalizados.value.splice(index, 1)
    libroSelected.value = null
}


const filterLibros = debounce(() => {
    return filterLibro(searchLibro.value);
}, 500);

const onSelecteValue = async (payload: Servicio) => {
    form.libro.$value = payload.s_codigo
    form.denominado.$value = payload.s_nombre
    const {arancel, status} = await getPrice(form.libro.$value)
    if (status) {
        form.precios.$value = arancel.de_precio ?? null
    }
};

const total = computed(() => {
    if (librosLegalizados.value.length) {
        return librosLegalizados.value.reduce((total, producto) => {
            const precio = producto.precios ?? '0';
            const cantidad = 1;
            return total + (parseFloat(precio) * cantidad);
        }, 0);
    }
    return 0
})

const init = async (data: IlibrosLegalizados[]) => {
    librosLegalizados.value = data;
}

watchEffect(() => {
    if (formValues.value.isEdit) {
        if (formValues.value.libros_legalizados?.length) {
            init(formValues.value?.libros_legalizados);
        }
    }
});

defineExpose({librosLegalizados, total});

</script>

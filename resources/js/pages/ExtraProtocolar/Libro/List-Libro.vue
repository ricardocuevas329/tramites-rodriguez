<template>
    <Container>
        <Card>
            <Title>Libros ({{ pagination?.total }})</Title>
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4  gap-2 my-4"
            >
                <div
                    class="col-span-3 md:col-span-2 lg:col-span-2 xlg:col-span-2"
                >
                    <TextInputSearch
                        @input="filter()"
                        @keyup="filter()"
                        v-model="search"
                        placeholder="Buscar..."
                    />
                </div>
                <div class="col-span-1">
                    <Options text="Opciones">
                        <div class="lg:mx-1 lg:px-1 mx-2 px-3 py-1">
                            <MenuItem v-slot="{ active }" @click="filter()">
                                <Item :active="active">
                                    <RefreshIcon
                                        :active="active"
                                        class="mr-2 h-5 w-5 text-violet-400"
                                        aria-hidden="true"
                                    />
                                    Refrescar
                                </Item>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <Item :active="active">
                                    <DeleteIcon
                                        :active="active"
                                        class="mr-2 h-5 w-5 text-violet-400"
                                        aria-hidden="true"
                                    />
                                    Exportar
                                </Item>
                            </MenuItem>
                            <MenuItem v-slot="{ active }">
                                <Item :active="active">
                                    <DeleteIcon
                                        :active="active"
                                        class="mr-2 h-5 w-5 text-violet-400"
                                        aria-hidden="true"
                                    />
                                    Archivar
                                </Item>
                            </MenuItem>
                        </div>
                    </Options>
                </div>
                <div class="md:text-end lg:text-right">
                    <BtnAdd
                        text="Nuevo"
                        :path="configExtraProtocolar._LIBRO_.add.path"
                    />
                </div>
            </div>

            <ContainerTable v-if="!isLoading">
                <Table>
                    <THead>
                    <tr>
                        <th scope="col" class="px-6">Acciones</th>
                        <th scope="col" class=" ">Imp.</th>
                        <th scope="col" class=" ">Pagos</th>
                        <th scope="col" class=" ">Registro</th>
                        <th scope="col" class=" ">F.Apertura</th>
                        <th scope="col" class=" ">RUC</th>
                        <th scope="col" class=" ">Razon Social</th>
                        <th scope="col" class=" ">Denominacion</th>
                        <th scope="col" class=" ">N°</th>
                        <th scope="col" class=" ">Formas</th>
                        <th scope="col" class="  ">Folios</th>
                        <th scope="col" class=" ">Solicitante</th>
                    </tr>
                    </THead>
                    <tbody>
                    <tr
                        v-for="(item, index) in Libros"
                        :key="index"
                        class="cursor-pointer  hover:bg-base-300"
                        @click="goDetail(item)"
                    >
                        <td class=" flex actions">
                            <div @click.stop class="dropdown dropdown-hover dropdown-right dropdown-content  ">

                                <label tabindex="0" class="m-1">
                                    <button class="btn btn-sm btn-circle bg-base-200">
                                        <DotsVertical/>
                                    </button>
                                </label>

                                <ul tabindex="0"
                                    class="static text-xs  dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <div class="flex">

                                        <button :disabled="isDownload" @click="goDetail(item)" class="btn btn-sm btn-circle text-primary">
                                            <ToolTip position="right" text="Editar">
                                                <EditIcon/>
                                            </ToolTip>

                                        </button>

                                        <button :disabled="isDownload" @click="onAddDateOpening(item)" class="btn btn-sm btn-circle text-primary">
                                            <ToolTip position="right" text="Editar Fecha">
                                                <Calendar/>
                                            </ToolTip>
                                        </button>

                                        <button :disabled="isDownload" class="btn btn-sm btn-circle bg-base-200 text-green-400"
                                                @click="onAddDelivery(item)">
                                            <ToolTip position="right" text="Entrega">
                                                <SendCheck/>
                                            </ToolTip>
                                        </button>
                                        <button :disabled="isDownload" class="btn btn-sm btn-circle bg-base-200 text-green-400"
                                                @click="onAddObservation(item)">
                                            <ToolTip position="right" text="Observación">
                                                <Comment/>
                                            </ToolTip>

                                        </button>

                                        <button :disabled="isDownload" class="btn btn-sm btn-circle bg-base-200 text-text-success"
                                                @click="onReport(item)">
                                            <ToolTip position="right" text="Generar Reporte">
                                                <FileWord/>
                                            </ToolTip>

                                        </button>

                                        <button :disabled="isDownload" @click="onGeneratePdf(item)"
                                                class="btn btn-sm btn-circle bg-base-200 text-error">
                                            <ToolTip position="right" text="Generar Orden">
                                                <FilePdfBox/>
                                            </ToolTip>
                                        </button>
                                    </div>
                                </ul>

                            </div>

                            <button v-if="isSuperAdmin" :disabled="isDownload || !isSuperAdmin"  @click.stop @click="onGenerateDocument(item, index)" type="button"
                                    class="btn btn-sm text-primary btn-circle bg-base-200">
                                <ToolTip text="Generar Documento" position="right">
                                    <FileWord class="w-4  "/>
                                </ToolTip>
                            </button>
                            <button v-else :disabled="isDownload || item.i_imprime === 1"  @click.stop @click="onGenerateDocument(item, index)" type="button"
                                    class="btn btn-sm text-primary btn-circle bg-base-200">
                                <ToolTip text="Generar Documento" position="right">
                                    <FileWord class="w-4  "/>
                                </ToolTip>
                            </button>
                            <button @click.stop @click="changeStatus(item)" type="button"
                                    class="hidden text-red-500 dark:bg-btn-dark font-medium rounded-lg text-sm px-1 py-1 text-center mr-2 mb-2">
                                <ToolTip v-if="item.i_estado" text="Desactivar">
                                    <DeleteIcon/>
                                </ToolTip>
                                <ToolTip v-else text="Activar">
                                    <CloseIcon/>
                                </ToolTip>
                            </button>
                        </td>
                        <td>

                            <Check class="btn btn-circle   btn-xs text-green-500" v-if="item.i_imprime"/>
                            <Close class="btn btn-circle   btn-xs text-red-500" v-if="!item.i_imprime"/>
                        </td>
                        <td class="actions" @click.stop @click="onViewPayment(item)">
                            <ToolTip text="Ver Pagos" position="right">
                                <CreditCardCheckOutline class="w-4 text-success"/>
                            </ToolTip>
                        </td>

                        <td
                        >
                            {{ item.s_libro }}
                        </td>
                        <td>
                            {{ item.d_fecha_apertura }}
                        </td>
                        <td>
                            {{ item.empresa.s_num_doc }}
                        </td>
                        <td>
                            {{ item.empresa.s_nombre }}
                        </td>
                        <td>
                            {{ item.s_denominacion }}
                        </td>
                        <td>
                            {{ item.s_numero_libro }}
                        </td>
                        <td>
                            {{ item.s_forma }}
                        </td>
                        <td>
                            {{ item.s_folios }}
                        </td>
                        <td>
                            {{ item.solicitante?.nombre_compuesto }}
                        </td>
                    </tr>
                    </tbody>
                </Table>
                <ListEmpty v-if="Libros.length == 0"/>
            </ContainerTable>
            <Skeleton v-if="isLoading" :tipo="2"/>
            <Paginate
                v-if="Libros.length && !isLoading"
                :pagination="pagination"
                @paginate="listarLibros()"
            />
        </Card>
        <RouterView/>
    </Container>


    <Observation :idModalObservation="idModalObservation" :bookSelected="bookSelected"/>
    <Delivery :idModalDelivery="idModalDelivery"/>
    <Report :id="idModalReport" :books="books" :bookSelected="bookSelected"/>
    <Payment :idModalPayment="idModalPayment" :bookSelected="bookSelected"/>
    <DateOpening :idModalDateOpening="idModalDateOpening" :bookSelected="bookSelected"/>


</template>
<script setup lang="ts">
import {useRouter} from "vue-router";
import {onMounted, ref, toRefs, computed} from "vue";
import {
    BtnAdd,
    Card,
    Container,
    ContainerTable,
    Item,
    ListEmpty,
    Options,
    Paginate,
    Skeleton,
    Table,
    TextInputSearch,
    THead,
    Title,
    ToolTip
} from "@/components";
import {debounce} from "../../../utils/debounce.js";
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import type {Libro} from "@/models/types";
import {notify} from "@kyvg/vue3-notification";
import {useLibroStore} from "@/store/libro";
import CreditCardCheckOutline from "vue-material-design-icons/CreditCardCheckOutline.vue"
import Comment from "vue-material-design-icons/Comment.vue"
import FileWord from "vue-material-design-icons/FileWord.vue"
import EditIcon from "vue-material-design-icons/Pencil.vue";
import CloseIcon from "vue-material-design-icons/Close.vue";
import DeleteIcon from "vue-material-design-icons/Delete.vue";
import SendCheck from "vue-material-design-icons/SendCheck.vue";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import Check from "vue-material-design-icons/Check.vue";
import Close from "vue-material-design-icons/Close.vue";
import {DateOpening, Delivery, Observation, Payment, Report} from "./components"
import Calendar from "vue-material-design-icons/Calendar.vue";

import {MenuItem} from "@headlessui/vue";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import DotsVertical from "vue-material-design-icons/DotsVertical.vue";
import {useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";

import {useTipoDocumentoStore} from "@/store/tipo-documento";
import {useSesionStore} from "@/store/sesion";

const {
    findLibroById,
    listarLibros,
    disabledLibro,
    enabledLibro,
    cleanPagination,
    generateDocument,
    generatePDF,
    findPayment
} =
    useLibroStore();
const {Libros, isLoading, pagination, search} = toRefs(useLibroStore());


const isDownload = ref<boolean>(false);

const router = useRouter();
const idModalPayment = useGenerateKeyRandom()
const idModalObservation = useGenerateKeyRandom()
const idModalDelivery = useGenerateKeyRandom()
const idModalReport = useGenerateKeyRandom()
const idModalDateOpening = useGenerateKeyRandom()

const books = ref<Libro[]>([]);
const bookSelected = ref<Libro>();
const {listarActivos} = useTipoDocumentoStore();
const {roles} = toRefs(useSesionStore());




const isSuperAdmin = computed(() => {
    if (roles.value.length) {
        if (roles?.value.some((p) => p === "superadmin")) {
            return true;
        }
    }
});

const goDetail = async (item: Libro) => {
    await router.push({
        name: configExtraProtocolar._LIBRO_.update.name,
        params: {id: item.s_codigo},
    });
};

const changeStatus = async (item: Libro) => {
    if (!confirm("¿Estas completamente Seguro(a)?")) {
        return;
    }
    const {status, message} = item.i_estado ? await disabledLibro(item) : await enabledLibro(item);
    if (status) {
        notify({
            title: "Exito",
            text: message,
        });
        await listarLibros();
    }

};


const filter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination()
    await listarLibros();
}

const onGenerateDocument = async (item: Libro, index: number) => {
    if (isDownload.value) return
    try {
        isDownload.value = true
        await generateDocument(item)
        Libros.value[index].i_imprime = 1
    } catch (e) {
    } finally {
        setTimeout(() => {
            isDownload.value = false
        }, 1500)
    }

}

const onGeneratePdf = (item: Libro) => {
    if (isDownload.value) return
    try {
        isDownload.value = true
        generatePDF(item)
    } catch (e) {
    } finally {
        setTimeout(() => {
            isDownload.value = false
        }, 1500)
    }
}


const onAddDelivery = (item: Libro) => {
    useOpenModal(idModalDelivery)
    bookSelected.value = item
}

const onAddObservation = (item: Libro) => {
    useOpenModal(idModalObservation)
    bookSelected.value = item
}
const onAddDateOpening = (item: Libro) => {
    useOpenModal(idModalDateOpening)
    bookSelected.value = item
}
const onReport = async (item: Libro) => {
    const {status, libro} = await findLibroById(item.s_codigo.toString())
    if (status) {
        if (libro.length) {
            useOpenModal(idModalReport)
            books.value = libro
            bookSelected.value = libro[0]
        }
    }

}

const onViewPayment = async (item: Libro) => {
    useOpenModal(idModalPayment)
    if (item.s_codigo) {
        const {libro} = await findPayment(item.s_codigo)
        bookSelected.value = libro
    }

}


onMounted(() => {
    if(!Libros.value.length){
      listarLibros();
    }
    listarActivos()
});
</script>


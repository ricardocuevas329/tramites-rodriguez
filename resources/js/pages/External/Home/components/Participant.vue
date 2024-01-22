<template>
    <div class="md:mx-28">
        <div class="flex justify-between pt-4 pb-4 mt-4 mx-2">
            <div>
                <a role="button" class="btn btn-sm">Participantes</a>
            </div>

        </div>

        <div v-if="!isLoading" class="overflow-x-scroll md:overflow-x-auto lg:overflow-x-clip">
            <table class="table table-xs">
                <thead>
                    <tr>
                        <th>Accion</th>
                        <th>PARTICIPANTES</th>
                        <th>FECHA DE FIRMA</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-base-200">
                        <td>
                            <div @click.stop class="dropdown dropdown-right dropdown-content">
                                <label tabindex="0" class="m-1">
                                    <button class="btn btn-sm btn-circle bg-base-200">
                                        <DotsVertical />
                                    </button>
                                </label>

                                <ul tabindex="0"
                                    class="static text-xs dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li>
                                        <a>
                                            <DownloadOutline class="w-5 text-green-400" />
                                            Descargar Documentos
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FileExcel class="text-green-400" />
                                            Exportar a Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FilePdfBox class="text-red-500" />
                                            Exportar a PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <th>JOEL SALAS PEREZ MARIA SANCHEZ JUAN ARAGON</th>
                        <td>25/10/2023</td>
                    </tr>
                    <tr class="bg-base-200">
                        <td>
                            <div @click.stop class="dropdown dropdown-right dropdown-content">
                                <label tabindex="0" class="m-1">
                                    <button class="btn btn-sm btn-circle bg-base-200">
                                        <DotsVertical />
                                    </button>
                                </label>

                                <ul tabindex="0"
                                    class="static text-xs dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li>
                                        <a>
                                            <DownloadOutline class="w-5 text-green-400" />
                                            Descargar Documentos
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FileExcel class="text-green-400" />
                                            Exportar a Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FilePdfBox class="text-red-500" />
                                            Exportar a PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <th>JOEL SALAS PEREZ MARIA SANCHEZ JUAN ARAGON</th>
                        <td>25/11/2023</td>
                    </tr>
                    <tr class="bg-base-200">
                        <td>
                            <div @click.stop class="dropdown dropdown-right dropdown-content">
                                <label tabindex="0" class="m-1">
                                    <button class="btn btn-sm btn-circle bg-base-200">
                                        <DotsVertical />
                                    </button>
                                </label>

                                <ul tabindex="0"
                                    class="static text-xs dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li>
                                        <a>
                                            <DownloadOutline class="w-5 text-green-400" />
                                            Descargar Documentos
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FileExcel class="text-green-400" />
                                            Exportar a Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FilePdfBox class="text-red-500" />
                                            Exportar a PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <th>JOEL SALAS PEREZ MARIA SANCHEZ JUAN ARAGON</th>
                        <td>25/11/2023</td>
                    </tr>
                    <tr class="bg-base-200">
                        <td>
                            <div @click.stop class="dropdown dropdown-right dropdown-content">
                                <label tabindex="0" class="m-1">
                                    <button class="btn btn-sm btn-circle bg-base-200">
                                        <DotsVertical />
                                    </button>
                                </label>

                                <ul tabindex="0"
                                    class="static text-xs dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li>
                                        <a>
                                            <DownloadOutline class="w-5 text-green-400" />
                                            Descargar Documentos
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FileExcel class="text-green-400" />
                                            Exportar a Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FilePdfBox class="text-red-500" />
                                            Exportar a PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <th>JOEL SALAS PEREZ MARIA SANCHEZ JUAN ARAGON</th>
                        <td>25/11/2023</td>
                    </tr>
                    <tr class="bg-base-200">
                        <td>
                            <div @click.stop class="dropdown dropdown-right dropdown-content">
                                <label tabindex="0" class="m-1">
                                    <button class="btn btn-sm btn-circle bg-base-200">
                                        <DotsVertical />
                                    </button>
                                </label>

                                <ul tabindex="0"
                                    class="static text-xs dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                                    <li>
                                        <a>
                                            <DownloadOutline class="w-5 text-green-400" />
                                            Descargar Documentos
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FileExcel class="text-green-400" />
                                            Exportar a Excel
                                        </a>
                                    </li>
                                    <li>
                                        <a>
                                            <FilePdfBox class="text-red-500" />
                                            Exportar a PDF
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </td>
                        <th>JOEL SALAS PEREZ MARIA SANCHEZ JUAN ARAGON</th>
                        <td>25/11/2023</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="mx-4">
            <Paginate v-if="PermisoViajes?.length && !isLoading" :pagination="pagination" @paginate="listMyRecords()" />
        </div>
        <Skeleton v-if="isLoading" :tipo="2" />
        <Modal :id="idModal" position="modal-bottom" @onCloseModal="useCloseModal()">
            <button class="btn btn-circle absolute right-0" @click="useCloseModal()">
                <Close class="w-6" />
            </button>

            <h2 class="card-title">Participantes</h2>
            <ScrollView>
                <div v-for="(item, i) in participants" :key="i">
                    <button
                        class="group flex items-center gap-x-5 rounded-md px-2.5 py-2 transition-all duration-75 hover:bg-green-100">
                        <div class="flex h-12 w-12 items-center rounded-lg bg-base-200 group-hover:bg-green-200">
                            <PersonCircle class="w-full w-5 text-primary" />
                        </div>
                        <div class="flex flex-col items-start justify-between font-light text-gray-600">
                            <p class="text-[15px]">{{ item.rol }}</p>
                            <span class="text-xs font-light text-gray-400">
                                {{ item.name }}</span>
                        </div>
                    </button>

                    <button class="btn btn-xs">Archivos:</button>

                    <div v-for="(file, idx) in item.files" :key="idx"
                        class="flex items-center p-2 rounded justify-between space-x-2">
                        <div class="space-x-2 truncate">
                            <Attach class="w-6 fill-current inline text-primary" />
                            <span>
                                {{ file.name }}
                            </span>
                        </div>
                        <div class="avatar">
                            <div class="w-24 rounded">
                                <img v-if="file.type?.includes('image/')" :src="file.file" />
                                <FilePdfBox size="50" class="text-red-500" v-if="!file.type?.includes('image/')" />
                            </div>
                        </div>
                        <a @click="onView(file)" class="cursor-pointer text-purple-700 hover:underline">
                            VER
                        </a>
                    </div>
                    <div class="divider" v-if="participants && participants?.length - 1 != i"></div>
                </div>
            </ScrollView>
        </Modal>
        <Modal :id="idModalViewer">
            <button class="btn btn-circle absolute right-0" @click="$router.back()">
                <Close class="w-6" />
            </button>
            <DocumentViewer :src="fileSelected?.file" :extension="fileSelected?.type" />
        </Modal>
    </div>
</template>
<script lang="ts" setup>
import DownloadOutline from "@vicons/ionicons5/DownloadOutline";
import { onMounted, ref, toRefs } from "vue";
import { usePermisoViajeExternalStore } from "@/store/external/permiso-viaje.external";
import {
    DocumentViewer,
    Modal,
    Paginate,
    ScrollView,
    Skeleton,
} from "@/components";
import FileExcel from "vue-material-design-icons/FileExcel.vue";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import DotsVertical from "vue-material-design-icons/DotsVertical.vue";
import PersonCircle from "@vicons/ionicons5/PersonCircle";
import Close from "@vicons/ionicons5/Close";
import Attach from "@vicons/ionicons5/Attach";

import {
    useCloseModal,
    useGenerateKeyRandom,
    useOpenModal,
} from "@/hooks/useUtils";
import type {
    PermisoViajeDocument,
    PermisoViajeParticipantExternal,
} from "@/models/types";
import { CreditCardIcon } from "@heroicons/vue/20/solid";

const { isLoading, pagination, PermisoViajes } = toRefs(
    usePermisoViajeExternalStore()
);
const { listMyRecords } = usePermisoViajeExternalStore();
const idModal = useGenerateKeyRandom();
const idModalViewer = useGenerateKeyRandom();

const participants = ref<PermisoViajeParticipantExternal[]>();
const fileSelected = ref<PermisoViajeDocument>();

const onOpenParticipant = (participant: PermisoViajeParticipantExternal[]) => {
    participants.value = participant;
    useOpenModal(idModal);
};

const onView = (file: PermisoViajeDocument) => {
    fileSelected.value = file;
    useOpenModal(idModalViewer);
};

onMounted(() => {
    listMyRecords();
});
</script>

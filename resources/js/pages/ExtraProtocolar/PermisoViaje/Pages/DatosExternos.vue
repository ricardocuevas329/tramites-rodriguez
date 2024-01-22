<template>
  <Modal :id="idModal" @onCloseModal="$router.back()">
    <button class="btn btn-circle absolute right-0" @click="$router.back()">
      <Close class="w-6"/>
    </button>
    <DocumentViewer :extension="fileSelected?.type" :src="fileSelected?.file"/>
  </Modal>
  <Modal :id="idModalObservation">
    <button class="btn btn-circle absolute right-0   z-40" @click="useCloseModal">
      <Close class="w-6"/>
    </button>
    <Card>
      <p class="mx-2"> solicitante:
        <div class="badge badge-sm badge-accent badge-outline">{{ permisoViaje?.usuario_cliente?.nombre_compuesto }}
          {{ permisoViaje?.usuario_empresa?.nombre_compuesto }}
        </div>
      </p>

      <TextArea v-model="observation" label="Agregue Observacion"/>
      <Center>
        <BtnSave :disabled="observation.trim()==''"/>
      </Center>
    </Card>
  </Modal>
  <Modal :id="idModalView" position="modal-bottom" @onCloseModal="useCloseModal">

    <div class=" mx-auto">
      <button class="btn btn-circle absolute right-0" @click="useCloseModal">
        <Close class="w-6"/>
      </button>
      <div class="  max-full ">
        <div class="flex justify-between items-center mb-4">
          <h3 class="text-xl font-bold leading-none  ">Participantes
            <div class="badge badge-primary text-xs badge-md"> {{ participantSelected?.length }}</div>
          </h3>
          <p class="mx-2"> solicitante:
            <div class="badge badge-sm badge-accent badge-outline">{{ permisoViaje?.usuario_cliente?.nombre_compuesto }}
              {{ permisoViaje?.usuario_empresa?.nombre_compuesto }}
            </div>
          </p>
        </div>

        <div class="flow-root">
          <ScrollView>
            <ul role="list" class="divide-y divide-gray-300 dark:divide-gray-700">
              <li class="py-3 sm:py-4" v-if="participantSelected?.length"
                  v-for="(participant, key) in participantSelected" :key="key">
                <div class="flex items-center space-x-4">
                  <div class="flex-shrink-0">
                    <UserCircleIcon class="w-8 h-8 rounded-full"/>
                  </div>
                  <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                      {{ participant.rol }}
                    </p>
                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                      {{ participant.nombre_compuesto }}
                    </p>
                  </div>
                </div>

                <button class="btn my-2 btn-xs">
                  <DocumentIcon class="w-4"/>
                  Archivos:
                  <div class="badge badge-primary text-xs badge-md">
                    {{ participant?.files?.length }}
                  </div>
                </button>

                <div class="mt-4 flex justify-center  "
                     v-for="(p, idx) in participant?.files" :key="idx">

                  <div v-if="p.type?.includes('image/')" class="cursor-pointer" @click="onView(p)">
                    <div class="mx-2 w-16 rounded">
                      <ToolTip text="ver Imagen" position="right">
                        <img alt="" :src="p.file"/>
                      </ToolTip>
                    </div>
                    <p class="flex mx-1 text-xs">
                      <DocumentTextIcon class="w-4"/>
                      {{ p.name }}
                    </p>
                    <p class="flex mx-1 text-xs">
                      <InformationCircleIcon class="w-4"/>
                      {{ p.size }} KB
                    </p>
                  </div>
                  <div v-else class="cursor-pointer" @click="onView(p)">
                    <ToolTip text="ver PDF" position="right">
                                                <span class="badge badge-ghost gap-2 text-xs truncate">
                                                  <FilePdfBox class="text-red-500"/> {{ p.name }}
                                                </span>
                    </ToolTip>
                    <p class="flex  mx-1 text-xs">
                      <InformationCircleIcon class="w-4"/>
                      {{ p.size }} KB
                    </p>
                  </div>

                </div>
              </li>
            </ul>
          </ScrollView>

        </div>
      </div>
    </div>
  </Modal>
  <ContainerTable v-if="!isLoadingExternal">
    <Table>
      <THead>
      <tr>
        <th scope="col" class="">Item</th>
        <th scope="col" class="">Solicitante</th>
        <th scope="col" class="">Fecha</th>
        <th scope="col" class="">Tipo Trámite</th>
        <th scope="col" class="">Destino</th>
        <th scope="col" class="">Transporte</th>
        <th scope="col" class="">Observacion</th>
        <th scope="col" class="">Pagos</th>
        <th scope="col" class="">Participantes</th>
        <th scope="col" class="px-3">Contacto</th>
      </tr>
      </THead>
      <tbody>
      <tr
          v-for="(item, index) in PermisoViajesExternal"
          :key="index"
          class="cursor-pointer  hover:bg-base-300"
      >
        <td class="">
          {{ item?.id }}
        </td>
        <td class="">
          {{ item.usuario_cliente?.nombre_compuesto }} {{ item.usuario_empresa?.nombre_compuesto }}
        </td>
        <td class="">
          {{ item?.created_at }}
        </td>

        <td>
          {{ item.tipo_viaje }}
        </td>
        <td>
          {{ item.route }}
        </td>
        <td>
          {{ item.tipo_transporte }}
        </td>
        <td class="">
          <button @click="onAddObservation(item)" class="btn btn-xs  btn-primary ">
            AGREGAR
          </button>
        </td>
        <td class="">
          <CreditCardIcon class="w-8 text-secondary"/>
        </td>
        <td class=" actions">
          <button @click="onViewParticipant(item)" class="btn btn-outline btn-xs btn-success">
            VER
          </button>
        </td>
        <td>
          <a target="_blank" class="flex link" :href="`https://wa.me/+51${item.phone}`">
            <PaperAirplaneIcon class="w-4 mx-1 text-[#25D366]"/>
            {{ item.phone }}
          </a>
        </td>
      </tr>
      </tbody>
    </Table>
  </ContainerTable>
  <Skeleton v-if="isLoadingExternal" :tipo="2"/>
  <Paginate
      v-if="PermisoViajesExternal?.length && !isLoadingExternal"
      :pagination="paginationExternal"
      @paginate="listarPermisoViajeExternal()"
  />
</template>
<script setup lang="ts">
import {usePermisoViajeStore} from "@/store/permiso-viaje";
import {ref, toRefs} from "vue";
import {
  BtnSave,
  Card,
  Center,
  ContainerTable,
  Modal,
  Paginate,
  ScrollView,
  Skeleton,
  Table,
  TextArea,
  THead,
  ToolTip
} from "@/components";
import {
  CreditCardIcon,
  DocumentIcon,
  DocumentTextIcon,
  InformationCircleIcon,
  PaperAirplaneIcon,
  UserCircleIcon
} from "@heroicons/vue/20/solid";
import {useCloseModal, useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import DocumentViewer from "@/components/DocumentViewer.vue";
import type {PermisoViajeDocument, PermisoViajeExternal, PermisoViajeParticipantExternal} from "@/models/types";
import Close from "@vicons/ionicons5/Close";

const {isLoadingExternal, PermisoViajesExternal, paginationExternal} = toRefs(usePermisoViajeStore());
const {listarPermisoViajeExternal} = usePermisoViajeStore();


const idModal = useGenerateKeyRandom()
const idModalView = useGenerateKeyRandom()
const idModalObservation = useGenerateKeyRandom()

const participantSelected = ref<PermisoViajeParticipantExternal[]>([])
const fileSelected = ref<PermisoViajeDocument>()
const observation = ref<string>('')
const permisoViaje = ref<PermisoViajeExternal>()


const onView = (file: PermisoViajeDocument) => {
  fileSelected.value = file
  useOpenModal(idModal);
}

const onViewParticipant = (item: PermisoViajeExternal) => {
  permisoViaje.value = item
  participantSelected.value = item.participantes
  useOpenModal(idModalView);
}

const onAddObservation = (item: PermisoViajeExternal) => {
  permisoViaje.value = item
  useOpenModal(idModalObservation)
}


</script>

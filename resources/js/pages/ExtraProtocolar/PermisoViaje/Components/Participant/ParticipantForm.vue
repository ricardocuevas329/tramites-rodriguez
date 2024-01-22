<template>
  <div>
    <Modal :id="idModal">
      <Participant
          :key="keyParticipant"
          @onAddParticipant="onAddParticipant"
          :formValues="participantForm"/>
    </Modal>
    <Row>
      <span class="btn btn-sm">Lista de participantes ({{formValues?.participantes.length}})</span>
      <BtnAdd
          @click="onOpenModalParticipante"
          icon
          text="Agregar Participante"
      />
    </Row>
    <ParticipantTableList
        @onEditParticipant="onEditParticipant"
        @onDeleteParticipant="onDeleteParticipant"
        :participants="formValues?.participantes"
        v-if="formValues?.participantes?.length"
    />
  </div>
</template>
<script setup lang="ts">
import {BtnAdd, Modal, Row} from "@/components";
import {Participant, ParticipantTableList} from "@/pages/ExtraProtocolar/PermisoViaje/Components";
import {useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";
import type {IParamsDeleteParticipant} from "@/pages/ExtraProtocolar/PermisoViaje/Interfaces/typevieaje.interface";
import type {PropType} from "vue";
import {ref} from "vue";
import type {PermisoViaje} from "@/models/types";
import {useParticipanteStore} from "@/store/participante";
import {notify} from "@kyvg/vue3-notification";

const {destroyParticipante, updateParticipante} = useParticipanteStore();
const participantForm = ref<IParamsDeleteParticipant>();
const props = defineProps({
  formValues: {
    default: {},
    require: true,
    type: Object as PropType<PermisoViaje>,
  },
});

const {formValues} = props
const keyParticipant = ref<string>('')
const newParticipante = ref<boolean>(false)
const indexParticipant = ref<number | null>(null)
const idModal = useGenerateKeyRandom()


const onOpenModalParticipante = () => {
  newParticipante.value = true
  indexParticipant.value = null
  keyParticipant.value = useGenerateKeyRandom()
  /*@ts-ignore*/
  participantForm.value = {}
  useOpenModal(idModal);
};

const onAddParticipant = async (params: IParamsDeleteParticipant) => {

  const {participant, index} = params
  if (index >= 0 && participant?.i_codigo) {
    const {status, Participante} = await updateParticipante(participant.i_codigo.toString(), participant)
    if (status) {
      return formValues.participantes[index] = Participante
    }
  }
  if (!newParticipante.value) {
    return formValues.participantes[index] = participant;
  }

  const newParticipants = [...formValues.participantes, participant];
  formValues.participantes = newParticipants;

  notify({
    title: "Participante Agregado Correctamente!",
    type: "successs"
  })

};

const onEditParticipant = async (params: IParamsDeleteParticipant) => {
  newParticipante.value = false
  indexParticipant.value = params.index
  participantForm.value = params;

  useOpenModal(idModal);
};

const onDeleteParticipant = async (params: IParamsDeleteParticipant) => {
  const {index, participant} = params;
  if(!confirm("¿Estas Completamente seguro(a)?")) return
  if (participant?.i_codigo) {
    const {status} = await destroyParticipante(participant);
    if (!status) return;
  }

  return formValues?.participantes?.splice(index, 1);
};
</script>

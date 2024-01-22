<template>
  <div>
    <Modal :id="idModal">
      <Participant
          :key="keyParticipant"
          @onAddParticipant="onAddParticipant"
          :formValues="participantForm"/>
    </Modal>
    <Row>
      <span class="btn btn-sm">Lista de participantes</span>
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
import {Participant, ParticipantTableList} from "../Index";
import {useGenerateKeyRandom, useOpenModal, useCloseModal} from "@/hooks/useUtils";
import type {PropType} from "vue";
import {ref} from "vue";
import type {
  IParamsDeleteParticipant,
  IPermisoViajeExternalFormModel
} from "@/pages/External/PermisoViaje/Interfaces/typevieaje.interface";

const participantForm = ref<IParamsDeleteParticipant>();
const props = defineProps({
  formValues: {
    default: {},
    require: true,
    type: Object as PropType<IPermisoViajeExternalFormModel>,
  },
});

const {formValues} = props
const keyParticipant = ref<string>('')
const newParticipante = ref<boolean>(false)
const indexParticipant = ref<number|null>(null)
const idModal =  useGenerateKeyRandom()


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
  if (newParticipante.value) {
    const newParticipants = [...formValues.participantes, participant];
    return formValues.participantes = newParticipants;
  }
  formValues.participantes[index] = participant
};

const onEditParticipant = async (params: IParamsDeleteParticipant) => {
  newParticipante.value = false
  indexParticipant.value = params.index
  participantForm.value = params;
  useOpenModal(idModal);
};

const onDeleteParticipant = async (params: IParamsDeleteParticipant) => {
  const {index, participant} = params;
  return formValues?.participantes?.splice(index, 1);
};
</script>

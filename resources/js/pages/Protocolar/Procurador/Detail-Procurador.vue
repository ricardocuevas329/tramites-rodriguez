<template>
  <Container>
    <div>
      <Card>
        <Title>
          <button class="btn btn-xs btn-circle right-0"
                  @click="router.push(configProtocolar._PROCURADORES_.listar.path)">
            <i class="pi pi-arrow-left"></i>
          </button>
          Detalle Procurador
        </Title>

        <ContainerTable v-if="!isLoading">
          <Table>
            <THead>
            <tr class="text-left bg-blue">
              <th>Fecha</th>
              <th>Empresa Solicitante</th>
              <th>Solicitante</th>
              <th>Direccion</th>
              <th>Contacto</th>
            </tr>
            </THead>
            <tbody>
            <tr class="cursor-pointer hover:bg-gray-200"
                v-if="details?.s_codigo">
              <td>{{ details.d_fecha_registro }}</td>
              <td class="actions">{{
                  details.facturado_cliente?.nombre_compuesto
                }}{{ details.facturado_empresa?.nombre_compuesto }}
              </td>
              <td class="actions">{{
                  details.referente_cliente?.nombre_compuesto
                }}{{ details.referente_empresa?.nombre_compuesto }}
              </td>
              <td class="actions">{{
                  details.referente_cliente?.s_direccion
                }}{{ details.referente_empresa?.s_direccion }}
              </td>
              <td class="actions">{{
                  details.contacto_cliente?.nombre_compuesto
                }}{{ details.contacto_empresa?.nombre_compuesto }}
              </td>
            </tr>
            </tbody>
          </Table>
        </ContainerTable>
        <Skeleton v-if="isLoading" :tipo="2"/>
        <div v-if="!isLoading">
          <div class="divider"></div>
          <div class="w-full text-center">
            <button v-if="!details?.detalle_procurador?.s_date_inicio" :disabled="isSubmit" @click="onSaveInit()"
                    class="btn btn-md btn-outline mx-2 ">Iniciar
            </button>
            <button v-else :disabled="isSubmit" class="btn btn-md btn-outline mx-2 my-2 ">Inicio:
              {{ details?.detalle_procurador?.s_date_inicio }}
            </button>

            <button v-if="!details?.detalle_procurador?.s_date_fin" :disabled="isSubmit" @click="onSaveFinish()"
                    class="btn btn-md btn-outline btn-error">Finalizar
            </button>
            <button v-else :disabled="isSubmit" class="btn btn-md btn-outline btn-error">Fin
              {{ details?.detalle_procurador?.s_date_fin }}
            </button>

          </div>
          <div class="w-full text-center my-2">
            <button :disabled="isSubmit" @click="onOpenModalInit()" class="btn btn-md btn-outline mx-2 ">Subir
              Documentos
            </button>
            <button :disabled="isSubmit" @click="onOpenModalFinish()" class="btn btn-md btn-outline btn-primary">Subir
              Documentos
            </button>
          </div>

          <div>
            <TextArea :modelValue="details?.s_observacion" label="Observaciones"></TextArea>
          </div>

        </div>

      </Card>

    </div>

    <Modal :id="idModalUploadInit">
      <div class="flex my-2">
        <BtnBack @click="useCloseModal()"/>
        <div role="tablist" class="tabs tabs-boxed">
          <a @click="activeTabInit=true" role="tab" class="tab" :class="activeTabInit&&'bg-black text-white'">Subir Archivos Inicial</a>
          <a @click="activeTabInit=false"  role="tab" class="tab" :class="!activeTabInit&&'bg-black text-white '">Ver Archivos ({{details?.detalle_procurador?.documentos_init.length}})</a>
        </div>
      </div>
      <div  v-if="activeTabInit">
        <VirtualScrollForm :height="!filesInit.length?'auto':'50vh'">
          <UploaderFiles  :key="key_component" :files="filesInit"
                          endPointDelete="/api/book/document/" :maxFiles="10"
                          maxFileSize="50MB"
                          maxTotalFileSize="500MB"
                          @deleteFile="onDeleteFileInit"
                          @getFiles="onGetFilesInit"
                          accept="image/* , application/*"
                          label="Arrastra o Agrega Documentos"/>
        </VirtualScrollForm>
        <Center>
          <BtnSave :disabled="isSubmit" :loading="isSubmit" @click="onSaveUploadInit"/>
        </Center>
      </div>
      <div v-else>
          <TableDocument :data="details?.detalle_procurador?.documentos_init"/>
      </div>
    </Modal>
    <Modal :id="idModalUploadFinish">
      <div class="flex my-2">
         <BtnBack @click="useCloseModal()"/>
        <div role="tablist" class="tabs tabs-boxed">
          <a @click="activeTabFinish=true" role="tab" class="tab" :class="activeTabFinish&&'tab-active'">Subir Archivos Final</a>
          <a @click="activeTabFinish=false"  role="tab" class="tab" :class="!activeTabFinish&&'tab-active'">Ver Archivos ({{details?.detalle_procurador?.documentos_finish.length}})</a>
        </div>
      </div>
      <div  v-if="activeTabFinish">
      <VirtualScrollForm :height="!filesInit.length?'auto':'50vh'">
        <UploaderFiles  :key="key_component" :files="filesFinish"
                       endPointDelete="/api/book/document/" :maxFiles="10"
                       maxFileSize="50MB"
                       maxTotalFileSize="500MB"
                       @deleteFile="onDeleteFileFinish"
                       @getFiles="onGetFilesFinish"
                       accept="image/* , application/*"
                       label="Arrastra o Agrega Documentos"/>
      </VirtualScrollForm>
      <Center>
        <BtnSave :disabled="isSubmit" :loading="isSubmit" @click="onSaveUploadFinish"/>
      </Center>
      </div>
      <div v-else>
        <TableDocument :data="details?.detalle_procurador?.documentos_finish"/>
      </div>
    </Modal>
    <router-view></router-view>
  </Container>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
import {
  Card,
  Container,
  ContainerTable,
  Skeleton,
  Table,
  THead,
  Title,
  TextArea,
  Modal,
  UploaderFiles,
  VirtualScrollForm,
  BtnBack,
  BtnSave,
  Center
} from "@/components";
import {useRoute, useRouter} from "vue-router";
import type {Presencia} from "@/models/types";
import Button from "primevue/button";
import {useProcuradorStore} from "@/store/procurador";
import {notify} from "@kyvg/vue3-notification";
import {useCloseModal, useGenerateKeyRandom, useOpenModal} from "@/hooks/useUtils";
import {type IUploadFile} from "@/models/components/upload-file.interface";
import {configProtocolar} from "@/router/Protocolar/ProtocolarConfig";
import {TableDocument} from "./Components"

const {findProcuradoresById, saveFinish, saveInit, saveInitUpload, saveFinishUpload} = useProcuradorStore();
const details = ref<Presencia>();
const isLoading = ref<boolean>(false)
const route = useRoute()
const router = useRouter()
const cod_selected = ref<string>(route.params.id?.toString())
const isSubmit = ref<boolean>(false)
const idModalUploadInit = useGenerateKeyRandom()
const idModalUploadFinish = useGenerateKeyRandom()
const filesInit = ref<IUploadFile[]>([])
const filesFinish = ref<IUploadFile[]>([])
const key_component = ref<string>(useGenerateKeyRandom())
const activeTabInit = ref<boolean>(true)
const activeTabFinish= ref<boolean>(true)

const onSaveInit = async () => {
  isSubmit.value = true
  try {
    const {status, procurador, message} = await saveInit(cod_selected.value)
    if (status) {
      notify({
        title: 'Bien Hecho',
        text: message,
        type: 'success'
      })
      details.value = procurador
    }
  } catch (e) {
    isSubmit.value = false
  } finally {
    setTimeout(() => {
      isSubmit.value = false
    }, 1200)
  }
}
const onSaveFinish = async () => {
  isSubmit.value = true
  try {
    const {status, procurador, message} = await saveFinish(cod_selected.value)
    if (status) {
      notify({
        title: 'Bien Hecho',
        text: message,
        type: 'success'
      })
      details.value = procurador
    }
  } catch (e) {
    isSubmit.value = false
  } finally {
    setTimeout(() => {
      isSubmit.value = false
    }, 1200)
  }
}


const onSaveUploadInit = async () => {
  if(!filesInit.value.length){
    return;
  }
  isSubmit.value = true
  try {
    const {status, procurador, message} = await saveInitUpload(cod_selected.value, {
      documents: filesInit.value
    })
    if (status) {
      notify({
        title: 'Bien Hecho',
        text: message,
        type: 'success'
      })
      details.value = procurador
      cleanFormFiles()
    }
  } catch (e) {
    isSubmit.value = false
  } finally {
    setTimeout(() => {
      isSubmit.value = false
    }, 1200)
  }
}

const onSaveUploadFinish = async () => {
  if(!filesFinish.value.length){
    return;
  }
  isSubmit.value = true
  try {
    const {status, procurador, message} = await saveFinishUpload(cod_selected.value, {
      documents: filesFinish.value
    })
    if (status) {
      notify({
        title: 'Bien Hecho',
        text: message,
        type: 'success'
      })
      cleanFormFiles()
      // useCloseModal()
      details.value = procurador
    }
  } catch (e) {
    isSubmit.value = false
  } finally {
    setTimeout(() => {
      isSubmit.value = false

    }, 1200)
  }
}

const onGetFilesInit = (docs: IUploadFile[]) => {
  filesInit.value = docs
}

const onDeleteFileInit = (doc: IUploadFile) => {

}

const onGetFilesFinish = (docs: IUploadFile[]) => {
  filesFinish.value = docs
}

const onDeleteFileFinish = (doc: IUploadFile) => {

}

const onOpenModalInit = () => {

  cleanFormFiles()
  useOpenModal(idModalUploadInit)

}
const onOpenModalFinish = () => {
  cleanFormFiles()
  useOpenModal(idModalUploadFinish)

}


const cleanFormFiles = () => {
  key_component.value = useGenerateKeyRandom()
  filesFinish.value = []
  filesInit.value = []
}


onMounted(async () => {

  try {
    isLoading.value = true
    const {status, procuradores} = await findProcuradoresById(cod_selected.value)
    if (status) {
      details.value = procuradores
    }
  } catch (e) {
    isLoading.value = false
  } finally {
    isLoading.value = false
  }

});
</script>

<style scoped>

</style>

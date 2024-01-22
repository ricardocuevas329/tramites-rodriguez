<template>
  <Container>
    <div class=" grid grid-cols-1"
         :class="$route.name == configExtraProtocolar._COPIAS_CERTIFICADAS_.listar.name ? '' : 'md:grid-cols-4 lg:grid-cols-4'">
      <div class="col-span-2">
      <RouterView v-slot="{ Component}">
        <TransitionSlide>
          <component :is="Component"/>
        </TransitionSlide>
      </RouterView>
      </div>
      <div class="col-span-2 md:mx-1">
        <Card>
          <SelectedCheckCounter v-if="selecteds?.length"
          >{{ selecteds?.length }}
          </SelectedCheckCounter>
          <Title>Copias Certificadas <span v-if="pagination?.total">({{ pagination?.total }})</span></Title>

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
                <ul tabindex="0"
                    class="static  dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                  <li>
                    <a @click="filter()">
                      <RefreshIcon/>
                      Refrescar
                    </a>
                  </li>
                </ul>
              </Options>
            </div>
            <div class="md:text-end lg:text-right">
              <BtnAdd
                  text="Nuevo"
                  :path="configExtraProtocolar._COPIAS_CERTIFICADAS_.add.path"
              />
            </div>
          </div>

          <ContainerTable v-if="!isLoading">
            <Table>
              <THead>
              <tr>
                <th scope="col" class="px-6"></th>
                <th scope="col" class="">Cert</th>
                <th scope="col" class="">Empresa</th>
                <th scope="col" class="">Personal</th>
                <th scope="col" class="">Legalizado</th>
                <th scope="col" class="">Cargo</th>
                <th scope="col" class="">Libros</th>
                <th scope="col" class="">Fecha</th>

              </tr>
              </THead>
              <tbody>
              <tr v-for="(item, index) in CertifiedCopies" :key="index"
                  class="cursor-pointer  hover:bg-base-300" @click="onEdit(item)">
                <td class="relative actions">

                  <div @click.stop class="dropdown  dropdown-right  dropdown-content  ">

                    <label tabindex="0" class="  m-1">
                      <button class="btn btn-sm btn-circle bg-base-200">
                        <DotsVertical/>
                      </button>
                    </label>

                    <ul tabindex="0"
                        class="static  dropdown-content z-[50] menu p-2 shadow bg-base-100 rounded-box w-52">
                      <li>
                        <a>
                          <EditIcon @click="onEdit(item)"/></a>
                      </li>
                    </ul>

                  </div>


                </td>
                  <td class="actions">
                      <button @click.stop @click="onDownloadDocument(item)" :disabled="isDownloadDocument"
                              class="btn btn-sm btn-circle bg-base-200">
                          <ToolTip position="right"  text="Generar Documento">
                              <FileDocument />
                          </ToolTip>
                      </button>
                  </td>
                <td>
                  {{ item.empresa?.nombre_compuesto }}
                </td>
                <td>
                  {{ item.personal?.nombre_compuesto }}
                </td>


                <td>
                  {{ item?.legalizado?.nombre_compuesto }}
                </td>
                <td>
                  {{ item.s_cargo }}

                </td>
                <td class="">
                  {{ item?.s_libros }}
                </td>
                <td>
                  {{ item?.d_fecha }}
                </td>
              </tr>
              </tbody>
            </Table>
            <ListEmpty v-if="CertifiedCopies?.length == 0"/>
          </ContainerTable>
          <Skeleton v-if="isLoading" :tipo="2"/>
          <Paginate v-if="CertifiedCopies?.length && !isLoading" :pagination="pagination"
                    @paginate="listCertifiedCopies()"/>
        </Card>
      </div>
    </div>
  </Container>
</template>
<script setup lang="ts">
import {onMounted, ref, toRefs} from "vue";
import {
    BtnAdd,
    Card,
    Container,
    ContainerTable,
    ListEmpty,
    Options,
    Paginate,
    SelectedCheckCounter,
    Skeleton,
    Table,
    TextInputSearch,
    THead,
    Title, ToolTip
} from "@/components";
import {debounce} from "../../../utils/debounce.js";
import RefreshIcon from "vue-material-design-icons/Refresh.vue";
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";
import type {CopiaCertificada} from "@/models/types";
import FilePdfBox from "vue-material-design-icons/FilePdfBox.vue";
import FileExcel from "vue-material-design-icons/FileExcel.vue";
import DotsVertical from "vue-material-design-icons/DotsVertical.vue";
import EditIcon from "vue-material-design-icons/Pencil.vue";
import {TransitionSlide} from "@morev/vue-transitions";
import {useCertifiedCopyStore} from "@/store/certified-copy";
import {useRouter} from "vue-router";
import FileDocument from "vue-material-design-icons/FileDocument.vue";
import {notify} from "@kyvg/vue3-notification";

const {search, pagination, isLoading, CertifiedCopies, } = toRefs(useCertifiedCopyStore());
const {listCertifiedCopies, cleanPagination, generateDocument} =
    useCertifiedCopyStore();

const selecteds = ref<CopiaCertificada[]>();
const router = useRouter()
const isDownloadDocument = ref<boolean>(false);

const filter = debounce(() => {
  return filterData();
}, 500);

const filterData = async () => {
  cleanPagination()
  await listCertifiedCopies();
}

const onEdit = async(payload: CopiaCertificada) => {
  await router.push({
    name: configExtraProtocolar._COPIAS_CERTIFICADAS_.update.name,
    params: {
      id: payload.s_codigo,
    },
  });
}

const onDownloadDocument = async(item: CopiaCertificada) => {
    isDownloadDocument.value = true
    try {
        await generateDocument(item)
    } catch (error) {
        notify({
            title: "Ups!",
            text: "Ocurrio un error, Intentelo Nuevamente!",
            type: "warn",

        });
        isDownloadDocument.value = false
    } finally {
        setTimeout(() => {
            isDownloadDocument.value = false
        }, 1500);
    }
}

onMounted(() => {
  listCertifiedCopies();
});
</script>

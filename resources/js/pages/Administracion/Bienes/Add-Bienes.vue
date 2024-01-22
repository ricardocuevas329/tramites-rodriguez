 <template>
 <ModalRouterPage>
    <Content>
        <Head>
            <template v-slot:start>
                <BtnBack @click="router.push(configAdministracion._BIENES_.listar.path)" />
            </template>
            <template v-slot:center>
                <TitleTable>NUEVO BIEN</TitleTable>
            </template>
        </Head>
        <div class="  pb-10 hide-scroll-bar py-4 px-4">
           <FormFields :disabled="isSubmit" @onSubmit="onSubmit"/>
        </div>
    </Content>
</ModalRouterPage>
</template>

<script setup lang="ts">
import { useRouter } from "vue-router";
import {
    Content,
    TitleTable,
    Head,
ModalRouterPage,
BtnBack,
} from "../../../components";
import { notify } from "@kyvg/vue3-notification";
import { ref } from 'vue';
import { useBienStore } from '../../../store/bienes';
import FormFields from "./components/FormFields.vue";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import type { Bien } from "@/models/types";

const router = useRouter();
const isSubmit = ref<boolean>(false)
const {listarBienes, saveBien} = useBienStore();

const onSubmit = async (data: Bien) => {
    try {
        isSubmit.value = true
        const rpta = saveBien(data);
        rpta.then(async(res) => {
            if (res.status) {
                notify({
                title: "Exito",
                text: res.message,
                });
               await listarBienes();
               router.push(configAdministracion._BIENES_.listar.path)
            }
        });
    } catch (error) {
    } finally {
          setTimeout(() => {
            isSubmit.value = false
          }, 1000);
    }
};

</script>

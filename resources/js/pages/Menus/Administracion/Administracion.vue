<template>
    <Title>Administración</Title>
    <hr class="mb-4" />
    <div  v-if="roles.length || permissions.length"
        class="w-500 grid md:grid lg:grid-cols-4 md:grid-cols-4 grid-cols-1 scrollbar-thin dark:scrollbar-thumb-gray-600 scrollbar-thumb-gray-400 dark:scrollbar-track-gray-900 hover:scrollbar-thumb-primary-400"
    >
        <ButtonItem
            :disabled="checkPermission('Listar ConfiguracionGeneral')"
            text="Configuración"
            :to="configAdministracion._CONFIGURACION_.listar.path"
        >
            <Cog6ToothIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Banco')"
            text="Bancos"
            :to="configAdministracion._BANCO_.listar.path"
        >
            <BankIcon :size="35" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Bien')"
            text="Bienes"
            :to="configAdministracion._BIENES_.listar.path"
        >
            <CurrencyBangladeshiIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Area')"
            text="Areas"
            :to="configAdministracion._AREAS_.listar.path"
        >
            <Square3Stack3DIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar TipoCambio')"
            text="Tipo de Cambio"
            :to="configAdministracion._TIPOCAMBIO_.listar.path"
        >
            <CurrencyDollarIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Profesion')"
            text="Profesion"
            :to="configAdministracion._PROFESION_.listar.path"
        >
            <UserGroupIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Accion')"
            text="Accion"
            :to="configAdministracion._ACCION_.listar.path"
        >
            <UserGroupIcon class="h-8 w-8" />
        </ButtonItem>
      <ButtonItem
          :disabled="checkPermission('Listar RegistroDeposito')"
          text="Registro Deposito"
          :to="configAdministracion._REGISTRO_DEPOSITO_.listar.path"
      >
        <CreditCardIcon class="h-8 w-8" />
      </ButtonItem>
      <ButtonItem
          :disabled="checkPermission('Listar RegistroVenta')"
          text="Registro Venta"
          :to="configAdministracion._REGISTRO_VENTA_.listar.path"
      >
        <SaleIcon class="h-8 w-8" />
      </ButtonItem>
    </div>
</template>
<script setup lang="ts">
import {
    CurrencyDollarIcon,
    Cog6ToothIcon,
    Square3Stack3DIcon,
    UserGroupIcon,
    CurrencyBangladeshiIcon,
    CreditCardIcon,
} from "@heroicons/vue/20/solid";
import BankIcon from "vue-material-design-icons/Bank.vue";
import SaleIcon from "vue-material-design-icons/Sale.vue";
import { ButtonItem, Title } from "../../../components";
import { configAdministracion } from "@/router/Administracion/AdministracionConfig";
import { onMounted, toRefs } from "vue";
import type { NamePermissions } from "../../../models/namesPermissions";
import { useSesionStore } from "../../../store/sesion";

const { roles, permissions } = toRefs(useSesionStore());
const { getUserSesion } = useSesionStore();

const checkPermission = (str: NamePermissions) => {
    if(!str) return
    if (roles.value.length) {
        if (roles?.value.some((p) => p === 'superadmin')) {
            return false;
        }
    }
    if (permissions.value.length) {
        if (permissions?.value.some((p) => p === str)) {
            return false;
        }
    }
};

onMounted(() => {
    getUserSesion();
});
</script>

<template>
    <Title>Mantenimiento</Title>
    <hr class="mb-4" />
    <div  v-if="roles.length || permissions.length"
        class="w-500 grid md:grid lg:grid-cols-4 md:grid-cols-4 grid-cols-1 "
    >
      <ButtonItem
          :disabled="checkPermission('Listar Condicion')"
          text="Condicion"
          :to="configMantenimiento._CONDICION_.listar.path"
      >
        <BankIcon :size="30"/>
      </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar TipoDocumento')"
            text="Tipo Documento"
            :to="configMantenimiento._TIPO_DOCUMENTO_.listar.path"
        >
            <BankIcon :size="30" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Ubigeo')"
            text="Ubigeo"
            :to="configMantenimiento._UBIGEO_.listar.path"
        >
            <MapIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Cargo')"
            text="Cargo Publico"
            :to="configMantenimiento._CARGO_PUBLICO_.listar.path"
        >
            <MapIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Unidad')"
            text="Unidades"
            :to="configMantenimiento._UNIDADES_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar BancoDeposito')"
            text="Banco Deposito"
            :to="configMantenimiento._BANCO_DEPOSITO_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Servicio')"
            text="Servicio"
            :to="configMantenimiento._SERVICIO_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar TipoCompareciente')"
            text="Tipo Compareciente"
            :to="configMantenimiento._TIPO_COMPARECIENTE_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Nacionalidad')"
            text="Nacionalidad"
            :to="configMantenimiento._NACIONALIDAD_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Pais')"
            text="Paises"
            :to="configMantenimiento._PAIS_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar DocumentoVenta')"
            text="Documento Venta"
            :to="configMantenimiento._DOCUMENTO_VENTA_.listar.path"
        >
            <DocumentIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar ZonaRegistral')"
            text="Zona Registral"
            :to="configMantenimiento._ZONA_REGISTRAL_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Requisito')"
            text="Requisitos"
            :to="configMantenimiento._REQUISITO_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar ModoPago')"
            text="Modo Pago"
            :to="configMantenimiento._MODO_PAGO_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar Cargo')"
            text="Cargo"
            :to="configMantenimiento._CARGO_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
        <ButtonItem
            :disabled="checkPermission('Listar TipoEstado')"
            text="Estado"
            :to="configMantenimiento._ESTADO_.listar.path"
        >
            <HomeModernIcon class="h-8 w-8" />
        </ButtonItem>
    </div>
</template>
<script setup lang="ts">
import BankIcon from "vue-material-design-icons/Bank.vue";
import { ButtonItem, Title } from '../../../components';
import {
    MapIcon,
    HomeModernIcon,
    DocumentIcon,
} from "@heroicons/vue/20/solid";
import { configMantenimiento } from "../../../router/Mantenimiento/MantenimientoConfig";
import { useSesionStore } from "../../../store/sesion";
import { toRefs, onMounted } from "vue";
import type { NamePermissions } from "../../../models/namesPermissions";
import {configExtraProtocolar} from "@/router/ExtraProtocolar/ExtraProtocolarConfig";

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

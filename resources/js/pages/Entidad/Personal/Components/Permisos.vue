<template>
    <div>
        <ContainerTable>
            <TextInputSearch
                @input="onFilter()"
                @keyup="onFilter()"
                v-model="search"
                placeholder="Filtrar Permisos..."
            />
            <Center @click="selectedAll()">
                <CheckBox v-model="selectedAlls" >
                    {{ selectedAlls ? "Desmarcar Todos" : "Seleccionar Todos" }}
                </CheckBox>
            </Center>
            <ScrollView>
                <Table>
                    <tbody
                        class="grid h-52 grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xlg:grid-cols-4"
                    >
                        <tr
                            v-for="(item, index) in Permissions"
                            :key="index"
                            class="cursor-pointer hover:bg-base-300"
                            @click="
                                item.name.indexOf('Modulo') !== -1
                                    ? null
                                    : assignPermission(item)
                            "
                        >
                            <td
                                class="w-4 p-4"
                                v-if="item.name.indexOf('Modulo')"
                            >
                                <div class="flex items-center">
                                    <CheckBox :modelValue="checkSelected(item)">
                                        {{ item.name }}
                                    </CheckBox>
                                </div>
                            </td>
                            <td
                                class="px-6 py-4"
                                v-if="item.name.indexOf('Modulo')"
                            ></td>

                        </tr>
                    </tbody>
                </Table>
            </ScrollView>
        </ContainerTable>
        <Center>
            <BtnSave :disabled="disabled" @click="onSubmit" />
        </Center>
    </div>
</template>
<script setup lang="ts">
import {
    BtnSave,
    Center,
    ContainerTable,
    ScrollView,
} from "../../../../components";
import { type PropType, toRefs, watchEffect, ref } from "vue";
import type { Permission, User } from "@/models/types";
import {
    Table,
    THead,
    CheckBox,
    TextInput,
    TextInputSearch,
} from "../../../../components";
import { usePermissionStore } from "../../../../store/permission";
import { debounce } from "@/utils/debounce";

const { Permissions, search } = toRefs(usePermissionStore());
const { listarPermission, cleanPagination } = usePermissionStore();
const selectedAlls = ref<boolean>(false);
const entitySelected = ref<Permission[]>([]);

const props = defineProps({
    disabled: {
        required: true,
        type: Boolean,
        default: false,
    },
    formValues: {
        default: {},
        require: false,
        type: Object as PropType<User>,
    },
});

const emit = defineEmits(["onSubmit"]);

const { formValues } = toRefs(props);

const onSubmit = () => {
    emit("onSubmit", formValues.value);
};

const assignPermission = (payload: Permission) => {
    selectedAlls.value = false;
    let index = entitySelected.value.findIndex((obj) => obj.id === payload.id);
    if (index !== -1) {
        entitySelected.value.splice(index, 1);
    } else {
        entitySelected.value.push(payload);
    }

    if (entitySelected.value.length == Permissions.value.length) {
        selectedAlls.value = true;
    }
    formValues.value.permissions = entitySelected.value;
};

const selectedAll = () => {
    entitySelected.value = [];
    if (!selectedAlls.value) {
        selectedAlls.value = true;
        Permissions.value.map((payload) => {
            entitySelected.value.push(payload);
        });
        formValues.value.permissions = entitySelected.value;
    } else {
        selectedAlls.value = false;
        entitySelected.value = [];
        formValues.value.permissions = [];
    }
};

const checkSelected = (payload: Permission) => {
    let foundObject = formValues.value.permissions.find(
        (obj) => obj.id === payload.id
    );
    return foundObject ? true : false;
};

const onFilter = debounce(() => {
    return filterData();
}, 500);

const filterData = async () => {
    cleanPagination();
    await listarPermission();
};

watchEffect(() => {
    entitySelected.value = formValues.value.permissions;
});
</script>

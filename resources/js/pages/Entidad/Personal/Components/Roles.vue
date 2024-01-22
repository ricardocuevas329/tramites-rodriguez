<template>
    <div>
        <ContainerTable>
            <Center @click="selectedAll()">
                <CheckBox v-model="selectedAlls">
                    {{ selectedAlls ? "Desmarcar Todos" : "Seleccionar Todos" }}
                </CheckBox>
            </Center>
            <ScrollView>
                <Table>
                    <tbody
                        class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 xlg:grid-cols-4"
                    >
                        <tr
                            v-for="(item, index) in Roles"
                            :key="index"
                            class="cursor-pointer hover:bg-base-300"
                            @click="assignRole(item)"
                        >
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <CheckBox
                                        :modelValue="checkSelected(item)">{{
                                        item.name
                                    }}</CheckBox>
                                </div>
                            </td>
                            <td class="px-6 py-4"></td>
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
import type { Role, User } from "@/models/types";
import { Table, CheckBox } from "../../../../components";
import { useRoleStore } from "../../../../store/role";
const { Roles } = toRefs(useRoleStore());

const selectedAlls = ref<boolean>(false);
const entitySelected = ref<Role[]>([]);

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

const assignRole = (payload: Role) => {
    selectedAlls.value = false;
    let index = entitySelected.value.findIndex((obj) => obj.id === payload.id);
    if (index !== -1) {
        entitySelected.value.splice(index, 1);
    } else {
        entitySelected.value.push(payload);
    }

    if (entitySelected.value.length == Roles.value.length) {
        selectedAlls.value = true;
    }
    formValues.value.roles = entitySelected.value;
};

const selectedAll = () => {
    entitySelected.value = [];
    if (!selectedAlls.value) {
        selectedAlls.value = true;
        Roles.value.map((payload) => {
            entitySelected.value.push(payload);
        });
        formValues.value.roles = entitySelected.value;
    } else {
        selectedAlls.value = false;
        entitySelected.value = [];
        formValues.value.roles = [];
    }
};

const checkSelected = (payload: Role) => {
    let foundObject = formValues.value.roles.find(
        (obj) => obj.id === payload.id
    );
    return foundObject ? true : false;
};

watchEffect(() => {
    entitySelected.value = formValues.value.roles;
});
</script>

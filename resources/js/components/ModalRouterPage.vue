<template>
    <div v-if="!isComponent"
        @click="$route.meta.persistent ? null : $router.back()"
        class="modal scrollbar-none "
        :class="$route.meta.showModal ? ' modal-open '+$route.meta?.positionClassName ?? '' : 'modal-toggle'"
    >

        <ModalContent>
            <div @click.stop>
                <slot></slot>
            </div>
        </ModalContent>

    </div>
    <div v-else>
            <div @click.stop>
                <slot></slot>
            </div>
    </div>
</template>

<script lang="ts">
import ModalContent from "./ModalContent.vue";
export default {
    name: "ModalRouterPage",
    components: { ModalContent },
    props:{
       isComponent:
       {
        type: Boolean,
        default: false,
        required: false
       }
    }
};
</script>
<style>
.modal-open{
    transition: none !important;
}
.modal-toggle{
    transition: none !important;
}
</style>

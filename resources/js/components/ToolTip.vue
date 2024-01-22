<template>
    <div class=" tooltip tooltip-primary" :class="onPositionClass(position)" :data-tip="text?.toUpperCase()">
        <slot/>
    </div>

</template>
<script lang="ts">
type IPositionToolTip = 'left' | 'right' | 'top' | 'bottom'

import {defineComponent, type PropType} from "vue";

export default defineComponent({
    name: "ToolTip",
    props: {
        text: {
            type: String as PropType<String|null> ,
            required: true,
        },
        position: {
            required: false,
            type: String as PropType<IPositionToolTip>,
            default: 'left'
        }
    },
    methods:{
        onPositionClass(pos: IPositionToolTip){
            const posConfig = {
                'left' : 'tooltip-left',
                'right' : 'tooltip-right',
                'bottom' : 'tooltip-bottom',
                'top' : 'tooltip-top'
            }
            return posConfig[pos]
        }
    }
});
</script>
<style>
</style>

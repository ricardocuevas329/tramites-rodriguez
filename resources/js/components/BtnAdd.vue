<template>
    <div>
        <RouterLink v-if="path" :to="path">
            <button
                class="btn btn-primary ">
                <svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" class="mx-1"  width="20px" height="20px" viewBox="0 0 52 52"
                    enable-background="new 0 0 52 52" xml:space="preserve">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path
                            d="M43,9C33.6-0.3,18.4-0.3,9,9c-9.3,9.4-9.3,24.6,0,34c9.4,9.4,24.6,9.4,33.9,0C52.3,33.6,52.3,18.4,43,9z M42,28c0,0.6-0.4,1-1,1H30c-0.5,0-1,0.5-1,1v11c0,0.5-0.5,1-1,1h-4c-0.6,0-1-0.4-1-1V30c0-0.6-0.4-1-1-1H11c-0.6,0-1-0.4-1-1v-4 c0-0.5,0.5-1,1-1h11c0.6,0,1-0.4,1-1V11c0-0.5,0.5-1,1-1h4c0.5,0,1,0.4,1,1v11c0,0.6,0.4,1,1,1h11c0.5,0,1,0.5,1,1V28z">
                        </path>
                    </g>
                </svg>
                <span class=" ">{{ text }}</span>
            </button>
        </RouterLink>

        <div  v-if="!path" :title="text">
            <button :disabled="disabled" @click.prevent="$emit('click', $event)"
            class="btn btn-sm btn-primary" :class="icon && 'btn-circle'">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon w-6" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32" d="M256 112v288M400 256H112"/></svg>
            <span v-if="!icon" class="text-white ">{{ text }}</span>
        </button>
        </div>
    </div>
</template>

<script lang="ts">
import { defineComponent } from "vue";

export default defineComponent({
  name: "BtnAdd",
  emits: ["click"],
  props: {
    text: {
      default: "Nuevo Registro",
      type: String,
      required: false,
    },
    path: {
      default: "",
      type: String,
    },
    disabled: {
      required: false,
      default: false,
      type: Boolean,
    },
    icon: {
      required: false,
      default: false,
      type: Boolean,
    },
  },
});
</script>

<template>
  <div class="w-full lg:px-2 mb-3 relative px-1">
    <LabelInput :class="labelFull && 'flex'" v-if="showLabel">{{ label }}:</LabelInput>
    <LabelError v-if="errorMessage && validateError"
    >* {{ errorMessage?.toString() }}
    </LabelError
    >
    <div class="flex w-full">
       <textarea
           :disabled="disabled"
           :name="name"
           :id="id"
           v-bind="$attrs"
           :value="modelValue"
           :ref="myRefs"
           @input="updateInput"
           class="textarea  textarea-xs w-full  bg-base-200 flex   focus:input-primary focus:border-none   font-medium placeholder:font-normal"
           :maxLength="maxLength"
           :autocomplete="autocomplete"
           :rows="rows"
           :cols="cols"
       />
      <span
          v-if="modelValue  && !disabled"
          class="cursor-pointer flex full absolute   right-7"
          :class="showLabel ? 'top-7' : 'top-2' "
          @click="clearInput"
      >
          <CloseCircle class="w-7 text-primary rounded-lg bg-base-200"/>
        </span>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, type PropType} from "vue";
import {LabelError, LabelInput} from "@/components";
import CloseCircle from "@vicons/ionicons5/CloseCircle";

export default defineComponent({
  name: "TextArea",
  components: {CloseCircle, LabelInput, LabelError},
  props: {
    label: String,
    icon: String,
    errorMessage: {
      type: String,
      default: "",
    },
    validateError: {
      type: Boolean,
      default: true,
    },
    maxLength: Number,
    myRefs: {
      required: false,
      type: String as PropType<any>,
      default: "",
    },
    accept: {
      required: false,
      type: String,
      default: "",
    },
    name: {
      required: false,
      type: String,
      default: null,
    },
    id: {
      default: null,
      type: String,
      required: false,
    },
    modelValue: {
      type: String as PropType<any>,
      default: "",
    },
    labelFull: {
      required: false,
      type: Boolean,
      default: false,
    },
    showLabel: {
      required: false,
      type: Boolean,
      default: true,
    },
    disabled: {
      required: false,
      type: Boolean,
      default: false,
    },
    autocomplete: {
      default: null,
      type: String,
      required: false,
    },
    cols: {
      default: 10,
      type: Number,
      required: false,
    },
    rows: {
      default: 5,
      type: Number,
      required: false,
    },

  },
  methods: {
    updateInput(event: any) {
      this.$emit("update:modelValue", event.target.value);
    },
    clearInput() {
      this.$emit("onClear", true);
      this.$emit("update:modelValue", "");
    },
  },
});
</script>

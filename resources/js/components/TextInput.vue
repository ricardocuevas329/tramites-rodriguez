<template>
  <div class="w-full lg:px-2 mb-3 relative px-1">
    <LabelInput v-if="showLabel">{{ label }}:</LabelInput>
    <LabelError v-if="errorMessage && validateError">* {{ errorMessage?.toString() }}</LabelError>
    <div class="flex w-full">
      <input
          :disabled="disabled"
          :type="typeModel"
          :accept="accept"
          :name="name"
          :id="id"
          v-bind="$attrs"
          :value="modelValue"
          :ref="myRefs"
          @input="updateInput"
          class="input bg-base-200 w-full flex  focus:input-primary focus:border-none font-medium placeholder:font-normal"
          :maxLength="maxLength"
          :autocomplete="autocomplete"
          :readonly="readonly"
      />

      <span
          v-if="modelValue?.toString().trim() != '' && !disabled && !readonly"
          class="cursor-pointer flex full absolute"
          :class="[type === 'text' || type === 'password' ? 'right-3' : 'right-11', showLabel ? 'top-7' : 'top-2']"
          @click="clearInput"
      >
               <Eye v-if="typeModel=='password' && !changePassType" @click.stop
                    @click="onChangePass"
                    class="w-7 text-primary rounded-lg bg-base-200"/>
               <EyeOff v-if=" typeModel == 'text' && type=='password' && changePassType" @click.stop
                       @click="onChangePassOff"
                       class="w-7 text-primary rounded-lg bg-base-200"/>

                <CloseCircle class="w-7 text-primary rounded-lg bg-base-200"/>
            </span>
    </div>
  </div>
</template>

<script lang="ts">
import {defineComponent, type PropType} from "vue";
import {LabelError, LabelInput} from "./Index";
import CloseCircle from "@vicons/ionicons5/CloseCircle";
import Eye from "@vicons/ionicons5/Eye";
import EyeOff from "@vicons/ionicons5/EyeOff";

export default defineComponent({
  name: "TextInput",
  components: {CloseCircle, LabelInput, LabelError, Eye, EyeOff},
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
    type: {
      type: String,
      default: "text",
      required: false,
    },
    name: {
      required: false,
      type: String,
      default: null,
    },
    id: {
      type: String,
      required: false,
    },
    modelValue: {
      type: String as PropType<any>,
      default: "",
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
      type: String,
      required: false,
    },
    readonly: {
      default: false,
      type: Boolean,
      required: false,
    },
  },
  data: () => {
    return {
      typeModel: 'text',
      changePassType: false,
    }
  },
  created() {
    this.typeModel = this.type
  },
  methods: {
    updateInput(event: any) {
      this.$emit("update:modelValue", event.target.value);
    },
    clearInput() {
      this.$emit("onClear", true);
      this.$emit("update:modelValue", "");
    },
    onChangePass() {
      this.typeModel = 'text'
      this.changePassType = !this.changePassType
    },
    onChangePassOff() {
      this.typeModel = 'password'
      this.changePassType = !this.changePassType
    }
  },
});
</script>

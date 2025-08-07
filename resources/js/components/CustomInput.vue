<template>
    <div class="w-full">
        <label v-if="label != ''" :for="id" class="block mb-2 text-sm font-sm text-gray-500">{{ label }}</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <component :is="iconComponent" :class="['w-4 h-4 text-gray-500', errors ? 'text-red-600' : '']" />
            </div>
            <input
                :type="type"
                :id="id"
                :name="name"
                :placeholder="placeholder"
                :required="required"
                :value="modelValue"
                :autocomplete="autocomplete"
                @input="onInput"
                @focus="onFocus"
                :class="[
                'text-sm rounded-lg block w-full p-2.5 shadow-sm focus:ring focus:ring-blue-200 focus:outline-none',
                errors ? 'border-red-500 bg-red-100 text-red-600 placeholder-red-300 focus:ring-red-200': inputClass, !icon ? 'ps-2' : 'ps-10'
                ]"
                :disabled="disabled"
            />
        </div>
        <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors" :key="index">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
    import {defineProps, computed} from "vue";
    import * as TablerIcons from '@tabler/icons-vue';

    const props = withDefaults(defineProps<{
        inputClass?: String,
        label?: String,
        id: String,
        name: String,
        placeholder: String,
        type?: String,
        required?: Boolean,
        autocomplete?: String,
        modelValue: String,
        icon?: String,
        errors?: [],
        disabled?: Boolean,
    }>(), {
        inputClass: 'border text-gray-900 bg-white border-gray-100',
        type: 'text',
        autocomplete: 'on',
        disabled: false
    })
    const emits = defineEmits(['update:modelValue', 'input-change', 'input-focus']);
    const onInput = (event) => {
        const value = event.target.value;
        emits('update:modelValue', value);
        emits('input-change', value);
    };
    const onFocus = (event) => {
        emits('input-focus', event);
    };
    const iconComponent = computed(() => {
      return TablerIcons[props.icon] || null;
    })
</script>

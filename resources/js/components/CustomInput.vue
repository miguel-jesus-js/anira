<template>
    <div class="w-full">
        <label :for="id" class="block mb-2 text-sm font-sm text-gray-500" v-if="label != ''">{{ label }}</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <component :is="iconComponent" class="w-4 h-4 text-gray-500" />
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
                'text-sm rounded-lg block w-full ps-10 p-2.5 shadow-sm focus:ring focus:ring-blue-200 focus:outline-none',
                errors ? 'border-red-500 bg-red-100' : inputClass
                ]"
                :disabled="disabled"
            />
        </div>
        <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors" :key="index">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
    import {computed} from "vue";
    import * as TablerIcons from '@tabler/icons-vue';

    const props = defineProps({
        inputClass: {
            type: String,
            required: false,
            default: 'border text-gray-900 bg-white border-gray-100'
        },
        label: {
            type: String,
            required: false,
        },
        id: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        required: {
            type: String,
            required: false,
        },
        autocomplete: {
            type: String,
            required: false,
            default: 'on'
        },
        modelValue: {
            type: String,
            required: true
        },
        icon: {
            type: String,
            required: true,
        },
        errors: {
            type: Array,
            required: false,
        },
        disabled: {
            type: Boolean,
            required: false,
            default: false
        }
    });
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

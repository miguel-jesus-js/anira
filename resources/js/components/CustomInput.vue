<template>
    <div>
        <label :for="id" class="block mb-2 text-sm font-sm text-gray-500 dark:text-white" v-if="label != ''">{{ label }}</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <component :is="iconComponent" class="w-4 h-4 text-gray-500 dark:text-gray-400" />
            </div>
            <input
                :type="type"
                :id="id"
                :name="name"
                :placeholder="placeholder"
                :required="required"
                :value="modelValue"
                @input="onInput"
                :class="[
                'border text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5',
                'dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                errors ? 'border-red-500 bg-red-100' : 'bg-gray-50 border-gray-300'
                ]"
            />
        </div>
        <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors" :key="index">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
    import {computed} from "vue";
    import * as TablerIcons from '@tabler/icons-vue';

    const props = defineProps({
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
            required: true,
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
        }
    });
    const emits = defineEmits(['update:modelValue', 'input-change']);
    const onInput = (event) => {
        const value = event.target.value;
        emits('update:modelValue', value);
        emits('input-change', value);
    };
    const iconComponent = computed(() => {
      return TablerIcons[props.icon] || null;
    })
</script>

<template>
    <div>
        <label :for="id" class="block mb-2 text-sm font-sm text-gray-500">{{ label }}</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <component :is="iconComponent" class="w-4 h-4 text-gray-500" />
            </div>
            <select
                :id="id"
                :name="name"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value.toString())"
                :class="selectClass"
                :disabled="disabled"
                class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5">
                <option value="0" disabled selected>Selecciona una opción</option>
                <option v-for="option in options" :key="option.id" :value="option.id">{{ option[value_name] }}</option>
            </select>
        </div>
        <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors" :key="index">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
import {computed, PropType} from "vue";
import * as TablerIcons from "@tabler/icons-vue";
import {TypeEmployee} from "../types/TypeEmployees/TypeEmployee";

const props = defineProps({
    selectClass: {
        type: String,
        required: false,
        default: 'border text-gray-900 bg-gray-50 border-gray-300'
    },
    label: {
        type: String,
        required: true,
    },
    id: {
        type: String,
        required: true,
    },
    name: {
        type: String,
        required: true,
    },
    modelValue: {
        type: [String, Number],
        required: true,
    },
    icon: {
        type: String,
        required: true,
    },
    options: {
        type: Array as PropType<TypeEmployee[]>,
        required: true,
    },
    value_name:{
        type: String,
        required: true
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
})
const iconComponent = computed(() => {
    return TablerIcons[props.icon] || null;
})
</script>

<style scoped>

</style>

<template>
    <div>
        <label v-if="label != ''" :for="id" class="block mb-2 text-sm font-sm text-gray-500">{{ label }}</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <component :is="iconComponent" class="w-4 h-4 text-gray-500" />
            </div>
            <select
                :id="id"
                :name="name"
                :value="modelValue"
                @input="$emit('update:modelValue', $event.target.value.toString())"
                @change="handleSelect"
                :disabled="disabled"
                :class="['text-sm rounded-lg block w-full p-2.5 shadow-sm focus:ring focus:ring-blue-200 focus:outline-none', errors?.length > 0 ? 'border-red-500 bg-red-100' : selectClass, !icon ? 'ps-2' : 'ps-10']">
                <option value="" disabled>Elige</option>
                <option v-for="option in options" :key="option.id" :value="option.id">{{ option[value_name] }}</option>
            </select>
        </div>
        <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors" :key="index">{{ error }}</p>
    </div>
</template>

<script setup lang="ts">
    import {computed, defineProps} from "vue";
    import * as TablerIcons from "@tabler/icons-vue";
    import {OptionSelect} from "../types/General/OptionSelect";

    const props = withDefaults(defineProps<{
        selectClass?: String,
        label?: String,
        id: String,
        name: String,
        modelValue: String,
        icon?: String,
        options: OptionSelect[],
        value_name: String,
        errors?: Array,
        disabled?: Boolean,
    }>(),{
        selectClass: 'border text-gray-900 bg-white border-gray-100',
    });

    const emit = defineEmits(['update:modelValue', 'onChangeSelect']);

    const handleSelect = (event: Event) => {
        const target = event.target as HTMLSelectElement;
        const value = target.value;
        emit('onChangeSelect', parseInt(value));
    };

    const iconComponent = computed(() => {
        return TablerIcons[props.icon] || null;
    })


</script>

<style scoped>

</style>

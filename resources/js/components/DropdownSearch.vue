<template>
    <div ref="dropdownRef">
        <CustomInput :input-class="!disabled ? inputClasses.editing : inputClasses.default" icon="IconUserSearch" v-model="searchQuery" :placeholder="placeholder" autocomplete="off" name="name" :id="id" :label="label" @input-focus="toggleDropdown" :disabled="disabled"></CustomInput>
        <ul
            v-if="isOpen"
            class="absolute w-auto mt-2 bg-white border border-gray-300 rounded-lg shadow-lg max-h-48 overflow-auto z-10">
            <li
                v-for="option in filteredOptions"
                :key="option.id"
                @click="selectOption(option)"
                class="px-4 py-2 cursor-pointer hover:bg-blue-100">
                <small>{{ option.label }}</small>
            </li>
            <li v-if="filteredOptions.length === 0" class="px-4 py-2 text-gray-500">
                No hay resultados
            </li>
        </ul>
    </div>
</template>

<script setup lang="ts">
    import { ref, computed, onMounted, onUnmounted } from "vue";
    import {OptionSelect} from "../types/General/OptionSelect";
    import CustomInput from "./CustomInput.vue";
    import {inputClasses} from "../src/styles/uiClasses";

    const props = withDefaults(defineProps<{
        id: string,
        name: string,
        label: string,
        options: OptionSelect[],
        placeholder?: string
        defaultValue?: string,
        disabled?: boolean
    }>(),{
        disabled: false
    });

    const emit = defineEmits<{
        (event: "select", value: Option): void;
    }>();

    const searchQuery = ref("");
    const isOpen = ref(false);
    const selectedOption = ref<OptionSelect | null>(null);

    const dropdownRef = ref<HTMLElement | null>(null);

    const filteredOptions = computed(() => {
        return props.options.filter(option =>
            option.label.toLowerCase().includes(searchQuery.value.toLowerCase())
        )
    });

    const selectOption = (option: OptionSelect) => {
        selectedOption.value = option;
        emit("select", option);
        isOpen.value = false;
        searchQuery.value = option.label;
    };

    const assignDefaultValue = () => {
        if(props.defaultValue != null || typeof(props.defaultValue) !== 'undefined'){
            searchQuery.value = props.defaultValue;
        }
    }
    const toggleDropdown = () => {
        isOpen.value = !isOpen.value;
    };

    const handleClickOutside = (event: MouseEvent) => {
        if (dropdownRef.value && !dropdownRef.value.contains(event.target as Node)) {
            isOpen.value = false;
        }
    };

    onMounted(() => {
        document.addEventListener("click", handleClickOutside);
        assignDefaultValue();
    });

    onUnmounted(() => {
        document.removeEventListener("click", handleClickOutside);
    });
</script>

<style>

</style>

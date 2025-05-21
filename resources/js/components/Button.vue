<template>
    <div class="relative group h-10 flex">
        <button
            @click="handleClick"
            :class="buttonClass"
            :type="type"
            class="flex items-center justify-center px-5 py-2 text-sm duration-200 gap-x-2">
            <TablerIcon v-if="icon != ''" size="20" :icon="icon"></TablerIcon>
            <span v-if="label">{{ label }}</span>
        </button>
        <div v-if="textTooltip" class="fixed transform -translate-x-1/4 mt-10 hidden group-hover:flex bg-black text-white text-xs rounded py-0.5 px-2 whitespace-nowrap z-10">
            {{ textTooltip }}
        </div>
    </div>
</template>

<script setup lang="ts">
    import {defineProps} from "vue";
    import TablerIcon from "../components/TablerIcon.vue";

    const props = withDefaults(defineProps<{
        buttonClass: String
        onClick?: () => void,
        icon?: String
        label?: String
        type?: String,
        textTooltip?: String
    }>(), {
        type: 'button'
    });
    const handleClick = () => {
        props.onClick();
    };
</script>

<style scoped>

</style>

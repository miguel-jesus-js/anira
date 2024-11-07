<template>
    <button
        @click="handleClick"
        :class="buttonClass"
        class="flex items-center justify-center w-1/2 px-5 py-2 text-sm transition-colors duration-200 gap-x-2 sm:w-auto dark:hover:bg-gray-800 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700">
        <TablerIcon v-if="icon != ''" size="20" :icon="icon"></TablerIcon>
        <span v-if="label != ''">{{ label }}</span>
    </button>
</template>

<script setup lang="ts">
    import TablerIcon from "@/components/TablerIcon.vue";

    const props = defineProps({
       buttonClass: {
           type: String,
           default: ''
       },
        onClick: {
           type: Function,
            default: () => {}
        },
        icon: {
           type: String,
            default: ''
        },
        label: {
           type: String,
            default: ''
        }

    });
    const handleClick = () => {
        props.onClick();
    };
</script>

<style scoped>

</style>

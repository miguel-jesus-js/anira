<template>
    <button
        @click="handleClick"
        :class="buttonClass"
        :type="type"
        class="flex items-center justify-center px-5 py-2 text-sm duration-200 gap-x-2">
        <TablerIcon v-if="icon != ''" size="20" :icon="icon"></TablerIcon>
        <span v-if="label != ''">{{ label }}</span>
    </button>
</template>

<script setup lang="ts">
    import TablerIcon from "../components/TablerIcon.vue";

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
        },
        type: {
           type: String,
            default: 'button',
        },

    });
    const handleClick = () => {
        props.onClick();
    };
</script>

<style scoped>

</style>

<template>
    <div>
        <div
            v-if="isDrawerOpen"
            class="fixed top-0 right-0 z-40 h-screen p-4 overflow-y-auto bg-white max-w-100 border transition-all duration-500 ease-in-out"
            :class="isDrawerOpen ? 'transform translate-x-0 opacity-100' : 'transform translate-x-full opacity-0 pointer-events-none'"
            tabindex="-1"
            aria-labelledby="drawer-label">
            <h5 id="drawer-label" class="inline-flex items-center mb-4 text-black">
                {{ title}}
            </h5>
            <Button
                :on-click="closeModal"
                icon="IconX"
                button-class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 absolute top-2.5 right-2.5 flex items-center justify-center"
            ></Button>
            <div>
                <slot></slot>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">

    import TablerIcon from "./TablerIcon.vue";
    import Button from "./Button.vue";

    const props = defineProps({
        isDrawerOpen: {
            type: Boolean,
            required: true,
        },
        title: {
            value: String,
            required: true,
        },
    });

    const emits = defineEmits(['close']);
    const closeModal = () => {
        emits('close');
    };
</script>

<style scoped>

</style>

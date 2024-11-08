<template>
    <div v-if="isModalOpen" class="relative z-10" aria-labelledby="modal-title" role="dialog" aria-modal="true" id="modal">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>

        <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
            <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                <div class="relative transform overflow-hidden rounded-lg bg-white text-left shadow-xl transition-all sm:my-8 sm:w-full" :class="width">
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            {{ title }}
                        </h3>
                        <Button
                            :on-click="closeModal"
                            icon="IconX"
                            button-class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"></Button>
                    </div>
                    <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                      <slot></slot>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import Button from "@/components/Button.vue";

    defineProps({
        isModalOpen: {
            type: Boolean,
            required: true,
        },
        title: {
            type: String,
            required: true,
        },
        width: {
            type: String,
            default: 'sm:max-w-5xl',
        },
    });
    const emit = defineEmits(['close']);
    const closeModal = () => {
        emit('close');
    };
</script>

<style scoped>

</style>

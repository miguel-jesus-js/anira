<template>
    <div class="title-header">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="font-medium text-2xl text-gray-800">{{ title }}</h2>
                    <span class="px-3 py-1 text-xs text-[#E9F5F3] bg-[#6DBCB6] rounded-full">{{ totalRecords + ' ' + title }}</span>
                </div>
            </div>

            <div class="flex items-center mt-4 gap-x-3">
                <slot name="section1"></slot>
            </div>
        </div>
        <div class="mt-6 md:flex md:items-center md:justify-between">
            <div class="block md:inline-flex overflow-hidden bg-[#A97E59] rounded-lg rtl:flex-row-reverse">
                <slot name="section2"></slot>
            </div>

            <div class="relative flex items-center mt-4 md:mt-0">
                <slot name="section3"></slot>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    const props = defineProps({
        totalRecords: {
            type: Number,
            required: true
        },
        title: {
            type: String,
            required: true
        }

    })
</script>

<style scoped>

</style>

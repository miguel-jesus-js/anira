<template>
    <div class="title-header bg-white p-4 header-rounded">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center gap-x-3">
                    <h2 class="font-medium text-2xl text-gray-800">{{ title }}</h2>
                    <span class="px-3 py-1 text-xs text-[#E9F5F3] bg-[#6DBCB6] rounded-full">{{ totalRecords + ' ' + title }}</span>
                </div>
            </div>

            <div class="flex items-center mt-4 gap-x-3">
                <Button :on-click="openModal" buttonClass="rounded-lg bg-red-400 text-[#F2E9E0]" icon="IconPlus" :label="addTextButton"></Button>
            </div>
        </div>
        <div class="mt-6 md:flex md:items-center md:justify-between">
            <div class="block md:inline-flex gap-x-3 overflow-hidden">
                <Button :on-click="openModalExport" icon="IconFileUpload" button-class="bg-gray-100 rounded text-gray-600 hover:bg-gray-300" text-tooltip="Importar"></Button>
                <Button :on-click="openModalExport" icon="IconCloudDownload" button-class="bg-gray-100 rounded text-gray-600 hover:bg-gray-300" text-tooltip="Exportar"></Button>
                <Button v-if="openModalFilters" :on-click="openModalFilters" icon="IconFilter" button-class="bg-gray-100 rounded text-gray-600 hover:bg-gray-300" text-tooltip="Filtros"></Button>
                <Button :on-click="reload" icon="IconRefresh" button-class="bg-gray-100 rounded text-gray-600 hover:bg-gray-300" text-tooltip="Recargar"></Button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import {defineProps} from "vue";
    import Button from "../Button.vue";

    const props = defineProps<{
        totalRecords: Number,
        title: String
        addTextButton: String,
        openModal: () => void,
        openModalExport: () => void,
        reload: () => void,
        openModalFilters?: () => void,
    }>();
</script>

<style scoped>
    .header-rounded{
        border-radius: 6px 6px 0 0;
    }
</style>

<template>
    <div class="mt-4 overflow-x-auto">
        <div class="inline-block min-w-full align-middle">
            <div class="overflow-x-auto border border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-400">
                        <tr>
                            <th v-for="column in columns" :key="column.key" scope="col" class="px-5 py-3.5 text-sm font-normal text-left rtl:text-right text-white">
                                {{ column.label }}
                            </th>
                            <th class="px-5 py-3.5 text-sm font-normal text-left rtl:text-right text-white">Acciones</th>
                        </tr>
                    </thead>
                    <tbody v-if="isFetch">
                        <tr>
                            <td :colspan="columns.length + 1" class="p-5">
                                <LoaderTable></LoaderTable>
                            </td>
                        </tr>
                    </tbody>
                    <tbody class="bg-white divide-y divide-gray-200" v-if="data.length > 0 && !isFetch">
                        <tr v-for="(row, index) in data" :key="index" class="hover:bg-gray-100 odd:bg-gray-100 even:bg-white">
                            <template v-for="column in columns" :key="column.key">
                                <td v-if="column.rowRenderer">
                                    <component :is="column.rowRenderer" :status="formatValue(row, column)"></component>
                                </td>
                                <td v-else class="px-4 py-1 text-sm whitespace-nowrap text-left">
                                    <p class="text-gray-600">
                                        {{ formatValue(row, column) }}
                                    </p>
                                </td>
                            </template>
                            <th>
                                <div class="flex">
                                    <Button @click="redirect(urlView, row.id)" icon="IconEye" button-class="px-1 text-gray-500"></Button>
                                    <Button @click="redirect(urlEdit, row.id)" icon="IconPencil" button-class="px-1 text-gray-500"></Button>
                                    <Button  @click="redirect(urlView, row.id)" icon="IconTrashX" button-class="px-1 text-gray-500"></Button>
                                </div>
                            </th>
                        </tr>
                    </tbody>
                    <tbody v-if="data.length < 1 && !isFetch">
                    <tr>
                        <td :colspan="8" class="p-5 text-center">
                            Sin datos
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-6 sm:flex sm:items-center sm:justify-between" v-if="data.length > 0">
        <div class="text-sm text-gray-500">
            Pagína <span class="font-medium text-gray-700">{{ response.current_page }} de {{ response.last_page }}</span>
        </div>

        <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
            <button
                :disabled="response.current_page == 1"
                @click="handleClick(response.prev_page_url)"
                class="flex items-center justify-center w-1/2 px-2 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border-l border-t border-b sm:w-auto gap-x-2 hover:bg-gray-100">
                <TablerIcon size="20" icon="IconChevronLeft"></TablerIcon>
            </button>
            <button
                :disabled="response.current_page === page"
                v-for="page in visiblePages"
                :key="page"
                @click="handleClick(`/api/users?page=${page}`)"
                :class="['relative inline-flex items-center px-4 py-2 text-sm font-semibold border-t border-b focus:z-20 focus:outline-offset-0', response.current_page === page ? 'bg-blue-400 text-white hover:bg-blue-600' : 'bg-white text-gray-900 hover:bg-gray-50']">
                {{ page }}
            </button>
            <button
                :disabled="response.next_page_url == null"
                @click="handleClick(response.next_page_url)"
                class="flex items-center justify-center w-1/2 px-2 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border-r border-t border-b sm:w-auto gap-x-2 hover:bg-gray-100">
                <TablerIcon size="20" icon="IconChevronRight"></TablerIcon>
            </button>
        </nav>
    </div>
</template>

<script setup lang="ts">
    import LoaderTable from "../../components/Loader/LoaderTable.vue";
    import {computed, PropType} from "vue";
    import {Column} from "../../types/TableModule/Column";
    import {Row} from "../../types/TableModule/Row";
    import {StatusEmployeeEnum} from "../../types/Employees/StatusEmployeeEnum";
    import Button from "../../components/Button.vue";
    import TablerIcon from "../../components/TablerIcon.vue";
    import router from '../../router';
    import {Redirect} from "../../composables/Redirect";

    const props = defineProps({
        columns: {
            type: Array as PropType<Column[]>,
            required: true
        },
        isFetch: {
            type: Boolean,
            required: true,
        },
        data: {
            type: Array as PropType<Row[]>,
            required: true
        },
        rowRenderer: {
            type: Function as PropType<(row: Column) => JSX.Element>, // Acepta una función de renderizado
            default: null,
        },
        response: {
            type: Object as PropType<Response>,
            default: () => ({}),
        },
        onClick: {
            type: Function,
            default: () => {},
        },
        urlView: {
            type: String,
            required: true
        },
        urlEdit: {
            type: String,
            required: true
        }
    });
    const getNestedValue = (obj: Record<string, any>, path: string): any => {
        return path.split('.').reduce((acc, part) => acc && acc[part], obj);
    };
    const formatValue = (row: Row, column: Column): any => {
        const value = getNestedValue(row, column.key);
        if (column.enum) {
            return column.enum[value as keyof typeof StatusEmployeeEnum] || value;
        }
        return value;
    };
    const visiblePages = computed(() => {
        const totalPages = props.response?.last_page || 0;
        const currentPage = props.response?.current_page || 1;

        const startPage = Math.max(1, currentPage - 2);
        const endPage = Math.min(totalPages, startPage + 4);

        const pages: number[] = [];
        for (let i = startPage; i <= endPage; i++) {
            if (i <= totalPages) pages.push(i);
        }

        if (pages.length < 5 && totalPages > 5) {
            const start = Math.max(1, totalPages - 4);
            for (let i = start; i <= totalPages; i++) {
                pages.push(i);
            }
        }
        return pages;
    });
    const handleClick = () => {
        props.onClick();
    };
    const redirect = (url: string, id: number) => {
        Redirect(url, id);
    }
</script>

<style scoped>

</style>

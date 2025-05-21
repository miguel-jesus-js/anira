<template>
    <div class="mt-4">
        <div class="flex justify-end">
            <CustomSelect
                value_name="label"
                :options="rowNumbers"
                icon="IconListNumbers"
                :model-value="localSelected"
                name="row_number"
                id="row_number"
                label="Filas"
                select-class="bg-white"
                @onChangeSelect="emitChange"
            ></CustomSelect>
        </div>
        <div class="overflow-x-auto bg-white rounded-lg">
            <table class="min-w-full divide-y divide-gray-200 table-auto border">
                <thead class="bg-gray-100">
                    <tr>
                        <th v-for="column in columns" :key="column.key" scope="col" class="px-5 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">
                            {{ column.label }}
                        </th>
                        <th class="px-5 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500">ACCIONES</th>
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
                    <tr v-for="(row, index) in data" :key="index" class="hover:bg-gray-100 bg-white">
                        <td v-for="column in columns" :key="column.key" class="text-left px-2">
                            <slot
                            :name="column.alias ?? column.key"
                            :row="row"
                           >
                                <small>{{ getNestedValue(row, column.key) ?? '-' }}</small>
                            </slot>
                        </td>
                        <th>
                            <div class="flex">
                                <Button icon="IconEye" button-class="px-1 text-blue-600" :on-click="() => handleRedirect(urlView, row.id)" text-tooltip="Detalles"></Button>
                                <Button icon="IconTrashX" button-class="px-1 text-red-600" :on-click="() => onDeleteClick(urlDelete, row.id)" text-tooltip="Eliminar"></Button>
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
        <div class="mt-6 sm:flex sm:items-center sm:justify-between p-4" v-if="data.length > 0">
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
                    :class="['relative inline-flex items-center px-4 py-2 text-sm font-semibold border-t border-b focus:z-20 focus:outline-offset-0', response.current_page === page ? 'bg-[#A97E59] text-white hover:bg-blue-600' : 'bg-white text-gray-900 hover:bg-gray-50']">
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
    </div>
</template>

<script setup lang="ts">
    import {computed, defineProps, ref} from "vue";
    import LoaderTable from "../../components/Loader/LoaderTable.vue";
    import {Column} from "../../types/TableModule/Column";
    import {Row} from "../../types/TableModule/Row";
    import Button from "../../components/Button.vue";
    import TablerIcon from "../../components/TablerIcon.vue";

    import {useRedirect} from "../../composables/Redirect";
    import {confirmDelete, defaultError, showAlert} from "../../composables/SweetAlert";
    import {apiDelete} from "../../src/services/api";
    import CustomSelect from "../CustomSelect.vue";
    import {OptionSelect} from "../../types/General/OptionSelect";

    const rowNumbers: OptionSelect[] = [
        {id:10, label: 10},
        {id:20, label: 30},
        {id:40, label: 40},
        {id:50, label: 50},
    ]
    const props = withDefaults(defineProps<{
        columns: Column[]
        isFetch: boolean
        data: Row[],
        rowNumber: Number,
        response?: Response
        onClick?: () => void
        urlView: string
        urlDelete: string,
        handleSelect?: () => void,
    }>(), {
        rowNumber: 10
    });
    function getNestedValue(obj: any, path: string): any {
        return path.split('.').reduce((o, key) => o?.[key], obj)
    }
    const emit = defineEmits(['onOptionChange']);
    const localSelected = ref(props.rowNumber);
    const emitChange = (value: number) => {
        emit('onOptionChange', value);
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
    const redirect = useRedirect();
    const handleRedirect = (url, id) => {
        redirect(url, id);
    };
    const handleDelete = async (url: string, id: number) => {
        try {
            const res = await apiDelete(url + id);
            showAlert(res.type, res.title, res.message);
            props.onClick();
        } catch (error) {
            if(error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
        }
    };
    const onDeleteClick = (url: string, id: number) => {
        confirmDelete(url, id, handleDelete);
    };
</script>

<style scoped>

</style>

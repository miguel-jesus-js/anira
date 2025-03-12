<template>
    <div class="">
        <ol class="inline-flex bg-white rounded-lg shadow-lg p-4">
            <li class="inline-flex items-center m-1">
                <TablerIcon size="20" icon="IconSmartHome"></TablerIcon>
                <a class="flex items-center text-sm text-gray-500 mx-1" href="#">
                    Home
                </a>
                <TablerIcon size="22" icon="IconChevronRight"></TablerIcon>
            </li>
            <li class="inline-flex items-center m-1">
                <TablerIcon size="20" icon="IconUser"></TablerIcon>
                <a class="flex items-center text-sm text-gray-500 mx-1" href="#">
                    Empleados
                </a>
                <TablerIcon size="22" icon="IconChevronRight"></TablerIcon>
            </li>
            <li class="inline-flex items-center m-1 text-blue-600">
                <TablerIcon size="20" icon="IconUserEdit"></TablerIcon>
                <a class="flex items-center text-sm mx-1" href="#">
                    Detalle empleado
                </a>
            </li>
        </ol>
    </div>

    <div class="bg-white relative rounded-lg mt-10">
        <div v-if="isLoader" class="absolute inset-0 flex justify-center items-center z-50 bg-gray-100 bg-opacity-50 rounded-lg">
            <LoaderFetch></LoaderFetch>
        </div>
        <div class="grid sm:grid-cols-[100%] md:grid-cols-[30%_70%]" v-if="!isFetchTypeEmployee && Object.keys(typeEmployee).length != 0">
            <div class="border-r">
                <div
                    :class="[selectedTab === index ? 'bg-[#F5F9FD]' : 'bg-white']"
                    v-for="(tab, index) in tabs"
                    :key="index">
                    <Button
                        :class="['py-3 text-sm font-medium focus:outline-none', selectedTab === index ? 'font-semibold text-black' : 'text-gray-600']"
                        @click="selectedTab = index"
                        :label="tab.label"
                        :icon="tab.icon">
                    </Button>
                </div>
                <div class="mx-4 mt-4" v-show="!isEditing">
                    <Button button-class="border w-full bg-blue-600 text-white rounded-lg mb-3" @click="isEditing = !isEditing" icon="IconPencil" label="Editar" type="button"></Button>
                </div>
                <div class="grid grid-cols-2 gap-2 mx-4 mt-6" v-show="isEditing">
                    <Button button-class="border bg-white text-red-600 rounded-lg mb-3 hover:bg-red-600 hover:text-white" :on-click="fetchTypeEmployees" icon="IconX" label="Cancelar" type="button"></Button>
                    <Button button-class="border bg-white text-blue-600 rounded-lg mb-3 hover:bg-blue-600 hover:text-white" :on-click="fetchUpdateTypeEmployees" icon="IconCheck" label="Guardar" type="button"></Button>
                </div>
            </div>
            <div class="overflow-auto">
                <div v-show="selectedTab === 0" class="mt-4 px-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">
                        <CustomInput
                            placeholder="Nombre(s)"
                            name="first_name"
                            id="first_name"
                            label="Nombre(s)"
                            required="true"
                            v-model="typeEmployee.type_employee"
                            icon="IconUser"
                            :input-class="isEditing ? 'border text-gray-900 bg-gray-50 border-gray-300' : 'bg-[#F5F9FD] text-gray-500'"
                            :disabled="!isEditing"
                        >
                        </CustomInput>
                    </div>

                </div>
            </div>
        </div>
        <div class="grid grid-cols-[30%_70%]" v-else>
            <div class="grid grid-cols-1 border-r">
                <div>
                    <div role="status" class="w-full border-gray-200 rounded animate-pulse p-6 dark:border-gray-700">
                        <div class="mb-4 h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                        <div class="mb-4 h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                        <div class="mb-4 h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                        <div class="mb-4 h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                    </div>
                </div>
                <div class="mb-3 flex align-center items-center w-full px-4">
                    <div role="status" class="flex items-center justify-center w-full py-10 h-full object-cover bg-gray-300 rounded-lg animate-pulse dark:bg-gray-700">
                        <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                            <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM9 13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2Zm4 .382a1 1 0 0 1-1.447.894L10 13v-2l1.553-1.276a1 1 0 0 1 1.447.894v2.764Z"/>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div class="mt-4 px-10">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">

                    <div class="mb-3">
                        <dt class="text-sm text-gray-900">
                            <div role="status" class="w-1/2 mt-2 border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-3 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dt>
                        <dd class="mt-2">
                            <div role="status" class="w-full border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-sm text-gray-900">
                            <div role="status" class="w-1/2 mt-2 border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-3 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dt>
                        <dd class="mt-2">
                            <div role="status" class="w-full border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-sm text-gray-900">
                            <div role="status" class="w-1/2 mt-2 border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-3 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dt>
                        <dd class="mt-2">
                            <div role="status" class="w-full border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-sm text-gray-900">
                            <div role="status" class="w-1/2 mt-2 border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-3 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dt>
                        <dd class="mt-2">
                            <div role="status" class="w-full border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-sm text-gray-900">
                            <div role="status" class="w-1/2 mt-2 border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-3 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dt>
                        <dd class="mt-2">
                            <div role="status" class="w-full border-gray-200 rounded animate-pulse dark:border-gray-700">
                                <div class="h-8 bg-gray-200 rounded dark:bg-gray-700"></div>
                            </div>
                        </dd>
                    </div>
                    <br>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import {onMounted, ref} from "vue";
    import Button from "../../components/Button.vue";
    import {useRoute} from "vue-router";
    import CustomInput from "../CustomInput.vue";
    import {TypeEmployee} from "../../types/TypeEmployees/TypeEmployee";
    import LoaderFetch from '../Loader/LoaderFetch.vue';
    import {defaultError, showAlert} from "../../composables/SweetAlert";
    import TablerIcon from "../TablerIcon.vue";
    import {apiGet, apiPut} from "../../src/services/api";

    const tabs = [
        {label: 'Datos', icon: 'IconNotes'},
    ];
    const selectedTab = ref(0);
    const route = useRoute();
    const typeEmployee = ref<TypeEmployee>({});
    const isFetchTypeEmployee = ref(false);
    const isLoader = ref(false);
    const isEditing = ref(false);

    const fetchTypeEmployees = async () => {
        isFetchTypeEmployee.value = true;
        try {
            const payload = {paginate: false};
            const res = await apiGet(`type-employees/${route.params.id}`, payload);
            typeEmployee.value = res.data[0];
            isFetchTypeEmployee.value = false;
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isFetchTypeEmployee.value = false;
        }
    };
    const fetchUpdateTypeEmployees = async () => {
        try {
            isLoader.value = true;
            const res = await apiPut(`type-employees/${route.params.id}`, typeEmployee.value);
            isLoader.value = false;
            isEditing.value = false
            showAlert(res.type, res.title, res.message);
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isLoader.value = false;
            isEditing.value = false
        }
    }
    onMounted(() => {
        fetchTypeEmployees();
    })
</script>

<style scoped>


</style>

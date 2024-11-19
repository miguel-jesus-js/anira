<template>
    <div class="bg-white mx-10 my-5 rounded">
        <div class="relative w-full" v-if="!isFetchEmployees && Object.keys(employee).length != 0">
            <!-- Contenedor de las imágenes -->
            <div class="relative w-full h-[400px]">
                <!-- Imagen de fondo -->
                <img
                    src="https://images.squarespace-cdn.com/content/v1/5d530c602cb2ef000173d953/1716253082507-KECLUUYXBYUZYV99OE33/0W5A3364.JPG?format=1500w"
                    alt="Imagen de fondo"
                    class="w-full h-full object-cover"
                />
                <!-- Imagen superpuesta -->
                <div class="absolute bottom-0 left-10 transform translate-y-1/2">
                    <img
                        src="https://img.freepik.com/fotos-premium/chef-preparando-comida-cocina-restaurante_777271-3987.jpg"
                        alt="Imagen superpuesta"
                        class=" w-32 h-32 rounded-full border-4 border-white shadow-lg"
                    />
                </div>
            </div>
            <div class="flex mt-20 px-4">
                <Button
                    v-for="(tab, index) in tabs"
                    :key="index"
                    :class="['py-2 text-sm font-medium focus:outline-none', selectedTab === index ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600']"
                    @click="selectedTab = index"
                    :label="tab.label"
                    :icon="tab.icon"
                >
                </Button>
            </div>
            <div v-show="selectedTab === 0" class="mt-4 px-10 pb-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">
                    <div class="mb-3">
                        <dt class="text-md text-gray-900">Nombre(s)</dt>
                        <dd class="mt-2 text-xs text-gray-500">{{ employee.people.first_name }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-md text-gray-900">Apellido(s)</dt>
                        <dd class="mt-2 text-xs text-gray-500">{{ employee.people.last_name }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-md text-gray-900">Teléfono</dt>
                        <dd class="mt-2 text-xs text-gray-500">{{ employee.people.country_code + ' ' + employee.people.phone_number }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-md text-gray-900">Tipo de empleado</dt>
                        <dd class="mt-2 text-xs text-gray-500">{{ employee.type_employee.type }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-md text-gray-900">DNI</dt>
                        <dd class="mt-2 text-xs text-gray-500">{{ employee.people.dni }}</dd>
                    </div>
                </div>
            </div>
            <div v-show="selectedTab === 1" class="mt-4 px-10 pb-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">
                    <div class="mb-3">
                        <dt class="text-md text-gray-900">Correo</dt>
                        <dd class="mt-2 text-xs text-gray-500">{{ employee.people.email }}</dd>
                    </div>
                    <div class="mb-3">
                        <dt class="text-md text-gray-900">Nombre de usuario</dt>
                        <dd class="mt-2 text-xs text-gray-500">{{ employee.people.user.user_name }}</dd>
                    </div>
                </div>
            </div>
        </div >

        <div class="relative w-full" v-else>
            <!-- Contenedor de las imágenes -->
            <div class="relative w-full h-[400px]">
                <div role="status" class="flex items-center justify-center w-full h-full object-cover bg-gray-300 rounded-lg animate-pulse dark:bg-gray-700">
                    <svg class="w-10 h-10 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 16 20">
                        <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.98 2.98 0 0 0 .13 5H5Z"/>
                        <path d="M14.066 0H7v5a2 2 0 0 1-2 2H0v11a1.97 1.97 0 0 0 1.934 2h12.132A1.97 1.97 0 0 0 16 18V2a1.97 1.97 0 0 0-1.934-2ZM9 13a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2Zm4 .382a1 1 0 0 1-1.447.894L10 13v-2l1.553-1.276a1 1 0 0 1 1.447.894v2.764Z"/>
                    </svg>
                    <span class="sr-only">Loading...</span>
                </div>

                <!-- Imagen superpuesta -->
                <div class="absolute bottom-0 left-10 transform translate-y-1/2">
                    <div role="status" class="max-w-sm p-4 rounded-full animate-pulse md:p-6 dark:border-gray-700">
                        <div class="flex items-center mt-4">
                            <svg class="w-32 h-32 me-3 text-gray-200 dark:text-gray-700" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm0 5a3 3 0 1 1 0 6 3 3 0 0 1 0-6Zm0 13a8.949 8.949 0 0 1-4.951-1.488A3.987 3.987 0 0 1 9 13h2a3.987 3.987 0 0 1 3.951 3.512A8.949 8.949 0 0 1 10 18Z"/>
                            </svg>
                        </div>
                        <span class="sr-only">Loading...</span>
                    </div>
                </div>
            </div>
            <div role="status" class="flex mt-20 px-4 w-full border-gray-200 rounded animate-pulse md:p-6 dark:border-gray-700">
                <div class="w-48 h-2 bg-gray-200 mx-2 rounded-full dark:bg-gray-700"></div>
                <div class="w-48 h-2 bg-gray-200 mx-2 rounded-full dark:bg-gray-700"></div>
                <div class="w-48 h-2 bg-gray-200 mx-2 rounded-full dark:bg-gray-700"></div>
                <div class="w-48 h-2 bg-gray-200 mx-2 rounded-full dark:bg-gray-700"></div>
            </div>
        </div>

    </div>
</template>

<script setup lang="ts">
import {onMounted, ref} from "vue";
    import Button from "@/components/Button.vue";
    import router from "@/router";
    import {useRoute} from "vue-router";
    import axios from "axios";
    import {Response} from "@/types/Response";
    import {Employee} from "@/types/Employees/Employee";

    const tabs = [
        {label: 'Datos personales', icon: 'IconNotes'},
        {label: 'Datos de acceso', icon: 'IconKey'},
        {label: 'Direcciónes', icon: 'IconMapPin'},
        {label: 'Permisos', icon: 'IconLock'}
    ];
    const selectedTab = ref(0);
    const route = useRoute();
    const employee = ref<Employee>({});
    const isFetchEmployees = ref(false);

    const fetchEmployees = async (pageUrl: string = '/api/employees/' + route.params.id) => {
        employee.value = {};
        isFetchEmployees.value = true;
        try {
            const res = await axios.get<Response<Employee>>(pageUrl);
            employee.value = res.data.data;
            isFetchEmployees.value = false;
        } catch (error) {
            isFetchEmployees.value = false;
            console.error('Error fetching users:', error);
        }
    };

    onMounted(() => {
        fetchEmployees();
    })
</script>

<style scoped>

</style>

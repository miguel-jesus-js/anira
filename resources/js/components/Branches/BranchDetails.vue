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
        <div class="grid sm:grid-cols-[100%] md:grid-cols-[30%_70%]" v-if="!isFetchBranch && Object.keys(branch).length != 0">
            <div class="border-r">
                <div
                    :class="[selectedTab === index ? 'bg-[#F5F9FD]' : 'bg-white']"
                    v-for="(tab, index) in tabs"
                    :key="index"
                >
                    <Button
                        :class="['py-3 text-sm font-medium focus:outline-none', selectedTab === index ? 'font-semibold text-black' : 'text-gray-600']"
                        @click="selectedTab = index"
                        :label="tab.label"
                        :icon="tab.icon"
                    >
                    </Button>
                </div>
                <div class="mx-4" v-show="!isEditing">
                    <Button button-class="border w-full bg-blue-600 text-white rounded-lg mb-3" @click="isEditing = !isEditing" icon="IconPencil" label="Editar" type="button"></Button>
                </div>
                <div class="grid grid-cols-2 gap-2 mx-4 mt-6" v-show="isEditing">
                    <Button button-class="border bg-white text-red-600 rounded-lg mb-3 hover:bg-red-600 hover:text-white" :on-click="fetchBranch" icon="IconX" label="Cancelar" type="button"></Button>
                    <Button button-class="border bg-white text-blue-600 rounded-lg mb-3 hover:bg-blue-600 hover:text-white" :on-click="fetchUpdateBranch" icon="IconCheck" label="Guardar" type="button"></Button>
                </div>
            </div>
            <div class="overflow-auto">
                <div v-show="selectedTab === 0" class="my-4 px-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">
                        <DropdownSearch
                            id="employee_id"
                            name="employee_id"
                            label="Encargado"
                            :options="options"
                            placeholder="Buscar empleado..."
                            @select="handleSelect"
                            :disabled="!isEditing"
                            :default-value="`${branch.employee?.people?.first_name ?? ''} ${branch.employee?.people?.last_name ?? ''}`.trim()"
                        />
                        <CustomInput
                            placeholder="Sucursal 1"
                            name="name"
                            id="name"
                            label="Nombre"
                            required=""
                            v-model="branch.name"
                            icon="IconBuilding"
                            :input-class="isEditing ? inputClasses.editing : inputClasses.default"
                            :disabled="!isEditing"
                            :errors="errors['name']">
                        </CustomInput>
                        <CustomInput
                            placeholder="sucrusal1@gmail.com"
                            name="email"
                            id="email"
                            label="Correo"
                            type="email"
                            required=""
                            v-model="branch.email"
                            icon="IconMail"
                            :input-class="isEditing ? inputClasses.editing : inputClasses.default"
                            :disabled="!isEditing"
                            :errors="errors['email']">
                        </CustomInput>
                        <div class="block">
                            <label  class="block mb-2 text-sm font-sm text-gray-500">Téléfono</label>
                            <vue3-phone-input
                                v-model="phoneNumber"
                                placeholder="9191513420"
                                required
                                class="h-10"
                                :class="isEditing ? inputClasses.editing : inputClasses.default"/>
                            <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors['phone_number']" :key="index">{{ error }}</p>
                        </div>
                        <br>
                    </div>
                </div>
                <div v-show="selectedTab === 1" class="mt-4 px-10">
                    <div class="grid grid-cols-1 gap-4 h-screen overflow-y-auto">
                        <ViewAddressComponent :add-item-addresses="addItemAddresses" :item-addresses="itemAddresses" :edit-address="editAddress" :remove-item-addresses="onDeleteClick"></ViewAddressComponent>
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
    <Modal :title="isEditingAddress ? 'EDITAR DIRECCIÓN' : 'AGREGAR DIRECCIÓN'" width="sm:max-w-2xl" :is-modal-open="isModalAddressOpen" @close="closeModalAddress" >
        <AddressComponent :submit="() => handleAddress(branch.id)" :address="address" :errors-address="errorsAddress"></AddressComponent>
    </Modal>
</template>

<script setup lang="ts">
    import {onMounted, ref} from "vue";
    import Vue3PhoneInput from 'vue3-phone-input';
    import Button from "../../components/Button.vue";
    import {useRoute} from "vue-router";
    import {Branch} from "../../types/Branches/Branch";
    import CustomInput from "../CustomInput.vue";
    import LoaderFetch from '../Loader/LoaderFetch.vue';
    import {confirmDelete, defaultError, defaultErrorUser, showAlert} from "../../composables/SweetAlert";
    import Modal from "../Modal.vue";
    import {Address} from "../../types/Addresses/Address";
    import TablerIcon from "../TablerIcon.vue";
    import {apiDelete, apiGet, apiPost, apiPut} from "../../src/services/api";
    import ViewAddressComponent from "../Addresses/ViewAddressComponent.vue";
    import AddressComponent from "../Addresses/AddressComponent.vue";
    import {useAutocomplete, useAddressValidation} from "../../composables/AddressValidation";
    import DropdownSearch from "../DropdownSearch.vue";
    import {Employee} from "../../types/Employees/Employee";
    import {OptionSelect} from "../../types/General/OptionSelect";
    import {inputClasses} from "../../src/styles/uiClasses";
    import {Model} from "../../src/enum/Model"

    const employees = ref<Employee[]>([]);

    const tabs = [
        {label: 'Información', icon: 'IconBuilding'},
        {label: 'Dirección', icon: 'IconMapPin'},
    ];
    const options = ref<OptionSelect[]>([]);
    const errors = ref({});
    const selectedTab = ref(0);
    const route = useRoute();
    const branch = ref<Branch>({});
    const itemAddresses = ref<Address[]>([]);
    const phoneNumber = ref({});
    const isFetchBranch = ref(false);
    const isLoader = ref(false);
    const isEditing = ref(false);
    const isEditingAddress = ref(false);
    const isModalAddressOpen = ref(false);
    const address = ref<Address>({
        address: '',
        street: '',
        neighborhood: '',
        interior_number: '',
        outer_number: '',
        city: '',
        state: '',
        locality: '',
        cp: '0',
        latitude: '',
        longitude: ''
    });
    const { initAutocomplete } = useAutocomplete();
    const { fetchCreateAddress, errorsAddress } = useAddressValidation();

    const fetchBranch = async () => {
        branch.value = {};
        isFetchBranch.value = true;
        isEditing.value = false;
        try {
            const res = await apiGet(`branches/${route.params.id}`);
            branch.value = res.data[0];
            phoneNumber.value.number = '+' + branch.value.country_code + branch.value.phone_number;
            phoneNumber.value.nationalNumber = branch.value.phone_number;
            itemAddresses.value = branch.value.address ? [branch.value.address] : [];
            isFetchBranch.value = false;
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isFetchBranch.value = false;
        }
    };
    const fetchEmployees = async () => {
        try {
            const res = await apiGet<Employee>('employees');
            employees.value = res.data.employees;
            employees.value.forEach(item => {
                options.value.push({id: item.id, label: item.people.first_name + ' ' + item.people.last_name});
            });
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
        }
    };

    const fetchUpdateBranch = async () => {
        try {
            isLoader.value = true;
            const res = await apiPut(`branches/${route.params.id}`, branch.value);
            isLoader.value = false;
            isEditing.value = false
            showAlert(res.type, res.title, res.message);
        } catch (error) {
            if(error.response && error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }if(error.response && error.response.data.errors){
                defaultErrorUser();
                errors.value = error.response.data.errors;
            }else{
                defaultError();
            }
            isLoader.value = false;
        }
    }
    const handleSelect = (option: OptionSelect) => {
        branch.value.employee_id = option.id;
    };
    const handleAddress = (branchId: number) => {
        fetchCreateAddress(isEditingAddress.value, Model.Branch, branchId, address, closeModalAddress, fetchBranch);
    }
    const editAddress = (dataAddress: Address) => {
        isEditingAddress.value = true;
        address.value = dataAddress;
        addItemAddresses();
    }

    const handleDelete = async (url: string, id: number) => {
        try {
            isLoader.value = true;
            const res = await apiDelete(url + id);
            showAlert(res.type, res.title, res.message);
            isLoader.value = false;
            await fetchBranch();
        } catch (error) {
            if(error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else{
                defaultError();
            }
            isLoader.value = false;
        }
    };
    const onDeleteClick = (id: number) => {
        confirmDelete(`address/${route.params.id}/`, id, handleDelete);
    };
    const addItemAddresses = () => {
        if(itemAddresses.value.length > 0 && !isEditingAddress.value){
            isEditingAddress.value = false;
            showAlert('warning', 'Advertencia', 'La sucursal solo puede tener una dirección');
        }else{
            isModalAddressOpen.value = true;
            initAutocomplete(address);
        }
    }
    const closeModalAddress = () => {
        isModalAddressOpen.value = false;
        isEditingAddress.value = false;
    };
    onMounted(() => {
        fetchBranch();
        fetchEmployees();
    })
</script>

<style scoped>


</style>

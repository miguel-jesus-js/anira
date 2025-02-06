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
        <div class="grid sm:grid-cols-[100%] md:grid-cols-[30%_70%]" v-if="!isFetchCustomer && Object.keys(customer).length != 0">
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
                <div class="mb-3 flex align-center items-center w-full px-4">
                    <img
                        src="https://images.squarespace-cdn.com/content/v1/5d530c602cb2ef000173d953/1716253082507-KECLUUYXBYUZYV99OE33/0W5A3364.JPG?format=1500w"
                        alt="Imagen de fondo"
                        class="object-cover rounded-xl"
                    />
                </div>
                <div class="mx-4" v-show="!isEditing">
                    <Button button-class="border w-full bg-blue-600 text-white rounded-lg mb-3" @click="isEditing = !isEditing" icon="IconPencil" label="Editar" type="button"></Button>
                </div>
                <div class="grid grid-cols-2 gap-2 mx-4 mt-6" v-show="isEditing">
                    <Button button-class="border bg-white text-red-600 rounded-lg mb-3 hover:bg-red-600 hover:text-white" :on-click="fetchCustomer" icon="IconX" label="Cancelar" type="button"></Button>
                    <Button button-class="border bg-white text-blue-600 rounded-lg mb-3 hover:bg-blue-600 hover:text-white" :on-click="fetchUpdateCustomer" icon="IconCheck" label="Guardar" type="button"></Button>
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
                            v-model="customer.people.first_name"
                            icon="IconUser"
                            :input-class="isEditing ? 'border text-gray-900 bg-gray-50 border-gray-300' : 'bg-[#F5F9FD] text-gray-500'"
                            :disabled="!isEditing"
                        >
                        </CustomInput>
                        <CustomInput
                            placeholder="Apellido(s)"
                            name="last_name"
                            id="last_name"
                            label="Apellido(s)"
                            required="true"
                            v-model="customer.people.last_name"
                            icon="IconUser"
                            :input-class="isEditing ? 'border text-gray-900 bg-gray-50 border-gray-300' : 'bg-[#F5F9FD] text-gray-500'"
                            :disabled="!isEditing"
                        >
                        </CustomInput>
                        <div class="block">
                            <label class="block mb-2 text-sm font-sm text-gray-500">Teléfono</label>
                            <vue3-phone-input
                                v-model="phoneNumber"
                                placeholder="Número de teléfono"
                                required
                                class="text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 h-10"
                                :class="isEditing ? 'bg-gray-50 border border-gray-300 text-gray-900' : 'bg-[#F5F9FD] text-gray-500'"/>
                        </div>
                        <CustomSelect
                            icon="IconId"
                            name="type_customer_id"
                            id="type_customer_is"
                            label="Tipo de cliente"
                            v-model="customer.type_customer_id"
                            :options="typeCustomers"
                            :select-class="isEditing ? 'border text-gray-900 bg-gray-50 border-gray-300' : 'bg-[#F5F9FD] text-gray-500'"
                            :disabled="!isEditing"
                        >
                        </CustomSelect>
                        <CustomInput
                            placeholder="DNI"
                            name="dni"
                            id="dni"
                            label="DNI"
                            required="true"
                            v-model="customer.people.dni"
                            icon="IconId"
                            :input-class="isEditing ? 'border text-gray-900 bg-gray-50 border-gray-300' : 'bg-[#F5F9FD] text-gray-500'"
                            :disabled="!isEditing"
                        >
                        </CustomInput>
                        <br>
                    </div>

                </div>
                <div v-show="selectedTab === 1" class="mt-4 px-10">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">
                        <CustomInput
                            placeholder="Correo"
                            name="email"
                            id="email"
                            label="Correo"
                            type="email"
                            required=""
                            v-model="customer.people.email"
                            icon="IconMail"
                            :input-class="isEditing ? 'border text-gray-900 bg-gray-50 border-gray-300' : 'bg-[#F5F9FD] text-gray-500'"
                            :disabled="!isEditing"
                        >
                        </CustomInput>
                        <CustomInput
                            placeholder="Nombre de usuario"
                            name="user_name"
                            id="user_name"
                            label="Nombre de usuario"
                            required="true"
                            v-model="customer.people.user.user_name"
                            icon="IconUser"
                            :input-class="isEditing ? 'border text-gray-900 bg-gray-50 border-gray-300' : 'bg-[#F5F9FD] text-gray-500'"
                            :disabled="!isEditing"
                        >
                        </CustomInput>
                    </div>
                </div>
                <div v-show="selectedTab === 2" class="mt-4 px-10">
                    <div class="grid grid-cols-1 gap-4 h-screen overflow-y-auto">
                        <div class="flex justify-end">
                            <Button button-class="border bg-green-600 text-white rounded-lg mb-3" :on-click="addItemAddresses" icon="IconPlus" label="Agregar dirección" type="button"></Button>
                        </div>
                        <div v-for="(item, index) in customer.people.addresses" :key="index" class="border rounded my-2">
                            <div>
                                <div class="flex justify-between items-center p-4">
                                    <div class="w-full">
                                        <div class="mb-3">
                                            <dt class="text-sm text-gray-900">Dirección completa</dt>
                                            <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.address }}</dd>
                                        </div>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4">
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Calle</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.street }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Colonia</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.neighborhood }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">N° interior</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.interior_number }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">N° Exterior</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.outer_number }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Ciudad</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.city }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Estado</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.state }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Localidad</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.locality }}</dd>
                                            </div>
                                            <div class="mb-3">
                                                <dt class="text-sm text-gray-900">Código postal</dt>
                                                <dd class="mt-2 text-xs text-gray-500 bg-[#F5F9FD] px-3 py-2 rounded">{{ item.cp }}</dd>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid grid-cols-2 gap-2 mx-4 mt-6">
                                    <Button button-class="border bg-red-600 text-white rounded-lg mb-3" :on-click="() => onDeleteClick(item.id)" icon="IconX" label="Eliminar" type="button"></Button>
                                    <Button button-class="border bg-blue-600 text-white rounded-lg mb-3" :on-click="() => editAddress(item)" icon="IconCheck" label="Editar" type="button"></Button>
                                </div>
                            </div>
                            <div class="flex">

                            </div>
                        </div>
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
    <Modal title="AGREGAR DIRECCIÓN" width="sm:max-w-2xl" :is-modal-open="isModalAddressOpen" @close="closeModalAddress" >
        <form class="max-w-5xl" @submit.prevent="isEditingAddress ? fetchUpdateAddress(address.id) : fetchCreateAddress(customer.people_id)">
            <CustomInput
                ref="autocompleteInput"
                label="Dirección"
                id="address"
                icon="IconLocationFilled"
                v-model="address.address"
                required="true"
                placeholder="Dirección"
                name="address"
                :errors="errorsAddress['address']">
            </CustomInput>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4 my-3">
                <CustomInput
                    label="Calle"
                    id=""
                    icon="IconSmartHome"
                    v-model="address.street"
                    required="true"
                    placeholder="Anira 18"
                    name="street"
                    :errors="errorsAddress['street']">
                </CustomInput>
                <CustomInput
                    label="Colonia"
                    id=""
                    icon="IconSmartHome"
                    v-model="address.neighborhood"
                    required="true"
                    placeholder="Albania alta"
                    name="neighborhood"
                    :errors="errorsAddress['neighborhood']">
                </CustomInput>
                <CustomInput
                    label="N° interior"
                    id=""
                    icon="IconNumber"
                    v-model="address.interior_number"
                    placeholder="S/N"
                    name="interior_number"
                    :errors="errorsAddress['interior_number']">
                </CustomInput>
                <CustomInput
                    label="N° exterior"
                    id=""
                    icon="IconNumber"
                    v-model="address.outer_number"
                    placeholder="S/N"
                    name="outer_number"
                    :errors="errorsAddress['outer_number']">
                </CustomInput>
                <CustomInput
                    label="Ciudad"
                    id=""
                    icon="IconBuildingSkyscraper"
                    v-model="address.city"
                    required="true"
                    placeholder="Mexico"
                    name="city"
                    :errors="errorsAddress['city']">
                </CustomInput>
                <CustomInput
                    label="Estado"
                    id=""
                    icon="IconBuildings"
                    v-model="address.state"
                    required="true"
                    placeholder="Chiapas"
                    name="state"
                    :errors="errorsAddress['state']">
                </CustomInput>
                <CustomInput
                    label="Localidad"
                    id=""
                    icon="IconMap"
                    v-model="address.locality"
                    required="true"
                    placeholder="Tuxtla Gutierrez"
                    name="locality"
                    :errors="errorsAddress['locality']">
                </CustomInput>
                <CustomInput
                    label="CP"
                    id=""
                    icon="IconMapCode"
                    v-model="address.cp"
                    required="true"
                    placeholder="29950"
                    name="cp"
                    :errors="errorsAddress['cp']">
                </CustomInput>
            </div>
            <Button button-class="bg-green-500 rounded text-white" icon="IconPlus" :label="isEditingAddress ? 'Actualizar' : 'Guardar'" type="submit"></Button>
        </form>
    </Modal>

</template>

<script setup lang="ts">
import {nextTick, onMounted, ref} from "vue";
import Vue3PhoneInput from 'vue3-phone-input';
import Button from "../../components/Button.vue";
import {useRoute} from "vue-router";
import axios from "axios";
import {Customer} from "../../types/Customers/Customer";
import CustomInput from "../CustomInput.vue";
import CustomSelect from "../CustomSelect.vue";
import {TypeCustomer} from "../../types/TypeCustomers/TypeCustomer";
import LoaderFetch from '../Loader/LoaderFetch.vue';
import {confirmDelete, showAlert} from "../../composables/SweetAlert";
import Modal from "../Modal.vue";
import {Address} from "../../types/Addresses/Address";
import TablerIcon from "../TablerIcon.vue";
import {apiGet, apiPost, apiPut} from "../../src/services/api";

const typeCustomers = ref<TypeCustomer[]>([]);

const tabs = [
    {label: 'Datos personales', icon: 'IconNotes'},
    {label: 'Datos de acceso', icon: 'IconKey'},
    {label: 'Direcciónes', icon: 'IconMapPin'},
    {label: 'Permisos', icon: 'IconLock'}
];
const selectedTab = ref(0);
const route = useRoute();
const customer = ref<Customer>({});
const phoneNumber = ref({});
const isFetchCustomer = ref(false);
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
const errorsAddress = ref({});

const fetchCustomer = async () => {
    customer.value = {};
    isFetchCustomer.value = true;
    isEditing.value = false;
    try {
        const res = await apiGet(`customers/${route.params.id}`);
        customer.value = res.data;
        phoneNumber.value.number = '+' + customer.value.people.country_code + customer.value.people.phone_number;
        phoneNumber.value.nationalNumber = customer.value.people.phone_number
        isFetchCustomer.value = false;
    } catch (error) {
        isFetchCustomer.value = false;
        showAlert('error', 'Error externo', 'Ocurrió un error al procesar los datos');
    }
};
const fetchTypeCustomers = async () => {
    try {
        typeCustomers.value = await apiGet('type-customers');
    } catch (error) {
        showAlert('error', 'Error externo', 'Ocurrió un error al procesar los datos');
    }
};
const fetchUpdateCustomer = async () => {
    try {
        isLoader.value = true;
        const res = await apiPut(`customers/${route.params.id}`, customer.value);
        isLoader.value = false;
        isEditing.value = false
        showAlert(res.type, res.title, res.message);
    } catch (error) {
        console.error('Error fetching users:', error);
        isLoader.value = false;
        isEditing.value = false
    }
}
const fetchCreateAddress = async (peopleId: number) => {
    try {
        const res = await apiPost(`address/${peopleId}`, address.value);
        if(res.type === 'success'){
            showAlert(res.type, res.title, res.message);
            closeModalAddress();
            fetchCustomer()
        }else{
            showAlert(res.type, res.title, res.message);
        }
    } catch (error) {
        if(error.response && error.response.data.errors){
            showAlert('warning', 'Advertencia', 'Tienes errores en algunos campos');
            errorsAddress.value = error.response.data.errors;
        }
    }
}
const fetchUpdateAddress = async (addressId: number) => {
    try {
        const res = await putAddress(`address/${addressId}`, address.value);
        if(res.type === 'success'){
            showAlert(res.type, res.title, res.message);
            closeModalAddress();
            fetchCustomer()
        }else{
            showAlert(res.type, res.title, res.message);
        }
    } catch (error) {
        if(error.response && error.response.data.errors){
            showAlert('warning', 'Advertencia', 'Tienes errores en algunos campos');
            errorsAddress.value = error.response.data.errors;
        }
    }
}
const editAddress = (dataAddress: Address) => {
    isEditingAddress.value = true;
    address.value = dataAddress;
    addItemAddresses();
}

const handleDelete = async (url: string, id: number) => {
    try {
        isLoader.value = true;
        const res = await axios.delete(url + id );
        showAlert(res.data.type, res.data.title, res.data.message);
        isLoader.value = false;
        fetchCustomer();
    } catch (error) {
        isLoader.value = false;
    }
};
const onDeleteClick = (url: string, id: number) => {
    confirmDelete(url, id, handleDelete);
};
const addItemAddresses = () => {
    isModalAddressOpen.value = true;
    initAutocomplete();
}
const closeModalAddress = () => {
    isModalAddressOpen.value = false;
};
const initAutocomplete = async () => {
    await nextTick();
    const input = document.getElementById("address");

    if (!window.google || !window.google.maps) {
        console.error("Google Maps no cargado");
        return;
    }

    const autocomplete = new google.maps.places.Autocomplete(input, {
        types: ['address']
    });
    autocomplete.addListener("place_changed", () => {
        const place = autocomplete.getPlace();
        address.value.address = place.formatted_address;
        place.address_components.forEach(component => {
            const types = component.types;
            if (types.includes("route")) {
                address.value.street = component.long_name;
            }
            if (types.includes("sublocality_level_1")) {
                address.value.neighborhood = component.long_name;
            }
            if (types.includes("street_number")) {
                address.value.outer_number = component.long_name;
            }
            if (types.includes("subpremise")) {
                address.value.interior_number = component.long_name;
            }
            if (types.includes("country")) {
                address.value.city = component.long_name;
            }
            if (types.includes("administrative_area_level_1")) {
                address.value.state = component.long_name;
            }
            if (types.includes("locality")) {
                address.value.locality = component.long_name;
            }
            if (types.includes("postal_code")) {
                address.value.cp = component.long_name;
            }
        });
        address.value.latitude = place.geometry.location.lat();
        address.value.longitude = place.geometry.location.lng();
    });
};
onMounted(() => {
    fetchCustomer();
    fetchTypeCustomers();
})
</script>

<style scoped>


</style>

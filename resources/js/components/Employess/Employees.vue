<template>
  <!-- component -->
  <section class="mx-10 mt-5 bg-white p-4 rounded-md">
    <HeaderModule :total-records="response ? response.total : 0">
        <template #section1>
            <Button icon="IconCloudUpload" label="Importar" button-class="border rounded-lg"></Button>
            <Button :onClick="openModal" buttonClass="border rounded-lg bg-blue-500 text-white hover:bg-blue-600" icon="IconPlus" label="Agregar empleado"></Button>
        </template>
        <template #section2>
            <Button icon="IconCloudDownload" button-class="border-0" label="Exportar"></Button>
            <Button icon="IconFilterPlus" button-class="border-0" label="Filtros"></Button>
            <Button :onClick="fetchEmployees" button-class="border-0" icon="IconRefresh" label="Recargar"></Button>
        </template>
        <template #section3>
            <CustomInput icon="IconSearch" v-model="filters.email" @input-change="handleInputChange" required="false" placeholder="Buscar..."  name="search" id="search"></CustomInput>
        </template>
    </HeaderModule>
      <input ref="autocompleteInput">
    <TableModule :columns="columns" :is-fetch="isFetchEmployees" :data="employees" :response="response" :onClick="fetchEmployees" url-view="EmployeeDetails" url-edit="EmployeeDetails">

    </TableModule>
    <Modal title="AGREGAR EMPLEADO" :is-modal-open="isModalOpen" @close="closeModal">
        <form class="max-w-5xl" @submit.prevent="fetchCreateUser">
            <!-- Pestañas (Botones) -->
            <div class="flex border-b border-gray-300">
                <Button
                    v-for="(tab, index) in tabs"
                    :key="index"
                    :class="['py-2 px-4 text-sm font-medium focus:outline-none', selectedTab === index ? 'border-b-2 border-blue-500 text-blue-500' : 'text-gray-600']"
                    @click="selectedTab = index"
                    :label="tab.label"
                    :icon="tab.icon"
                >
                </Button>
            </div>

            <div class="mt-4">
                <div v-show="selectedTab === 0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4 ">
                        <CustomInput
                            placeholder="Nombre(s)"
                            name="first_name"
                            id="first_name"
                            label="Nombre(s)"
                            required="true"
                            v-model="employee.people.first_name"
                            icon="IconUser"
                            :errors="errors['people.first_name']"
                        >
                        </CustomInput>
                        <CustomInput
                            placeholder="Apellido(s)"
                            name="last_name"
                            id="last_name"
                            label="Apellido(s)"
                            required="true"
                            v-model="employee.people.last_name"
                            icon="IconUser"
                            :errors="errors['people.last_name']"
                        >
                        </CustomInput>
                        <vue3-phone-input
                            v-model="phone"
                            placeholder="Número de teléfono"
                            required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500"/>
                        <p class="pl-1 text-red-500 text-sm py-1" v-for="(error, index) in errors['people.phone_number']" :key="index">{{ error }}</p>
                        <CustomSelect
                            icon="IconId"
                            name="type_employee_id"
                            id="type_employee_id"
                            label="Tipo de empleado"
                            v-model="employee.type_employee_id"
                            :options="typeEmployees"
                            :errors="errors['type_employee_id'] ? errors['type_employee_id'] : []"
                        >
                        </CustomSelect>
                        <CustomInput
                            placeholder="DNI"
                            name="dni"
                            id="dni"
                            label="DNI"
                            required="true"
                            v-model="employee.people.dni"
                            icon="IconId"
                            :errors="errors['people.dni']"
                        >
                        </CustomInput>
                    </div>
                </div>
                <div v-show="selectedTab === 1">
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4 ">
                        <CustomInput
                            placeholder="Correo"
                            name="email"
                            id="email"
                            label="Correo"
                            type="email"
                            required=""
                            v-model="employee.people.email"
                            icon="IconMail"
                            :errors="errors['people.email']"
                        >
                        </CustomInput>
                        <CustomInput
                            placeholder="Nombre de usuario"
                            name="user_name"
                            id="user_name"
                            label="Nombre de usuario"
                            required="true"
                            v-model="employee.user.user_name"
                            icon="IconUser"
                            :errors="errors['user.user_name']"
                        >
                        </CustomInput>
                        <CustomInput
                            placeholder="Contraseña"
                            name="password"
                            id="password"
                            label="Contraseña"
                            type="password"
                            required="true"
                            v-model="employee.user.password"
                            icon="IconKey"
                            :errors="errors['user.password']"
                        >
                        </CustomInput>
                        <CustomInput
                            placeholder="Repetir contraseña"
                            name="password_repeat"
                            id="password_repeat"
                            label="Repetir contraseña"
                            type="password"
                            required="true"
                            v-model="employee.user.password_repeat"
                            icon="IconKey"
                            :errors="errors['user.password_repeat']"
                        >
                        </CustomInput>
                    </div>
                </div>
                <div v-show="selectedTab === 2">
                    <Button button-class="bg-green-500 text-white rounded-lg" :on-click="addItemAddresses" icon="IconPlus" label="Agregar dirección"></Button>
                    <div v-for="(item, index) in itemAddresses" :key="index" class="border rounded my-2 grid grid-cols-[90%_10%]">
                        <div>
                            <div @click="toggleAddress(index)" class="flex justify-between items-center p-4">
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
                        </div>
                        <div class="flex">
                            <Button button-class="bg-transparent text-red-700" :on-click="() => removeItemAddresses(index)" icon="IconTrashFilled"></Button>
                        </div>
                    </div>
                </div>
                <div v-show="selectedTab === 3">
                    <p>Contenido del Tab 8</p>
                </div>
            </div>
            <div class="flex justify-end">
                <Button v-if="selectedTab != 0" :on-click="previousTabs" class="mx-2 py-1 bg-gray-400 rounded-lg text-white" label="Anterior"></Button>
                <Button v-if="selectedTab + 1 < tabs.length" :on-click="nextTab" class="mx-2 py-1 bg-green-400 rounded-lg text-white" label="Siguiente"></Button>
                <Button v-if="selectedTab + 1 == tabs.length" :on-click="fetchCreateUser" icon="IconDeviceFloppy" class="mx-2 py-1 bg-blue-400 rounded-lg text-white" label="Registrar"></Button>
            </div>
        </form>
    </Modal>
    <Modal title="AGREGAR DIRECCIÓN" width="sm:max-w-2xl" :is-modal-open="isModalAddressOpen" @close="closeModalAddress" >
          <form class="max-w-5xl" @submit.prevent="addAddress">
              <CustomInput ref="autocompleteInput" label="Direccion" id="address" icon="IconLocationFilled" v-model="address.address" required="true" placeholder="Dirección" name="address"></CustomInput>
              <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 grid-rows-1 gap-4 my-3">
                  <CustomInput label="Calle" id="" icon="IconSmartHome" v-model="address.street" required="true" placeholder="Anira 18" name="street"></CustomInput>
                  <CustomInput label="Colonia" id="" icon="IconSmartHome" v-model="address.neighborhood" required="true" placeholder="Albania alta" name="neighborhood"></CustomInput>
                  <CustomInput label="N° interior" id="" icon="IconNumber" v-model="address.interior_number" placeholder="S/N" name="interior_number"></CustomInput>
                  <CustomInput label="N° exterior" id="" icon="IconNumber" v-model="address.outer_number" placeholder="S/N" name="outer_number"></CustomInput>
                  <CustomInput label="Ciudad" id="" icon="IconBuildingSkyscraper" v-model="address.city" required="true" placeholder="Mexico" name="city"></CustomInput>
                  <CustomInput label="Estado" id="" icon="IconBuildings" v-model="address.state" required="true" placeholder="Chiapas" name="state"></CustomInput>
                  <CustomInput label="Localidad" id="" icon="IconMap" v-model="address.locality" required="true" placeholder="Tuxtla Gutierrez" name="locality"></CustomInput>
                  <CustomInput label="CP" id="" icon="IconMapCode" v-model="address.cp" required="true" placeholder="29950" name="cp"></CustomInput>
              </div>
              <Button button-class="bg-green-500 rounded text-white" icon="IconPlus" label="Guardar" type="submit"></Button>
          </form>
      </Modal>

  </section>

</template>

<script setup lang="ts">
    import {onMounted, ref, markRaw, nextTick } from 'vue';
    import axios from 'axios';
    import {Employee, CreateEmployee} from '../../types/Employees/Employee';
    import {Response} from '../../types/Response';
    import {StatusEmployeeEnum} from "../../types/Employees/StatusEmployeeEnum";
    import CustomInput from '../CustomInput.vue'
    import CustomSelect from '../CustomSelect.vue';
    import Vue3PhoneInput from 'vue3-phone-input';
    import {TypeEmployee} from "../../types/TypeEmployees/TypeEmployee";
    import {showAlert} from "../../composables/SweetAlert";
    import HeaderModule from "../../components/Modules/HeaderModule.vue";
    import Button from "../../components/Button.vue";
    import TableModule from "../../components/Modules/TableModule.vue";
    import {Column} from "../../types/TableModule/Column";
    import SpanStatus from "../../components/Modules/SpanStatus.vue";
    import Modal from "../../components/Modal.vue";
    import TablerIcon from "../TablerIcon.vue";
    import {Address} from "../../types/Addresses/Address";

    const employees = ref<Employee>([]);
    const response = ref<Response<Employee> | null>(null);
    const isModalOpen = ref(false);
    const isModalAddressOpen = ref(false);
    const tabs = [
        {label: 'Datos personales', icon: 'IconNotes'},
        {label: 'Datos de acceso', icon: 'IconKey'},
        {label: 'Direcciónes', icon: 'IconMapPin'},
        {label: 'Permisos', icon: 'IconLock'}
    ];
    const selectedTab = ref(0);
    const typeEmployees = ref<TypeEmployee[]>([]);
    const phone = ref({country_code: '', phone_number: ''});
    const errors = ref({});
    const isFetchEmployees = ref(false);
    const employee = ref<CreateEmployee>({
        type_employee_id: '0',
        user: {
            user_name: '',
            password: '',
            password_repeat: '',
        },
        people: {
            first_name: '',
            last_name: '',
            email: '',
            dni: '0',
            country_code: '',
            phone_number: ''
        }
    });
    const columns = ref<Column>([
        {key: 'id', label: 'ID'},
        {key: 'people.first_name', label: 'NOMBRE(S)'},
        {key: 'people.last_name', label: 'APELLIDO(S)'},
        {key: 'people.email', label: 'CORREO'},
        {key: 'people.phone_number', label: 'TELÉFONO'},
        {key: 'type_employee.type', label: 'TIPO'},
        {key: 'status', label: 'ESTADO', enum: StatusEmployeeEnum, rowRenderer: markRaw(SpanStatus)},
    ]);
    const itemAddresses = ref<Address[]>([]);
    const filters = ref({
        email: '',
    });
    const autocompleteInput = ref(null);
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

    const fetchEmployees = async (pageUrl: string = '/api/employees') => {
        employees.value = [];
        isFetchEmployees.value = true;
        try {
            const res = await axios.get<Response<Employee>>(pageUrl,{
                params: {filters: filters.value}
            });
            employees.value = res.data.data.data;
            response.value = res.data.data;
            isFetchEmployees.value = false;
        } catch (error) {
            isFetchEmployees.value = false;
            console.error('Error fetching users:', error);
        }
    };
    const fetchTypeEmployees = async (pageUrl: string = '/api/type-employees') => {
        try {
            const res = await axios.get<Response<TypeEmployees>>(pageUrl);
            typeEmployees.value = res.data.data;
        } catch (error) {
            console.error('Error fetching type employees:', error);
        }
    };
    const fetchCreateUser = async () => {
        employee.value.people.country_code = phone.value.callingCode;
        employee.value.people.phone_number = phone.value.nationalNumber;
        try {
            const res = await axios.post('api/users', employee.value);
            if(res.data.type === 'success'){
                showAlert(res.data.type, res.data.title, res.data.message);
                fetchEmployees();
                closeModal();
            }else{
                showAlert(res.data.type, res.data.title, res.data.message);
            }
        } catch (error) {
            if(error.response && error.response.data.errors){
                showAlert('warning', 'Advertencia', 'Tienes errores en algunos campos');
                errors.value = error.response.data.errors;
            }
        }
    }
    const handleInputChange = () => {
        fetchEmployees();
    }
    const addItemAddresses = () => {
        isModalAddressOpen.value = true;
        initAutocomplete();
    }
    const removeItemAddresses = (index) => {
        itemAddresses.value.splice(index, 1);
    }
    const addAddress = () => {
        itemAddresses.value.push({ ...address.value });
        isModalAddressOpen.value = false;
        address.value = {
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
        };
    }
    const toggleAddress = (index) => {
        itemAddresses.value.forEach((item, i) => {
            if (i !== index) {
                item.isOpen = false;
            }
        });
        itemAddresses.value[index].isOpen = !itemAddresses.value[index].isOpen;
    };
    const nextTab = () => {
        selectedTab.value = selectedTab.value + 1;
    }
    const previousTabs = () => {
        selectedTab.value = selectedTab.value - 1;
    }
    const openModal = () => {
        isModalOpen.value = true;
        fetchTypeEmployees();
    };
    const closeModal = () => {
        isModalOpen.value = false;
    };
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
        });
    };
    onMounted(() => {
        fetchEmployees();
    })

</script>

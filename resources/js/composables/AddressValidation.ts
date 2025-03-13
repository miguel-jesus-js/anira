import {nextTick, ref} from 'vue';
import {apiPost, apiPut} from '../src/services/api'; // Asegúrate de importar correctamente tu API
import { showAlert, defaultErrorUser, defaultError } from './SweetAlert';
import {Address} from "../types/Addresses/Address"; // Si tienes una función de alertas

export function useAddressValidation() {
    const errorsAddress = ref([]);

    const fetchValidateAddress = async (address: Address, addAddress: () => void, closeModalAddress: () => void) => {
        try {
            const res = await apiPost('address-validate', address);
            if (res.type === 'success') {
                addAddress();
                showAlert(res.type, res.title, res.message);
                closeModalAddress();
            } else {
                showAlert(res.type, res.title, res.message);
            }
        } catch (error: any) {
            if (error.response?.data?.type) {
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }
            if (error.response?.data?.errors) {
                defaultErrorUser();
                errorsAddress.value = error.response.data.errors;
            } else {
                defaultError();
            }
        }
    };

    const fetchCreateAddress = async (isEditingAddress: Boolean, peopleId: number, address: Address, closeModalAddress: () => void, reloadModule: () => void) => {
        try {
            let response;
            if(isEditingAddress){
                response = await apiPut(`address/${address.value.id}`, address.value);
            }else{
                response = await apiPost(`address/${peopleId}`, address.value);
            }
            if(response.type === 'success'){
                showAlert(response.type, response.title, response.message);
                closeModalAddress();
                await reloadModule()
            }else{
                showAlert(response.type, response.title, response.message);
            }
        } catch (error) {
            if(error.response.data.type){
                showAlert(error.response.data.type, error.response.data.title, error.response.data.message);
            }else if(error.response && error.response.data.errors){
                defaultErrorUser();
                errorsAddress.value = error.response.data.errors;
            }else{
                defaultError();
            }
        }
    }

    return {
        fetchValidateAddress,
        fetchCreateAddress,
        errorsAddress,
    };
}

export function useAutocomplete() {
    const initAutocomplete = async (address: Address) => {
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
    return {
        initAutocomplete
    }
}

<template>
    <div>
        <form class="max-w-5xl" @submit.prevent="submit">
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
            <Button button-class="bg-green-500 rounded text-white" icon="IconPlus" label="Guardar" type="submit"></Button>
        </form>
    </div>
</template>

<script setup lang="ts">

    import Button from "../Button.vue";
    import CustomInput from "../CustomInput.vue";
    import Address from "./AddressComponent.vue";

    const props = defineProps<{
        submit: Function,
        address: Address,
        errorsAddress: Array
    }>();
</script>

<style scoped>

</style>


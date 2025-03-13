<template>
    <div>
        <Button button-class="bg-green-500 text-white rounded-lg" :on-click="addItemAddresses" icon="IconPlus" label="Agregar dirección"></Button>
        <div v-for="(item, index) in itemAddresses" :key="index" class="border rounded my-2 grid grid-cols-[85%_15%]">
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
            </div>
            <div class="flex">
                <Button button-class="bg-transparent text-blue-600" :on-click="() => editAddress(item)" icon="IconPencil"></Button>
                <Button button-class="bg-transparent text-red-600" :on-click="() => removeItemAddresses(item.id ?? index)" icon="IconTrashFilled"></Button>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
    import Button from "../Button.vue";
    import {Address} from "../../types/Addresses/Address";

    const props = defineProps<{
        addItemAddresses: Function,
        itemAddresses: Address[],
        editAddress: Function
        removeItemAddresses: Function
    }>();
</script>

<style scoped>

</style>

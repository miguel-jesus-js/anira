<template>
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        <div
            :class="[
                'fixed top-0 left-0 h-full bg-white text-white transition-transform duration-300 z-50',
                isSidebarOpen ? 'translate-x-0' : '-translate-x-full',
                'md:block md:w-64',
                'w-64'
              ]">
            <div class="flex items-center justify-between h-16 px-4">
                <div class="text-lg font-bold text-blue-500">Mi Logo</div>
                <Button icon="IconX" :on-click="toggleSidebar" class="text-gray-500"></Button>
            </div>
            <div class="">
                <div class="flex items-center justify-center mb-6">
                    <button class="bg-orange-500 px-5 py-1 font-semibold"><small>Business</small></button>
                    <button class="border px-5 py-1 text-gray-500 font-semibold"><small>Cliente</small></button>
                </div>
                <ul class="space-y-2">
                    <div v-for="(item, index) in accordions" :key="index">
                        <div @click="toggleAccordion(index)" class="flex justify-between items-center cursor-pointer p-4 hover:bg-blue-500">
                            <div class="flex">
                                <TablerIcon size="20" :icon="item.icon" class="text-gray-500 pr-3"></TablerIcon><span class="text-sm text-gray-500">{{ item.title }}</span>
                            </div>
                            <tabler-icon size="20" icon="IconChevronUp" class="text-gray-500  transition-transform duration-300" :class="{'rotate-180': item.isOpen}"></tabler-icon>
                        </div>
                        <div v-show="item.isOpen" class="p-4">
                            <p>{{ item.content }}</p>
                        </div>
                    </div>
                </ul>
            </div>
        </div>
        <div
            :class="[
              'flex-1 flex flex-col transition-all duration-300 ease-in-out',
              isSidebarOpen ? 'pl-64' : 'pl-0',
              'md:pl-0'
            ]"
             :style="{ marginLeft: isSidebarOpen ? '256px' : '0px' }">
            <div class="fixed top-0 left-0 right-0 bg-blue-600 text-white h-16 px-4 z-40 flex items-center justify-between">
                <Button icon="IconMenu2" :on-click="toggleSidebar"></Button>
            </div>
            <div class="py-16 overflow-y-auto">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>



<script lang="ts" setup>
    import Button from "@/components/Button.vue";
    import {ref} from "vue";
    import TablerIcon from "@/components/TablerIcon.vue";
    const isSidebarOpen = ref(true);
    const accordions = ref(
        [
            { title: 'Usuarios', icon: 'IconUsers', content: 'Este es el contenido del primer acordeón.', isOpen: false },
            { title: 'Ecommerce', icon: 'IconShoppingBag', content: 'Este es el contenido del segundo acordeón.', isOpen: false },
            { title: 'Inventario', icon: 'IconPresentationAnalytics', content: 'Este es el contenido del tercer acordeón.', isOpen: false },
        ]
    );

    const toggleAccordion = (index) => {
        accordions.value.forEach((accordion, i) => {
            if (i !== index) {
                accordion.isOpen = false;
            }
        });
        accordions.value[index].isOpen = !accordions.value[index].isOpen;
    };

    const toggleSidebar = () => {
        isSidebarOpen.value = !isSidebarOpen.value;
    }

</script>

<style scoped>
/* Estilos opcionales */
</style>

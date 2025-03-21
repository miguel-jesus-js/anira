<template>
    <div class="bg-[#fee8ed] p-10 w-full h-screen flex flex-col">
        <div class="bg-[#F3F7FB] flex flex-col h-full">
            <!-- Navbar fijo -->
            <nav class="bg-white flex-shrink-0">
                <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
                    <div class="relative flex h-16 items-center justify-between">
                        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                            <button type="button" class="relative inline-flex items-center justify-center rounded-md p-2 text-gray-400 hover:bg-gray-700 hover:text-white focus:ring-2 focus:ring-white focus:outline-hidden focus:ring-inset">
                                <span class="absolute -inset-0.5"></span>
                                <span class="sr-only">Open main menu</span>
                                <svg class="block size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </button>
                        </div>
                        <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                            <div class="flex shrink-0 items-center">
                                <img class="h-8 w-auto" src="https://tailwindcss.com/plus-assets/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                            </div>
                            <div class="hidden sm:ml-6 sm:block">
                                <div class="flex space-x-4">
                                    <a href="#" class="rounded-md bg-gray-900 px-3 py-2 text-sm font-medium text-white">Dashboard</a>
                                    <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-700 hover:text-white">Team</a>
                                    <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-700 hover:text-white">Projects</a>
                                    <a href="#" class="rounded-md px-3 py-2 text-sm font-medium text-gray-600 hover:bg-gray-700 hover:text-white">Calendar</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="flex flex-1 overflow-hidden">
                <!-- Sidebar fijo -->
                <div class="bg-white w-64 flex-shrink-0 overflow-y-auto">
                    <ul class="space-y-2 mt-10">
                        <div v-for="(item, index) in accordions" :key="index">
                            <div @click="toggleAccordion(index)" class="flex justify-between items-center cursor-pointer p-4 hover:bg-[#7F8691]">
                                <div class="flex">
                                    <TablerIcon size="20" :icon="item.icon" class="text-black pr-3"></TablerIcon>
                                    <span class="text-sm">{{ item.menu }}</span>
                                </div>
                                <tabler-icon size="20" icon="IconChevronUp" class="text-black transition-transform duration-300" :class="{'rotate-180': item.isOpen}"></tabler-icon>
                            </div>
                            <div v-show="item.isOpen" class="ml-10 text-black">
                                <ul v-for="(submenu, key) in item.submenu">
                                    <li class="inline-flex items-center m-1">
                                        <TablerIcon size="20" icon="IconUser"></TablerIcon>
                                        <router-link :to="{ name: submenu.link }">
                                            {{ submenu.title }}
                                        </router-link>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </ul>
                </div>

                <!-- Contenedor del router-view que hace scroll si es necesario -->
                <div class="flex-1 overflow-auto p-5">
                    <router-view></router-view>
                </div>
            </div>
        </div>
    </div>

</template>

<script lang="ts" setup>
    import Button from "../components/Button.vue";
    import {ref} from "vue";
    import TablerIcon from "../components/TablerIcon.vue";
    const isSidebarOpen = ref(true);
    const accordions = ref(
        [
            { menu: 'Usuarios', icon: 'IconUsers',
                submenu: [{title: 'Empleados', link: 'Employees', icon: ''}, {title: 'Clientes', link: 'Customers', icon: ''}],
                isOpen: false },
            { menu: 'Ecommerce', icon: 'IconShoppingBag', submenu: [], isOpen: false },
            { menu: 'Inventario', icon: 'IconPresentationAnalytics', submenu: [], isOpen: false },
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
    .radius-1{
        border-radius: 0 0 0 10px;
    }
    nav{
        border-radius: 10px 10px 0 0;
    }
</style>

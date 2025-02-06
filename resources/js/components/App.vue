<template>
    <div class="bg-[#E8A386] w-full h-screen p-10">
        <div class="grid grid-cols-[250px_auto]">
            <div class="bg-[#F2EAE0] radius-1">
                <div class="text-black text-2xl align-center text-center mt-10 rounded-full bg-[#E8A386] w-30 py-8 px-8">ANIRA</div>
                <ul class="space-y-2 mt-10">
                    <div v-for="(item, index) in accordions" :key="index">
                        <div @click="toggleAccordion(index)" class="flex justify-between items-center cursor-pointer p-4 hover:bg-[#7F8691]">
                            <div class="flex">
                                <TablerIcon size="20" :icon="item.icon" class="text-black pr-3"></TablerIcon><span class="text-sm">{{ item.menu }}</span>
                            </div>
                            <tabler-icon size="20" icon="IconChevronUp" class="text-black  transition-transform duration-300" :class="{'rotate-180': item.isOpen}"></tabler-icon>
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
            <div class="bg-gray-100 radius-2">
                <router-view></router-view>
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
        border-radius: 40px 0 0 40px;
    }
    .radius-2{
        border-radius: 0 40px 40px 0;
    }
</style>

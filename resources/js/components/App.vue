<template>
    <div class="h-screen flex flex-col">
        <!-- Navbar -->
        <header class="bg-gray-900 text-white fixed top-0 left-0 right-0 h-16 flex items-center px-4 z-50">
            <h1 class="text-xl font-semibold">Mi Aplicación</h1>
        </header>

        <div class="flex flex-1 pt-16">
            <aside
                :class="[
                  'bg-white text-gray-400 font-bold transition-all duration-300 relative h-full',
                  sidebarOpen ? 'w-64' : 'w-20'
                ]">
                <button @click="sidebarOpen = !sidebarOpen" class="p-4 text-gray-600 w-full text-center">
                    x
                </button>

                <nav class="mt-2 grid" :class="sidebarOpen ? 'grid grid-cols-2 p-3' : 'grid grid-cols-1 p-1'">
                    <div
                        v-for="(item, index) in menuItems"
                        :key="index"
                        class="relative group"
                        @mouseenter="handleHover(item.title)"
                        @mouseleave="handleLeave">
                        <router-link
                            class="h-20 m-1 flex flex-col items-center justify-center text-gray-500 rounded-lg hover:bg-orange-400 hover:text-white cursor-pointer bg-gray-50"
                            :class="sidebarOpen ? 'w-auto' : 'w-200 my-1 mx-0'"
                            :to="item.path">
                            <TablerIcon size="35" :icon="item.icon" />
                            <span class="text-xs mt-1 text-center">{{ item.title }}</span>
                        </router-link>

                        <transition name="fade">
                            <div
                                v-if="showDropdown === item.title"
                                class="absolute left-full top-2 ml-2 w-40 bg-gray-700 rounded shadow-lg p-2 z-50">
                                <a
                                    v-for="(sub, i) in item.subItems"
                                    :key="i"
                                    href="#"
                                    class="block text-sm text-gray-200 hover:text-white">
                                    {{ sub }}
                                </a>
                            </div>
                        </transition>
                    </div>
                </nav>
            </aside>
            <main class="flex-1 bg-gray-100 p-6 overflow-auto">
                <div class="relative group w-20 h-20 flex flex-col items-center justify-center bg-gray-100 rounded-lg cursor-pointer">
                    <span class="text-2xl">⚙️</span>

                    <div
                        class="absolute left-1/2 transform -translate-x-1/2 mt-12 hidden group-hover:block bg-black text-white text-xs rounded py-0.5 px-2 whitespace-nowrap z-10"
                    >
                        Configuración
                    </div>
                </div>
                <router-view></router-view>
            </main>
        </div>
    </div>
</template>

<script setup>
    import { ref } from 'vue'
    import TablerIcon from "./TablerIcon.vue";

    const sidebarOpen = ref(true)
    const showDropdown = ref(null)
    let hoverTimeout = null

    const menuItems = [
        { title: 'Usuarios', icon: 'IconUsersGroup', path: '#', subItems: ['Resumen', 'Gráficos'] },
        { title: 'Sucursales', icon: 'IconGitBranch', path: '/sucursales', subItems: null },
        { title: 'Tipo de clientes', icon: 'IconUserCog', path: '/tipo-de-clientes', subItems: null },
        { title: 'Tipo de empleados', icon: 'IconUserDollar', path: '/tipo-de-empleados', subItems: null },
        { title: 'Mesas', icon: 'IconTable', path: '#', subItems: null },
    ]

    function toggleDropdown(title) {
        showDropdown.value = showDropdown.value === title ? null : title
    }

    function handleHover(title) {
        clearTimeout(hoverTimeout)
        showDropdown.value = title
    }

    function handleLeave() {
        hoverTimeout = setTimeout(() => {
            showDropdown.value = null
        }, 200)
    }
</script>

<style scoped>

</style>

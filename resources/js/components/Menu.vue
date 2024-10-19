<template>
    <nav class="bg-blue-500 p-4">
        <ul class="flex space-x-4">
            <li><router-link to="/">Home</router-link></li>
            <li><router-link to="/employees">Usuarios</router-link></li>
        </ul>
    </nav>
</template>

<script lang="ts">
export default {
    name: 'MenuComponent',
};
</script>

<style scoped>
/* Estilos opcionales */
</style>

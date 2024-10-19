<template>
    <div>
        <h1>Employees List</h1>
        <ul v-if="users.length > 0">
            <li v-for="user in users" :key="user.id">
                {{ user.user_name }} - {{ user.dni }}
            </li>
        </ul>
        <p v-else>No products found.</p>
    </div>
</template>

<script lang="ts">
import {defineComponent, onMounted, ref} from 'vue';
import axios from 'axios';

interface User {
    id: number;
    user_name: string;
    email_verified_at: string | null;
    created_at: string | null;
    updated_at: string | null;
}

export default defineComponent({
    setup() {
        let users = ref<User[]>([]);

        const fetchUsers = async () => {
            try {
                let response = await axios.get('/api/users');
                users.value = response.data;
            } catch (error) {
                console.error('Error fetching products:', error);
            }
        };

        onMounted(() => {
            fetchUsers();
        });

        return {
            users,
        };
    },
});
</script>

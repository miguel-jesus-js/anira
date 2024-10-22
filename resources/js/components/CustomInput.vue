<template>
    <div>
        <label :for="id" class="block mb-2 text-sm font-sm text-gray-500 dark:text-white">{{ label }}</label>
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                <component :is="iconComponent" class="w-4 h-4 text-gray-500 dark:text-gray-400" />
            </div>
            <input
                :type="type"
                :id="id"
                :name="name"
                :placeholder="placeholder"
                required
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            />
        </div>
    </div>
</template>

<script lang="ts">
import * as TablerIcons from '@tabler/icons-vue';
export default {
    props: {
        label: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true,
        },
        name: {
            type: String,
            required: true,
        },
        placeholder: {
            type: String,
            required: true,
        },
        type: {
            type: String,
            default: 'text',
        },
        icon: {
            type: String,
            required: true,
        },
    },
    computed: {
        iconComponent() {
            return TablerIcons[this.icon] || null;
        }
    }
}
</script>

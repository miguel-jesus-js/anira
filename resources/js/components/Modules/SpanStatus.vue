
<template>
    <span class="bg-green-300 rounded-lg text-green-900 px-2  text-sm">{{ status }}</span>
</template>

<script setup lang="ts">
    const props = defineProps({
        status: {
            type: String,
            required: true,
        },
    });
</script>

<style scoped>

</style>

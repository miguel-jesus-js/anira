<template>
    <div>
        <component :is="iconComponent" :size="size" stroke="1.5"/>
    </div>
</template>

<script setup lang="ts">
    import { computed } from 'vue';
    import * as TablerIcons from '@tabler/icons-vue';

    const props = defineProps({
       icon: {
           type: String,
           required: true
       },
        size: {
           type: String,
            required: true
        },
    });
    const iconComponent = computed(() => {
        return TablerIcons[props.icon] || null;
    })
</script>

<style scoped>

</style>

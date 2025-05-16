
<template>
    <span class="flex rounded-lg px-2 py-1 font-bold uppercase"
      :class="statusClass">
        <span class="relative flex size-3 mt-1">
            <span class="absolute inline-flex h-full w-full animate-ping rounded-full opacity-75"
            :class="statusAnimateClass"></span>
       </span>
        <small class="ml-3">{{ status }}</small>
    </span>

</template>

<script setup lang="ts">
import {computed, defineProps} from "vue";
import {StatusBase} from "../../src/enum/StatusBase";

    const props = defineProps<{
        status: string
    }>();

    const statusClass = computed(() => {
        switch (props.status){
            case StatusBase[0]: return 'bg-gray-100 opacity-75 text-gray-600';
            case StatusBase[1]: return 'bg-[#6DBCB6] text-white';
        }
    });
    const statusAnimateClass = computed(() => {
    switch (props.status){
        case StatusBase[0]: return 'bg-gray-600';
        case StatusBase[1]: return 'bg-white';
    }
});
</script>

<style scoped>

</style>

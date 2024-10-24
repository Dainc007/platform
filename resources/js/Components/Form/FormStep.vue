<script setup>
import { defineProps } from 'vue';

const props = defineProps({
    title: {
        type: String,
        required: true
    },
    description: {
        type: String,
        required: true
    }
});
</script>
<template>
    <li class="flex items-center text-blue-600 dark:text-blue-500 space-x-2.5 rtl:space-x-reverse">
<span class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
1
</span>
        <span>
<h3 class="font-medium leading-tight">{{ title }}</h3>
<p class="text-sm">{{ description }}</p>
</span>
    </li>
</template>

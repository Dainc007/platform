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
    },
    id: {
        required: true,
        default: 1
    }
});
</script>
<template>
    <li class="flex items-center text-blue-600 dark:text-blue-500 space-x-2.5 rtl:space-x-reverse">

<span class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500 bg-green-700">
                <svg class="w-3.5 h-3.5 text-green-500 dark:text-green-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5"/>
            </svg>
{{ id }}
</span>
        <span>
<h3 class="font-medium leading-tight">{{ title }}</h3>
<p class="text-sm">{{ description }}</p>
</span>
    </li>
</template>

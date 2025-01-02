<script setup>
import {  Link } from '@inertiajs/vue3';

defineProps({
    links: Object,
    perPage: Number,
    total:Number,
    currentPage:Number
});
</script>

<template>
    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between p-4 dark:bg-gray-800" aria-label="Table navigation">
        <span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
            {{$t('pagination.showing')}}
            <span class="font-semibold text-gray-900 dark:text-white">
                {{(currentPage - 1) * perPage + 1 }}  - {{currentPage * perPage}}</span> {{$t('pagination.of')}}
            <span class="font-semibold text-gray-900 dark:text-white">
                {{ total}} {{$t('pagination.records')}}
            </span>
        </span>
        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            <Link
                v-for="(link, index) in links"
                :key="index"
                :href="link.url"
                :class="[
'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 border border-gray-300 dark:border-gray-700 dark:text-gray-400',
link.active ? 'bg-blue-500 text-white dark:bg-blue-700 dark:text-white' : 'bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white'
]"
                v-html="$t(link.label)"
                preserve-scroll
            />
        </ul>
    </nav>
</template>

<script setup>
import {  Link } from '@inertiajs/vue3';

defineProps({
    links: Object
});
</script>

<template>
    <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
         aria-label="Table navigation">

        <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
            <Link
                v-for=" (link, index) in links"
                :key="index"
                :href="link.url"
                :class="[
                    'flex items-center justify-center px-3 h-8 leading-tight text-gray-500 border border-gray-300 dark:border-gray-700 dark:text-gray-400',
                    link.active ? 'bg-white text-white' : 'bg-white hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700 dark:hover:text-white'
                ]"
                v-html="link.label"
                preserve-scroll
            />
        </ul>
    </nav>
</template>

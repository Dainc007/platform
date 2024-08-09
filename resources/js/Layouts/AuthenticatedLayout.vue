<template>
    <div>
        <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            <AuthenticatedTopNav/>
            <!-- Page Heading -->
            <header class="bg-white dark:bg-gray-800 shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>
            <FlashMessage></FlashMessage>
            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>

<script setup>
import AuthenticatedTopNav from "@/Layouts/AuthenticatedTopNav.vue";
import FlashMessage from "@/Components/FlashMessage.vue";

import { onMounted } from 'vue'
import { initFlowbite } from 'flowbite'

// initialize components based on data attribute selectors
onMounted(() => {
    initFlowbite();
})
</script>

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
            <div v-if="props.auth.notifications.length > 0" id="toast-container" class="fixed right-4 top-4 space-y-4">
            <Toast
                v-for="notification in props.auth.notifications"
                :key="notification.id"
                :type="notification.data.type ? notification.data.type : 'success'"
                :message="notification.data.message ? notification.data.message : ' '"
            />
        </div>
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
import Toast from "@/Components/Toast.vue";
import {usePage} from "@inertiajs/vue3";

const { props } = usePage();

onMounted(() => {
    initFlowbite();
})
</script>

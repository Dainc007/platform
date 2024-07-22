<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import ChatMessage from "@/Components/ChatMessage.vue";

defineProps({
    conversations: Array
});
</script>

<template>
    <Head title="Dashboard"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Articles</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-4">
                    <div class="bg-red-950 my-3 mx-aut" v-for="conversation in conversations">
                        <ChatMessage v-for="message in conversation.messages" :message></ChatMessage>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

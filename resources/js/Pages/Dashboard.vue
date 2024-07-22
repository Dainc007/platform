<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SendMessage from "@/Components/SendMessage.vue";
import ChatMessage from "@/Components/ChatMessage.vue";

const props = defineProps({
    friend: {
        type: Object,
        required: true,
    },
    currentUser: {
        type: Object,
        required: true,
    },
    conversation: {
        type: Object,
    }
});
</script>

<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Chatbox</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-2">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <ChatMessage v-for="message in conversation.messages" :message></ChatMessage>
                        <SendMessage :current-user="props.currentUser" :friend="props.friend"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

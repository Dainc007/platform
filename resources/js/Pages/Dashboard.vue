<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import SendMessage from "@/Components/SendMessage.vue";
import ChatMessage from "@/Components/ChatMessage.vue";
import {onMounted} from "vue";

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

onMounted(() => {
    if (props.conversation) {
        Echo.channel(`conversations.${props.conversation.id}`)
            .listen('MessageCreated', (event) => {
                props.conversation.messages.push(event.message);
            });
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
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-2 w-3/4  mx-auto">

                    <div class="p-6 overflow-y-auto h-96"> <!-- Use a fixed height for the chat area -->
                        <div v-if="conversation" v-for="message in conversation.messages" :key="message.id">
                            <ChatMessage :current-user="props.currentUser"  :message="message"></ChatMessage>
                        </div>
                    </div>

                    <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-b-lg w-34"> <!-- Different background for the input area -->
                        <SendMessage :current-user="props.currentUser" :friend="props.friend"/>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

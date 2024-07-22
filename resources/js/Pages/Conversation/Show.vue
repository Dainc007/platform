<template>
    <div>
        <h1>Conversation</h1>
        <div v-for="message in conversation.messages" :key="message.id" class="message">
            <p><strong>{{ message.user.name }}:</strong> {{ message.content }}</p>
        </div>
    </div>
</template>

<script setup>
import {defineProps, onMounted} from 'vue';

const props = defineProps({
    conversation: {
        type: Object,
        required: true,
    },
});

onMounted(() => {
    Echo.channel(`conversations.${props.conversation.id}`)
        .listen('MessageCreated', (event) => {
            console.log(event);
            props.conversation.messages.push(event.message);
        });
});
</script>

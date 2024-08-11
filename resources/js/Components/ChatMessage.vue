<script setup>

const props = defineProps({
    message: {
        type: Object,
        required: true,
    },
    currentUser: {
        type: Object
    }
});
</script>

<template>
    <div :key="message.id" class="flex flex-col mb-4" :class="{'items-end': message.user_id === currentUser.id, 'items-start': message.user_id !== currentUser.id}">
        <div class="flex items-center mb-1">
            <span v-if="message.user_id === currentUser.id" class="text-gray-500 text-sm">{{ new Date(message.created_at).toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' }) }}</span>
            <img
                :src="'https://i.pravatar.cc/150?u=' + message.user_id"
                alt="Avatar"
                class="w-10 h-10 rounded-full"
                :class="{'ml-3': message.user_id === currentUser.id, 'mr-3': message.user_id !== currentUser.id}"
            />
            <span v-if="message.user_id !== currentUser.id" class="text-gray-500 text-sm">{{ message.created_at }}</span>
        </div>
        <div class="flex items-center">
            <div
                v-if="message.user_id === currentUser.id"
                class="p-3 ml-auto text-white bg-blue-500 rounded-lg max-w-xs my-2"
            >
                {{ message.content }}
            </div>
            <div
                v-else
                class="my-2 p-3 mr-auto bg-purple-500 text-white rounded-lg max-w-xs"
            >
                {{ message.content }}
            </div>
        </div>
    </div>
</template>

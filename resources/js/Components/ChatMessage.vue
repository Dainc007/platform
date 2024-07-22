<script setup>

const props = defineProps({
    message: {
        type: Object,
        required: true,
    },
});
</script>

<template>
    <div :key="message.id" class="flex items-center mb-2">
        <div
            v-if="message.user_id === 1"
            class="p-2 ml-auto text-white bg-blue-500 rounded-lg w-2/3"
        >
            {{ message.content }}
        </div>
        <div v-else class="p-2 mr-auto bg-purple-500 rounded-lg w-2/3">
            {{ message.content }}
        </div>
    </div>
</template>

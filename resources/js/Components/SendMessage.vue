<template>
    <form @submit.prevent="submit">
        <div class="flex items-center">
            <input
                id="content" v-model="form.content"
                type="text"
                placeholder="Type a message..."
                class="flex-1 px-2 py-1 border rounded-lg text-gray-950"
                @keyup.enter="submit"
            />
            <small class="text-red-500" v-if="$page.props.errors.content">{{$page.props.errors.content}}</small>
            <button ref="send" type="submit"
                class="px-4 py-1 ml-2 text-white bg-blue-500 rounded-lg"
            >
                Send
            </button>
        </div>
    </form>
</template>
<script setup>
import {reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";

const form = reactive({
    content: null,
})
const send = ref(null);

defineProps({
    status: String
})

function submit() {
    router.post('/messages', form)
}
</script>

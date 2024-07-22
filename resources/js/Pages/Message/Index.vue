<template>
    <AuthenticatedLayout :user="auth.user">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">My Chat</h2>
        </template>
        <Head title="Chat" />
        <div class="max-w-2xl space-y-5 mx-auto p-4 sm:p-6 lg:p-8">
            <div class="h-full flex flex-col overflow-auto bg-white shadow-sm rounded-lg divide-y">
                <Message v-for="chat in chats" :key="chat.id" :chat="chat"  message=""/>
            </div>
            <div>
                <form @submit.prevent="submit" class="bottom-0 bg-white shadow-sm rounded-b-lg">
                    <div class="flex space-x-4">
<textarea
    v-model="form.message"
    placeholder="Type your message...."
    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring-opacity-50 rounded-md shadow-sm"
></textarea>
                        <InputError :message="errors.message" class="mt-2" />
                        <PrimaryButton class="mt-4" :disabled="processing">Send</PrimaryButton>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import InputError from "@/Components/InputError.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import Message from "@/Components/Message.vue";

export default {
    components: {Message, PrimaryButton, InputError, AuthenticatedLayout},
    props: {
        auth: Object,
        chats: Array,
    },
    setup() {
        const form = useForm({
            message: '',
        });

        const submit = () => {
            form.post(route('messages.store'), {
                onSuccess: () => form.reset(),
            });
        };

        return {
            form,
            submit,
            processing: form.processing,
            errors: form.errors,
        };
    },
};
</script>

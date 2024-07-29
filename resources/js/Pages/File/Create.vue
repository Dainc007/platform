<template>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">Upload File</h1>
        <form @submit.prevent="submit" class="space-y-4">
            <input
                type="file"
                @change="handleFileUpload"
                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
            />
            <button
                type="submit"
                class="w-full py-2 px-4 bg-blue-600  font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
            >
                Upload
            </button>
        </form>
        <p v-if="successMessage" class="mt-4 text-green-500">{{ successMessage }}</p>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useForm } from "@inertiajs/vue3";

export default {
    setup() {
        const form = useForm({
            file: null,
        });

        const successMessage = ref('');

        const handleFileUpload = (event) => {
            form.file = event.target.files[0];
        };

        const submit = () => {
            form.post(route('files.store'), {
                onSuccess: () => {
                    successMessage.value = 'File uploaded successfully!';
                },
            });
        };

        return {
            form,
            handleFileUpload,
            submit,
            successMessage,
        };
    },
};
</script>

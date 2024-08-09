<template>
    <AuthenticatedLayout>
        <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-200">Upload File</h1>
            <form @submit.prevent="submit" class="space-y-4">
                <input
                    type="file"
                    @change="handleFileUpload"
                    class="block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-gray-700 file:text-blue-700 dark:file:text-gray-300 hover:file:bg-blue-100 dark:hover:file:bg-gray-600"
                />
                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-blue-600 dark:bg-blue-700 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 dark:hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    Upload
                </button>
            </form>
            <p v-if="successMessage" class="mt-4 text-green-500 dark:text-green-400">{{ successMessage }}</p>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { useForm } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    components: {AuthenticatedLayout},
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

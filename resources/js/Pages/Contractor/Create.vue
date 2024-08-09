<template>
    <AuthenticatedLayout>
        <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">Add Contractor</h1>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Name</label>
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    />
                </div>
                <div>
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">File</label>
                    <input
                        type="file"
                        id="file"
                        @change="handleFileUpload"
                        class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800"
                    />
                </div>
                <div>
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Currency</label>
                    <select
                        id="currency_id"
                        v-model="form.currency_id"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    >
                        <option v-for="currency in currencies" :key="currency.id" :value="currency.id">
                            {{ currency.code }}
                        </option>
                    </select>
                </div>
                <div v-if="errors.currency_id" class="text-red-500">{{ errors.currency_id }}</div>
                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    Submit
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    components: { AuthenticatedLayout },
    props: {
        currencies: Array,
        errors: Object
    },
    setup(props) {
        const form = useForm({
            name: '',
            file: null,
            currency_id: null,
        });

        const handleFileUpload = (event) => {
            form.file = event.target.files[0];
        };

        const submit = () => {
            form.post(route('contractors.store'), {
                onSuccess: () => {
                    form.reset();
                },
            });
        };

        return {
            form,
            handleFileUpload,
            submit,
            currencies: props.currencies
        };
    },
};
</script>

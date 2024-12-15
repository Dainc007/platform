<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { useForm } from "@inertiajs/vue3";
import { ref } from "vue";

defineProps({
    currencies: Object,
    brands: Array,
    files: Object
});

const selectedFiles = ref([]);

const getFilesForm = useForm({
    brand_id: null
});

const analyseForm = useForm({
    brand_id: null,
    files: selectedFiles,
    currency_id: null,
    file:''
});

const submit = () => {
    analyseForm.files = selectedFiles;
    analyseForm.brand_id = getFilesForm.brand_id;
    analyseForm.post(route('analytics.store'), {
        forceFormData: true,
        onSuccess: () => {
            console.log(analyseForm);
            analyseForm.reset();
        },
        onError: (errors) => {
            console.log(analyseForm);
            analyseForm.errors = errors;
        }
    });
};

const handleFileUpload = (event) => {
    analyseForm.file = event.target.files[0];
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">{{ $t('analytics.header') }}</h1>
            <form class="space-y-4">
                <div class="my-5">
                    <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('contractor.brand') }}</label>
                    <select
                        :disabled="getFilesForm.processing"
                        @change="getFilesForm.get(route('analytics.index'), {preserveState: true}); selectedFiles = []"
                        v-model="getFilesForm.brand_id"
                        id="brand_id"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    >
                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                            {{ brand.name }}
                        </option>
                    </select>
                </div>
            </form>
            <form @submit.prevent="submit" enctype="multipart/form-data">
                <div v-if="getFilesForm.brand_id" class="bg-white divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600">
                    <ul class="overflow-y-auto max-h-24 p-3 text-sm text-gray-700 dark:text-gray-200">
                        <p v-if="getFilesForm.processing" class="text-green-500 text-lg w-full"> <i class="fa fa-spin fa-spinner"></i> Zaczekaj, ładuję cenniki</p>
                        <li v-for="file in files" :key="file.id" :value="file.id">
                            <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                <input
                                    v-model="selectedFiles"
                                    :id="'checkbox-' + file.id"
                                    type="checkbox"
                                    :value="file.id"
                                    name="filter-checkbox"
                                    class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                >
                                <label :for="'checkbox-' + file.id" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                    {{ file.path.replace('uploads/', '') }}
                                </label>
                            </div>
                        </li>
                    </ul>
                </div>

                <div class="my-5">
                    <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('contractor.file') }}</label>
                    <input
                        type="file"
                        id="file"
                        @change="handleFileUpload"
                        class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800"
                    />
                    <div v-if="analyseForm.errors.file" class="text-red-500">{{ analyseForm.errors.file }}</div>
                </div>

                <div class="my-5">
                    <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('contractor.currency') }}</label>
                    <select
                        id="currency_id"
                        v-model="analyseForm.currency_id"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    >
                        <option v-for="currency in currencies" :key="currency.id" :value="currency.id">
                            {{ currency.code }}
                        </option>
                    </select>
                    <div v-if="analyseForm.errors.currency_id" class="text-red-500">{{ analyseForm.errors.currency_id }}</div>
                </div>
                <button v-if="analyseForm && getFilesForm.brand_id && selectedFiles.length > 0"
                        type="submit"
                        @click="submit"
                        class="w-full py-2 px-4 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    {{ $t('contractor.submit') }}
                </button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

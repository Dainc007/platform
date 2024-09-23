<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {router, useForm} from "@inertiajs/vue3";
import {ref} from 'vue';

defineProps({
    brands: [],
    currencies: Object,
    files: Object
});

const form = useForm({
    file: null,
});

const search = ref('');

const handleFileUpload = (event) => {
    form.file = event.target.files[0];
};
</script>
<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg sm:md:mx-56">
                <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">{{ $t('analytics.header') }}</h1>
                <div class="my-2">
                    <label for="file"
                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{
                            $t('contractor.file')
                        }}</label>
                    <input
                        type="file"
                        id="file"
                        @change="handleFileUpload"
                        class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800"
                    />
                    <div v-if="form.errors.file" class="text-red-500">{{ form.errors.file }}</div>
                </div>
                <button
                    @click="form.post(route('analytics.store'))"
                    type="submit"
                    class="w-full py-2 px-4 mt-3 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    {{ $t('contractor.submit') }}
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

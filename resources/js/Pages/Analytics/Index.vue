<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, router, useForm} from "@inertiajs/vue3";
import {ref, watch} from 'vue';

defineProps({
    brands: [],
    currencies: Object,
    files: Object
});

const form = useForm({
    file: null,
    files: null,
    brand_id: null,
});

const search = ref('');

function reloadPage(brand_id) {
    router.reload({only: ['files'], data: {brand_id: brand_id}})
}

const handleFileUpload = (event) => {
    form.file = event.target.files[0];
};
</script>
<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">{{ $t('analytics.header') }}</h1>
                <div>
                    <label for="brand"
                           class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{
                            $t('contractor.brand')
                        }}</label>
                    <select
                        @change="reloadPage(form.brand_id)"
                        id="brand"
                        v-model="form.brand_id"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    >
                        <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                            {{ brand.name }}
                        </option>
                    </select>
                    <div v-if="form.errors.brand_id" class="text-red-500">{{ form.errors.brand_id }}</div>
                </div>

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

                <div class="my-2">
                    <label for="files" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$t('analytics.offer.comparison')}}</label>
                    <select multiple id="files" v-model="form.files"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="file in files" :key="file.id" :value="file.id">{{ file.path }}</option>
                    </select>
                    <div v-if="form.errors.files" class="text-red-500">{{ form.errors.files }}</div>
                </div>

                <button
                    @click="form.post(route('analytics.store'))"
                    type="submit"
                    class="w-full py-2 px-4 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    {{ $t('contractor.submit') }}
                </button>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

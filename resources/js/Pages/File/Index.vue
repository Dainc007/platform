<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, router} from "@inertiajs/vue3";
import { ref, watch } from 'vue';
import {Inertia} from "@inertiajs/inertia";

defineProps({
    files: Array,
});

const search = ref('');

const destroy = (id) => {
    if(confirm('Are you sure?')) {
        Inertia.delete(route('files.destroy', id))
    }
    return (destroy)
}

const download = (id) => {
    Inertia.get(route('files.show', id));
}

watch(search, (search) => {
    router.get('/files', { search: search }, { preserveState: true, replace: true });
});

</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="flex items-center justify-between flex-wrap space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                    <div>
                        <button id="dropdownActionFileButton" data-dropdown-toggle="dropdownActionFile"
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                            <span class="sr-only">Action button</span>
                            Action
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownActionFile"
                             class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownActionFileButton">
                                <li>
                                    <a :href="route('files.create')" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Create</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <label for="table-search" class="sr-only">Search</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="table-search-files"
                               class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-full md:w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               placeholder="Search for files"
                               v-model="search">
                    </div>
                </div>
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            <div class="flex items-center">
                                <input id="checkbox-all-search" type="checkbox"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-all-search" class="sr-only">checkbox</label>
                            </div>
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="file in files.data" v-if="files && files.data.length" :key="file.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="ps-3">
                                <div class="text-base font-semibold">{{ file.path }}</div>
                                <div class="font-normal text-gray-500">{{file.path}}</div>
                            </div>
                        </th>
                        <td class="px-6 py-4 text-center">
                            <button @click="destroy(file.id)" title="Usuń" class="m-1 p-1 text-white bg-red-600 dark:bg-red-700 hover:bg-red-500 dark:hover:bg-red-600 border border-red-200 dark:border-red-600 focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-700 font-medium rounded-lg text-xs px-2 py-1 text-center inline-flex items-center">
                                <i class="mx-1 py-1 fa-solid fa-trash"></i> <!-- Ikona usuwania -->
                            </button>
                            <button v-if="file.status === 'ready'" @click="download(file.id)" title="Pobierz" class="m-1 p-1 text-white bg-blue-600 dark:bg-blue-700 hover:bg-blue-500 dark:hover:bg-blue-600 border border-blue-200 dark:border-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-100 dark:focus:ring-blue-700 font-medium rounded-lg text-xs px-2 py-1 text-center inline-flex items-center">
                                <i class="mx-1 py-1 fa-solid fa-download"></i> <!-- Ikona pobierania -->
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <nav class="flex items-center flex-wrap justify-between pt-4" aria-label="Table navigation">
<span class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
<!-- Showing <span class="font-semibold text-gray-900 dark:text-white">1-10</span> of <span class="font-semibold text-gray-900 dark:text-white">1000</span> -->
</span>
                    <ul class="inline-flex -space-x-px text-sm h-8">
                        <Link v-if="files && files.links" v-for="(link, index) in files.links" :key="index" :href="link.url" class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white" v-html="link.label"/>
                    </ul>
                </nav>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Inertia} from "@inertiajs/inertia";

defineProps({
    files: Array,
});
const download = (id, files) => {
    Inertia.get(route('ftp.show', [id, files]));
}

const destroy = (id, files) => {
    if(confirm('Are you sure?')) {
        Inertia.delete(route('ftp.destroy', [id,  files]))
    }
    return (destroy)
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Name
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            Action
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(path, key) in files" v-if="files" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <th scope="row" class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="ps-3">
                                <div class="text-base font-semibold">{{ path }}</div>
                            </div>
                        </th>
                        <td class="px-6 py-4 text-center">
                            <button @click="destroy(key, files)" title="Usuń" class="m-1 p-1 text-white bg-red-600 dark:bg-red-700 hover:bg-red-500 dark:hover:bg-red-600 border border-red-200 dark:border-red-600 focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-700 font-medium rounded-lg text-xs px-2 py-1 text-center inline-flex items-center">
                                <i class="mx-1 py-1 fa-solid fa-trash"></i> <!-- Ikona usuwania -->
                            </button>
                            <button @click="download(key, files)" title="Pobierz" class="m-1 p-1 text-white bg-blue-600 dark:bg-blue-700 hover:bg-blue-500 dark:hover:bg-blue-600 border border-blue-200 dark:border-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-100 dark:focus:ring-blue-700 font-medium rounded-lg text-xs px-2 py-1 text-center inline-flex items-center">
                                <i class="mx-1 py-1 fa-solid fa-download"></i> <!-- Ikona pobierania -->
                            </button>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

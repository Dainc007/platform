<template>
    <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
        <slot/>
    </div>

    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
        <tr>
            <th scope="col" class="p-4">
                <div class="flex items-center">
                    <input id="checkbox-all-search" type="checkbox"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                </div>
            </th>
            <th v-for="column in columns" scope="col" class="px-6 py-3">
                {{ column }}
            </th>
            <th scope="col" class="px-6 py-3">
                Action
            </th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="row in rows.data" v-if="rows.data.length" :key="row.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="w-4 p-4">
                <div class="flex items-center">
                    <input id="checkbox-table-search-1" type="checkbox"
                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                </div>
            </td>
            <th scope="row"
                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                <img class="w-10 h-10 rounded-full"
                     :src="'https://i.pravatar.cc/150?u=' + row.id"
                     alt="Jese image">
                <div class="ps-3">
                    <div class="text-base font-semibold">{{ row.name }}</div>
                    <div class="font-normal text-gray-500">{{row.email}}</div>
                </div>
            </th>
            <td class="px-6 py-4">
                <div v-if="Math.random() >= 0.5" class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-green-500 me-2"></div>
                    Online
                </div>
                <div v-else class="flex items-center">
                    <div class="h-2.5 w-2.5 rounded-full bg-red-500 me-2"></div>
                    Online
                </div>
            </td>
            <td class="px-6 py-4">
                <a :href="route('users.edit', row)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-auto">Edit</a>
                <a :href="route('users.destroy', row)" class="font-medium text-red-600 dark:text-red-500 hover:underline mx-auto">Delete</a>
            </td>
        </tr>
        </tbody>
    </table>
    <Pagination :links="rows.links"></Pagination>
</template>

<script setup>

import Pagination from "@/Components/Table/Pagination.vue";

defineProps({
    rows: Object,
    columns: Array
});
</script>

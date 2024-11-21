<template>
    <AuthenticatedLayout>

        <template #header>
            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <ol v-if="!$page.props.auth.isAdmin" class=" mt-3 items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
                    <li class=" text-blue-600 flex items-center dark:text-blue-500 space-x-2.5 rtl:space-x-reverse">
                  <span
                      class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
            1
        </span>
                        <span>
            <h3 class="font-medium leading-tight">Operacje</h3>
        </span>
                    </li>
                    <li :class="['flex items-center dark:text-blue-500 space-x-2.5 rtl:space-x-reverse', { 'text-blue-600': activeStep === 2 }]">
        <span
            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            2
        </span>
                        <span>
            <h3 class="font-medium leading-tight">Data (spotkania i wniosek o dni wolne)</h3>
        </span>
                    </li>
                    <li :class="['flex items-center dark:text-blue-500 space-x-2.5 rtl:space-x-reverse', { 'text-blue-600': activeStep === 3 }]">
        <span
            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            3
        </span>
                        <span>
            <h3 class="font-medium leading-tight">Dane</h3>
        </span>
                    </li>
                    <li :class="['flex items-center dark:text-blue-500 space-x-2.5 rtl:space-x-reverse', { 'text-blue-600': activeStep === 4 }]">
        <span
            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            4
        </span>
                        <span>
            <h3 class="font-medium leading-tight">Potwierdzenie</h3>
        </span>
                    </li>
                </ol>
            </div>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto">
                    <Link :href="route('meetings.index')" class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 text-center">
                        Spotkania
                    </Link>
                    <Link :href="route('vacations.index')" class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                        Wniosek o dni wolne
                    </Link>
                </div>
            </div>
        </div>

    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link} from '@inertiajs/vue3';
</script>

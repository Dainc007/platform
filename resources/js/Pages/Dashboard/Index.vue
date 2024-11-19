<template>
    <AuthenticatedLayout>

        <template #header>
            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <ul class="steps">
                <li class="step step-primary">Operacje</li>
                <li class="step">Data</li>
                <li class="step">Dane</li>
                <li class="step">Potwierdzenie</li>
                </ul>
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

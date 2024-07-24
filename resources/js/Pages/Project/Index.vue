<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';

defineProps({
    projects: Array
});
</script>

<template>
    <Head title="Projects"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Projects</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div v-if="projects" v-for="project in projects"
                         class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-4 dark:hover:bg-gray-700">
                        <span
                            class="ml-3 mt-2 inline-flex items-center px-3 py-2 text-sm font-medium text-center text-white rounded-lg focus:ring-4 focus:outline-none"
                            :class="{
                            'bg-green-700 hover:bg-green-800 focus:ring-green-300 dark:bg-green-600 dark:hover:bg-green-700 dark:focus:ring-green-800': project.status === 'opened',
                            'bg-red-700 hover:bg-red-800 focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800': project.status === 'closed'
                            }"
                        >
                            {{ project.status }}
                        </span>
                        <a href="#"
                           class="block max-w-sm p-4 bg-white rounded-lg shadow hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ project.name }}
                            </h5>
                            <p class="font-normal text-gray-700 dark:text-gray-400">
                                {{ project.description }}
                            </p>

                        </a>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

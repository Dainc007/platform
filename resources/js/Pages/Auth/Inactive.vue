<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link } from '@inertiajs/vue3';
</script>

<template>
    <GuestLayout>
        <Head :title="$t('auth.inactive.title')" />

        <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
            {{ $t('auth.inactive.message') }}
        </div>

        <div class="mt-4 flex items-center justify-between">
            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800"
            >
                {{ $t('logout') }}
            </Link>
        </div>
    </GuestLayout>
</template>

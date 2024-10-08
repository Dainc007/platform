<script setup>
import {ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import {Link, usePage} from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
</script>

<template>
    <nav class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">
        <!-- Primary Navigation Menu -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <!-- Logo -->
                    <div class="shrink-0 flex items-center">
                        <Link :href="route('dashboard')">
                            <ApplicationLogo
                                class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200"
                            />
                        </Link>
                    </div>

                    <!-- Navigation Links -->
                    <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                        <template v-for="setting in usePage().props.settings">
                            <NavLink
                                v-if="setting && setting.value === 1"
                                :key="setting.id"
                                :href="route(setting.name + '.index')"
                                :active="route().current(setting.name + '*')"
                            >
                                {{ $t(`nav.${setting.name}`) }}
                            </NavLink>
                        </template>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <Dropdown align="right" width="48">
                            <template #trigger>
                                        <span v-if="$page.props.auth.user" class="inline-flex rounded-md">
                                            <button
                                                type="button"
                                                class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150"
                                            >
                                                {{ $page.props.auth.user.name }}

                                                <svg
                                                    class="ms-2 -me-0.5 h-4 w-4"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    viewBox="0 0 20 20"
                                                    fill="currentColor"
                                                >
                                                    <path
                                                        fill-rule="evenodd"
                                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                        clip-rule="evenodd"
                                                    />
                                                </svg>
                                            </button>
                                        </span>
                            </template>

                            <template #content>
                                <template v-if="$page.props.auth.isAdmin">
                                    <DropdownLink :href="route('admin.dashboard')">{{$t('admin.panel')}}</DropdownLink>
                                    <a class="block w-full px-4 py-2 text-start text-sm leading-5 text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-800 transition duration-150 ease-in-out"
                                       :href="route('pulse')">{{ $t('admin.pulse') }}</a>
                                </template>
                                <DropdownLink :href="route('profile.edit')">{{$t('profile')}}</DropdownLink>
                                <DropdownLink :href="route('logout')" method="post" as="button">
                                    {{$t('logout')}}
                                </DropdownLink>
                            </template>
                        </Dropdown>
                    </div>
                </div>

                <!-- Hamburger -->
                <div class="-me-2 flex items-center sm:hidden">
                    <button
                        @click="showingNavigationDropdown = !showingNavigationDropdown"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out"
                    >
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path
                                :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex': !showingNavigationDropdown,
                                        }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16"
                            />
                            <path
                                :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex': showingNavigationDropdown,
                                        }"
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"
                            />
                        </svg>
                    </button>
                </div>
            </div>
        </div>

        <!-- Responsive Navigation Menu -->
        <div
            :class="{ block: showingNavigationDropdown, hidden: !showingNavigationDropdown }"
            class="sm:hidden"
        >
            <div class="pt-2 pb-3 space-y-1">
                <template v-for="setting in usePage().props.settings">
                    <ResponsiveNavLink
                        v-if="setting && setting.value === 1"
                        :key="setting.id"
                        :href="route(setting.name + '.index')"
                        :active="route().current(setting.name)"
                    >
                        {{ $t(`nav.${setting.name}`) }}
                    </ResponsiveNavLink>
                </template>
            </div>

            <!-- Responsive Settings Options -->
            <div  class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                <div v-if="$page.props.auth.user" class="px-4">
                    <div v-if="$page.props.auth.user" class="font-medium text-base text-gray-800 dark:text-gray-200">
                        {{ $page.props.auth.user.name }}
                    </div>
                    <div v-if="$page.props.auth.user" class="font-medium text-sm text-gray-500">{{ $page.props.auth.user.email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <template v-if="$page.props.auth.isAdmin">
                        <ResponsiveNavLink :href="route('admin.dashboard')">{{$t('admin.panel')}}</ResponsiveNavLink>
                        <ResponsiveNavLink :href="route('pulse')">{{$t('admin.pulse')}}</ResponsiveNavLink>
                    </template>
                    <ResponsiveNavLink :href="route('profile.edit')">{{$t('profile')}}</ResponsiveNavLink>
                    <ResponsiveNavLink :href="route('logout')" method="post" as="button">
                        {{$t('logout')}}
                    </ResponsiveNavLink>
                </div>
            </div>
        </div>
    </nav>
</template>

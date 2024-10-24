<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kalkulator</h2>
        </template>

        <div class="mt-3">
            <form class="max-w-sm mx-auto">
                <div class="mb-5">
                    <label for="installationType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Rodzaj instalacji</label>
                    <select id="installationType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="installationType in installationTypes"  :key="installationType"> {{installationType}}</option>
                    </select>
                </div>

                <div class="mb-5">
                    <fieldset>
                        <legend class="sr-only">Rodzaj Zestawu</legend>
                        <label class="block text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">Rodzaj Zestawu</label>
                        <div class="flex items-center space-x-4">
                            <div class="flex items-center">
                                <input id="standard" type="radio" name="countries" value="standard" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" checked>
                                <label for="standard" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Standard</label>
                            </div>
                            <div class="flex items-center">
                                <input id="premium" type="radio" name="countries" value="Germany" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                <label for="premium" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Premium</label>
                            </div>
                        </div>
                    </fieldset>
                </div>

                <div class="mb-5">
                    <label for="panel" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Rodzaj instalacji</label>
                    <select id="panel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option v-for="installationType in installationTypes"  :key="installationType"> {{installationType}}</option>
                    </select>
                </div>

                <div class="flex items-start mb-5">
                    <div class="flex items-center h-5">
                        <input id="remember" type="checkbox" value="" class="w-4 h-4 border border-gray-300 rounded bg-gray-50 focus:ring-3 focus:ring-blue-300 dark:bg-gray-700 dark:border-gray-600 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800" required />
                    </div>
                    <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Remember me</label>
                </div>
                <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
            </form>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>

import {defineComponent} from "vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import ChatMessage from "@/Components/ChatMessage.vue";
import SendMessage from "@/Components/SendMessage.vue";

defineProps({
    installationTypes: Array,
});
</script>

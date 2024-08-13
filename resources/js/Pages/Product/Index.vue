<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, router} from "@inertiajs/vue3";
import { ref, watch } from 'vue';

defineProps({
    products: Array,
});

const search = ref('');

watch(search, (search) => {
    router.get('/products', { search: search }, { preserveState: true, replace: true });
});

function formatPrice(price) {
    return (price / 100).toFixed(2).replace('.', ',');
}



</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div
                    class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                    <label for="table-search" class="sr-only">{{$t('search')}}</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="table-search-users"
                               class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                               :placeholder="$t('search')"
                               v-model="search">
                    </div>
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
                        <th scope="col" class="px-6 py-3">
                            {{$t('product.name')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{$t('product.brand')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{$t('product.contractor')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{$t('product.price')}}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            {{$t('product.quantity')}}
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="product in products.data" v-if="products.data.length" :key="product.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div class="ps-3">
                                <div class="text-base font-semibold">{{ product.code }}</div>
                                <div class="font-normal text-gray-500">Ostatnia modyfikacja: {{ product.updated_at}}</div>
                            </div>
                        </th>
                        <td class="px-6 py-4">
                            {{product.brand.name}}
                        </td>
                        <td class="px-6 py-4">
                            {{product.contractor.name}}
                        </td>
                        <td class="px-6 py-4">
                            {{formatPrice(product.price)}} {{product.currency.code}}

                        </td>
                        <td class="px-6 py-4">
                            {{product.quantity}}
                        </td>
                    </tr>
                    </tbody>
                </table>
                <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
                     aria-label="Table navigation">
                    <span
                        class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
<!--                        Showing <span-->
                        <!--                        class="font-semibold text-gray-900 dark:text-white">1-10</span> of <span-->
                        <!--                        class="font-semibold text-gray-900 dark:text-white">1000</span>-->
                    </span>
                    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                        <Link
                            v-for=" (link, index) in products.links"
                            :key="index"
                            :href="link.url"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            v-html="link.label"
                        />
                    </ul>
                </nav>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

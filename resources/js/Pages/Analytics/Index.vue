<script setup xmlns="http://www.w3.org/1999/html">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {Link, router, useForm} from "@inertiajs/vue3";
import {ref, watch} from 'vue';
import {Inertia} from "@inertiajs/inertia";

defineProps({
    products: Object,
    brands: [],
    currencies: Object,
    files: Object
});


const search = ref('');
const filter = ref('');

const form = useForm({
    file: null,
    files: [],
    brand_id: null,
    search: ''
});

const exportForm = useForm({
    products: []
})

watch(search, (search) => {
    router.get('/analytics', {search: search}, {preserveState: true, replace: true});
});
watch(filter, (filter) => {
    router.get('/analytics', {filter: filter}, {preserveState: true, replace: true});
});

function exportProducts(form)  {
    Inertia.post(route('analytics.export', form))
}

function truncate() {
    if (confirm('Are you sure?')) {
        return Inertia.delete(route('analytics.truncate'));

    }
}

function reloadPage(brand_id) {
    router.reload({only: ['files'], data: {brand_id: brand_id}})
}
function reloadProducts(event, fileId) {
    const isChecked = event.target.checked;

    if (isChecked) {
        if (!this.form.files.includes(fileId)) {
            this.form.files.push(fileId);
        }
    } else {
        this.form.files = this.form.files.filter(id => id !== fileId);
    }
    router.reload({only: ['products'], data: {files: this.form.files}})
}
function formatPrice(price) {
    return (price / 100).toFixed(2).replace(".", ",");
}

function roundedNumber(number) {
    return Math.round(number);
}
</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg min-h-[500px] ">
                <h1 class="text-white">Wybierz Markę</h1>
                <div class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 pb-4 bg-white dark:bg-gray-900">
                    <div>
                        <select
                            @change="reloadPage(form.brand_id)"
                            id="brand"
                            v-model="form.brand_id"
                            class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                        >
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                        <div v-if="form.errors.brand_id" class="text-red-500">{{ form.errors.brand_id }}</div>
                    </div>

                    <div>
                        <button id="dropdownCheckboxButton" data-dropdown-toggle="dropdownCheckbox"
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700" type="button">
                            <svg class="w-3 h-3 text-gray-500 dark:text-gray-400 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M10 0a10 10 0 1 0 10 10A10.011 10.011 0 0 0 10 0Zm3.982 13.982a1 1 0 0 1-1.414 0l-3.274-3.274A1.012 1.012 0 0 1 9 10V6a1 1 0 0 1 2 0v3.586l2.982 2.982a1 1 0 0 1 0 1.414Z"/>
                            </svg>
                            Pliki
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownCheckbox" class="z-10 hidden w-48 bg-white divide-y divide-gray-100 rounded-lg shadow dark:bg-gray-700 dark:divide-gray-600" data-popper-reference-hidden="" data-popper-escaped="" data-popper-placement="top" style="position: absolute; inset: auto auto 0 0; margin: 0; transform: translate3d(522.5px, 3847.5px, 0px);">
                            <ul class="p-3 space-y-1 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownCheckboxButton">
                                <li v-for="file in files" :key="file.id" :value="file.id">
                                    <div class="flex items-center p-2 rounded hover:bg-gray-100 dark:hover:bg-gray-600">
                                        <input
                                            @change="reloadProducts($event, file.id)"
                                            :id="'checkbox-' + file.id" type="checkbox" :value="file.id" name="filter-checkbox" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                        <label :for="'checkbox-' + file.id" class="w-full ms-2 text-sm font-medium text-gray-900 rounded dark:text-gray-300">
                                            {{ file.path.replace('uploads/', '') }}
                                        </label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div>
                        <button id="dropdownActionContractorButton" data-dropdown-toggle="dropdownActionContractor"
                                class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                                type="button">
                            <span class="sr-only">Action button</span>
                            {{ $t('actions') }}
                            <svg class="w-2.5 h-2.5 ms-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                 fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m1 1 4 4 4-4"/>
                            </svg>
                        </button>
                        <!-- Dropdown menu -->
                        <div id="dropdownActionContractor"
                             class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow w-44 dark:bg-gray-700 dark:divide-gray-600">
                            <ul class="py-1 text-sm text-gray-700 dark:text-gray-200"
                                aria-labelledby="dropdownActionContractorButton">
                                <li>
                                    <Link :href="route('analytics.create')"
                                          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        {{ $t('actions.import') }}
                                    </Link>
                                </li>
                                <li>
                                    <a :href="route('analytics.export', form)"
                                          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        {{ $t('actions.export') }}
                                    </a>
                                </li>
                                <li>
                                    <a @click="truncate"
                                          class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                        {{ $t('actions.truncate') }}
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <label for="table-search" class="sr-only">{{ $t('search') }}</label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                 xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                      stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                            </svg>
                        </div>
                        <input type="text" id="table-search-analytics"
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
                            {{ $t('name') }}
                        </th>
                        <th scope="col" class="px-6 py-3">
                            cena partio
                        </th>
                        <th scope="col" class="px-6 py-3">
                            cena oferty
                        </th>
                        <th scope="col" class="px-6 py-3">
                            różnica w cenie
                        </th>
                        <th scope="col" class="px-6 py-3">
                                %
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="products" v-for="product in products.data" :key="product.id"
                        class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="w-4 p-4">
                            <div class="flex items-center">
                                <input id="checkbox-table-search-1" type="checkbox"
                                       class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                            </div>
                        </td>
                        <th scope="row"
                            class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                            <div>
                                <div class="text-base font-semibold">{{ product.code }}</div>
                                <div class="font-normal text-gray-500">{{ product.brand.name }}</div>
                            </div>
                        </th>

                        <th scope="row">
                            {{formatPrice(product.product_price)}}
                        </th>
                        <th scope="row">
                            {{formatPrice(product.temp_product_price)}}
                        </th>
                        <th scope="row">
                            {{formatPrice(product.price_difference)}}
                        </th>
                        <th scope="row" :class="{'text-green-500': product.price_difference_percentage > 0, 'text-red-500': product.price_difference_percentage < 0}">
                            {{ roundedNumber(product.price_difference_percentage) }} %
                        </th>
                    </tr>
                    </tbody>
                </table>
                <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
                     aria-label="Table navigation">
                    <span
                        class="text-sm font-normal text-gray-500 dark:text-gray-400 mb-4 md:mb-0 block w-full md:inline md:w-auto">
                    </span>
                    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                        <Link
                            v-if="products && products.links" v-for=" (link, index) in products.links"
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

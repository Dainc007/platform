<script setup>

import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {router, useForm} from "@inertiajs/vue3";
import { ref, watch } from 'vue';
import Switcher from "@/Components/Switcher.vue";

const showDetails = ref(false);

const form = useForm({
    installationType: 'Instalacja fotowoltaiczna z magazynem energii',
    setType: 'standard',
    panel: 'Trina solar Vertex S+ Dual Glass N-Type Black Frame 1762 x 1134',
    montage: 'Dach',
    montageSystemType: 'BLACHODACHÓWKA',
    fireProtection: 'Wyłącznik P.POŻ (PROJOY)',
    commission:2000,
    constCommission:10000,
    extraCommission:0,
    finalCommission:0,
    basicMontagePrice:36594,
    minSellingPriceNetto:0,
    netto:0,
    vatPercentage:8,
    vat:0,
    brutto:0,
    thermo:0,
    finalInvestment:0,
    companyCar:0
});

defineProps({
    installationTypes: Array,
    panels:Array,
    montageSystemTypes: Array
});

watch(form, (form) => {
    router.get('/calculators', { form: form }, { preserveState: true, replace: true, preserveScroll: true });

    form.panel = form.setType === 'standard' ? 'Trina solar Vertex S+ Dual Glass N-Type Black Frame 1762 x 1134' :
        'Sunlink N-type Bifacial Black Frame 1722x1134';

    form.finalCommission = form.extraCommission + form.commission;

    form.minSellingPriceNetto = form.basicMontagePrice + form.constCommission;

    form.netto = form.basicMontagePrice;
    form.vat = form.netto * form.vatPercentage / 100;
    form.brutto = form.netto + form.vat;
});
</script>

<template>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Kalkulator</h2>
        </template>

        <div class="container mx-auto py-12 overflow-hidden">
            <form class="flex flex-col md:flex-row gap-4">
                <!-- Kolumna X -->
                <div class="w-full md:w-2/3 p-6 dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="mt-3">
                            <div class="mb-5">
                                <label for="installationType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Rodzaj instalacji</label>
                                <select v-model="form.installationType" id="installationType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="installationType in installationTypes"  :key="installationType"> {{installationType}}</option>
                                </select>
                            </div>

                            <div class="mb-5">
                                <fieldset class="grid gap-6 lg:grid-cols-3">
                                    <legend class="sr-only">Rodzaj Zestawu</legend>
                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">Rodzaj Zestawu</label>
                                    <div class="flex items-center space-x-4">
                                        <div class="flex items-center">
                                            <input v-model="form.setType" id="setType" type="radio" name="countries" value="standard" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" checked>
                                            <label for="standard" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Standard</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input v-model="form.setType" id="setType" type="radio" name="countries" value="premium" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="premium" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Premium</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>





                        <div class="grid gap-6 mb-6 lg:grid-cols-2">
                            <div>
                                <input v-model="form.panel" disabled
                                       type="text" id="panel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                            </div>
                            <div class="mb-5">
                                <select id="installationType"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="panel in panels" :key="panel.amount" :value="panel.value">
                                        {{ panel.text }}
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <select id="inverter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option>Falownik zwykły</option>
                                <option>Falownik hybrydowy</option>
                            </select>

                            <div>
                                <select id="product"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="panel in panels" :key="panel.amount" :value="panel.value">
                                        {{ panel.text }}
                                    </option>
                                </select>
                            </div>


                            <div class="relative flex items-center max-w-[8rem]">
                                <button type="button" id="decrement-button"
                                        data-input-counter-decrement="quantity-input"
                                        class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </button>
                                <input type="text" min="0" id="quantity-input"
                                       data-input-counter aria-describedby="helper-text-explanation"
                                       class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="0" required
                                />
                                <button type="button" id="increment-button"
                                        data-input-counter-increment="quantity-input"
                                        class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                </button>
                            </div>

                        </div>



                        <div class="mb-5">
                            <label for="montage"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Montaż</label>
                            <select id="montage" v-model="form.montage"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                              <option>Dach</option>
                                <option>Grunt</option>
                                <option>Nie dotyczy</option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="montageSystemType"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">  Rodzaj systemu montażowego  </label>
                            <select id="montageSystemType" v-model="form.montageSystemType"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option v-for="montageSystemType in montageSystemTypes" :key="montageSystemType" :value="montageSystemType">
                                    {{ montageSystemType }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="fireProtection"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">  Wyłącznik PPOŻ i  </label>
                            <select id="fireProtection" v-model="form.fireProtection"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option>
                                    Wyłącznik P.POŻ (PROJOY)
                                </option>
                                <option>
                                    Nie Dotyczy
                                </option>
                            </select>
                        </div>

                        <div class="mb-5">
                            <label for="quantity-input"
                                   class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">szt:</label>
                            <div class="relative flex items-center max-w-[8rem]">
                                <button type="button" id="decrement-button"
                                        data-input-counter-decrement="quantity-input"
                                        class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-s-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 2">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M1 1h16"/>
                                    </svg>
                                </button>
                                <input type="text" id="quantity-input"
                                       data-input-counter aria-describedby="helper-text-explanation"
                                       class="bg-gray-50 border-x-0 border-gray-300 h-11 text-center text-gray-900 text-sm focus:ring-blue-500 focus:border-blue-500 block w-full py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                       placeholder="0" required
                                       value="1"
                                />
                                <button type="button" id="increment-button"
                                        data-input-counter-increment="quantity-input"
                                        class="bg-gray-100 dark:bg-gray-700 dark:hover:bg-gray-600 dark:border-gray-600 hover:bg-gray-200 border border-gray-300 rounded-e-lg p-3 h-11 focus:ring-gray-100 dark:focus:ring-gray-700 focus:ring-2 focus:outline-none">
                                    <svg class="w-3 h-3 text-gray-900 dark:text-white" aria-hidden="true"
                                         xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 18 18">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="M9 1v16M1 9h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div>
                                <input disabled value="Dodatkowy Kabel" type="text" id="extraCable" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required />
                            </div>

                            <div>

                                <select id="extraCabelFormat" v-model="form.extraCabelFormat"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option>
                                        Mb
                                    </option>
                                    <option>
                                        kW
                                    </option>
                                    <option>
                                        Nie Dotyczy
                                    </option>
                                </select>
                            </div>

                            <div>
                                <input type="number" id="extraCabelAmount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                            </div>
                        </div>

                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div>
                                <input disabled value="Przekop" type="text" id="tunnel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required />
                            </div>

                            <div>
                                <select id="fireProtection" v-model="form.tunnelFormat"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option>
                                        Mb
                                    </option>
                                    <option>
                                        kW
                                    </option>
                                    <option>
                                        Nie Dotyczy
                                    </option>
                                </select>
                            </div>

                            <div>
                                <input type="number" id="tunnelAmount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                            </div>
                        </div>

                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div>
                                <select id="energy" v-model="form.energy"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option>
                                        Magazyn Energii 5kW
                                    </option>
                                    <option>
                                        Magazyn Energii 10kW
                                    </option>
                                    <option>
                                        Magazyn Energii 15kW
                                    </option>
                                    <option>
                                        Magazyn Energii 20kW
                                    </option>
                                    <option>
                                        Magazyn Energii 25kW
                                    </option>
                                    <option>
                                        Magazyn Energii 30kW
                                    </option>
                                </select>
                            </div>

                            <div>
                                <select id="fireProtection" v-model="form.fireProtection"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option>
                                        Mb
                                    </option>
                                    <option>
                                        kW
                                    </option>
                                    <option>
                                        Nie Dotyczy
                                    </option>
                                </select>
                            </div>

                            <div>
                                <input type="number" id="visitors" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="" required />
                            </div>
                        </div>



                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Submit</button>
                    </div>
                </div>
                <!-- Kolumna Y -->
                <div class="w-full md:w-1/3 p-6 dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="mt-3">
                        <label for="vatPercentage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VAT</label>
                        <select v-model="form.vatPercentage" id="vatPercentage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="8">8%</option>
                            <option value="23">23%</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label for="thermoDiscount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ulga termomodernizacyjna</label>
                        <select id="thermoDiscount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>12%</option>
                            <option>19%</option>
                            <option>32%</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <Switcher
                            :label="'Dotacja Mój prąd 6.0'"
                         :checked="false"
                        />
                    </div>

                    <div class="mt-3">
                        <label for="freshAirDiscount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dotacja Czyste Powietrze</label>
                        <select id="freshAirDiscount" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>0zł</option>
                            <option>1 Próg PV 6000zł</option>
                            <option>2 Próg PV 9000zł</option>
                            <option>3 Próg PV 15000zł</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <Switcher
                            id="details"
                            v-model="showDetails"
                            :label="'Rozwiń/zwiń szczegóły+'"
                            :checked="showDetails"
                        />
                    </div>

                    <div id="detailsBox">
                        <div class="mt-3">
                            <Switcher
                                :label="'Dom+'"
                                :checked="false"
                            />
                        </div>
                        <div class="mt-3">
                            <Switcher
                                :label="'Assistance+'"
                                :checked="false"
                            />
                        </div>
                        <div class="mt-3">
                            <Switcher
                                :label="'Holiday+'"
                                :checked="false"
                            />
                        </div>

                        <div class="mb-5">
                            <label for="extraCommission" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Wysokość Narzutu</label>
                            <input v-model="form.extraCommission"
                                   type="number" id="extraCommission" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                        </div>

                        <div class="mt-3">
                            <div class="relative overflow-x-auto">
                                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <tbody>
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Company Car
                                        </th>
                                        <td class="px-6 py-4">
                                            NIE
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Stanowisko
                                        </th>
                                        <td class="px-6 py-4">
                                            Handlowiec
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Twoja prowizja
                                        </th>
                                        <td class="px-6 py-4">
                                            {{Number(form.commission).toLocaleString()}} zł
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Prowizja Łącznie
                                        </th>
                                        <td class="px-6 py-4">
                                            {{Number(form.finalCommission).toLocaleString()}} zł
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Cena bazowa montażu
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ Number(form.basicMontagePrice).toLocaleString() }} zł
                                        </td>
                                    </tr>
                                    <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                        <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            Cena minimalna sprzedaży netto
                                        </th>
                                        <td class="px-6 py-4">
                                            {{ Number(form.minSellingPriceNetto).toLocaleString()}} zł
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="paymentMethod" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Forma Finansowania</label>
                        <select id="paymentMethod"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option>Gotówka</option>
                            <option>Kredyt</option>
                            <option>Prefinansowanie</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <Switcher
                            :label="'Prefinansowanie'"
                            :checked="false"
                        />
                        To sie pokazuje w przypadku zaznaczonego
                        Wniosek na prefi: 1300,00 zł
                        Audyt: 1200,00 zł
                    </div>

                    <div class="mt-3">
                        <div class="relative overflow-x-auto">
                            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <tbody>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Suma netto
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ Number(form.netto).toLocaleString() }} zł
                                    </td>
                                </tr>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        VAT
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ Number(form.vat).toLocaleString() }} zł
                                    </td>
                                </tr>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Suma brutto
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ Number(form.brutto).toLocaleString()}} zł
                                    </td>
                                </tr>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Ulba termomodernizacyjna
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ Number(form.thermo).toLocaleString() }} zł
                                    </td>
                                </tr>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Finalna wartość inwestycji
                                    </th>
                                    <td class="px-6 py-4">
                                        {{Number(form.finalInvestment).toLocaleString()}} zł
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>


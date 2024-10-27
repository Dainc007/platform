<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {useForm, usePage} from "@inertiajs/vue3";
import {onMounted, watch} from 'vue';
import Switcher from "@/Components/Switcher.vue";
import Amount from "@/Components/Inputs/Amount.vue";

const props = defineProps({
    installationTypes: Array,
    panels: Array,
    montageSystemTypes: Array,
    products: Array
});

const form = useForm({
    installationType: 0,
    inverter: 'ordinary',
    setType: 'standard',

    isPhotovoltaics: false,
    isEnergyStorage: false,
    isHeatStorage: false,

    panelType: 6,
    product:'',
    productsAmount:1,
    fireProtectionAmount:0,

    montage: 'Dach',
    montageSystemType: 'BLACHODACHÓWKA',
    fireProtection: 'Wyłącznik P.POŻ (PROJOY)',

    commission: 2000,
    constCommission: 10000,
    extraCommission: 0,
    finalCommission: 0,

    basicMontagePrice: 36594,
    minSellingPriceNetto: 0,
    vatPercentage:8,

    isMyEnergyGrant: false,
    freshAirGrant:0,
    thermoDiscount:0,
    thermoDiscountPercentage:12,


    companyCar: 0,
    tunnelFormat: 'Mb',
    extraCabelAmount: 0,
    tunnelAmount: 0,
    extraCabelFormat: 'Mb',
    energyStorage: 5,
    energyStorageFormat: 'Mb',
    energyStorageAmount: 0,
    heatStorage: '',
    heatStorageFormat: 'Mb',
    heatStorageAmount: 0,

    showDetails:false,
    homePlus:false,
    assistancePlus:false,
    holidayPlus:false,
    isPreFinancing:false,
    confirmOffer:false,
});

const displayForm = useForm({
    panel: 'Trina solar Vertex S+ Dual Glass N-Type Black Frame 1762 x 1134',

    netto: 0,
    vat: 0,
    brutto: 0,

    thermoGrant: 0,
    finalInvestment: 0,

    extraCommission: 0,
    finalCommission: 0,

    isHeatStorage: false,
    isEnergyStorage: false,
    isPhotovoltaics: false,
});

onMounted(() => {
    triggerCalculator();
});

function setCalculationType() {
    let installationType =     props.installationTypes[form.installationType];
    displayForm.isPhotovoltaics = installationType.photovoltaics;
    displayForm.isHeatStorage = installationType.heatStorage;
    displayForm.isEnergyStorage = installationType.energyStorage;
}

function setPanelType() {
    displayForm.panel = form.setType === 'standard' ? 'Trina solar Vertex S+ Dual Glass N-Type Black Frame 1762 x 1134' :
        'Sunlink N-type Bifacial Black Frame 1722x1134';
}

function calculateCommission() {
    displayForm.finalCommission = form.extraCommission + form.commission;
    displayForm.minSellingPriceNetto = form.basicMontagePrice + form.constCommission;
}

function calculateThermoGrant() {
    //na poczatku grant wynosi od 0 do 15k
    displayForm.thermoGrant = form.freshAirGrant;

    if (form.isMyEnergyGrant || displayForm.isHeatStorage) {
        displayForm.thermoGrant += displayForm.isPhotovoltaics ? 23000 : 16000;
    }

    displayForm.thermoDiscount = (displayForm.brutto - displayForm.thermoGrant) * form.thermoDiscountPercentage / 100;
    displayForm.thermoGrant += displayForm.thermoDiscount;

}

function calculatePrice() {
    displayForm.netto = form.basicMontagePrice +
        (form.homePlus ? 1000 : 0) +
        (form.assistancePlus ? 500 : 0) +
        (form.holidayPlus ? 800 : 0) +
        (form.isPreFinancing ? 2500 : 0)
    ;

    displayForm.vat = displayForm.netto * form.vatPercentage / 100;
    displayForm.brutto = displayForm.netto + displayForm.vat;
}

function triggerCalculator() {
    setCalculationType();
    setPanelType();
    calculateCommission();
    calculatePrice();
    calculateThermoGrant();

    displayForm.finalInvestment = displayForm.brutto - displayForm.thermoGrant;

}

watch(form, (form) => {
        // router.get('/calculators', { form: form }, { preserveState: true, replace: true, preserveScroll: true });
    triggerCalculator();

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
                <div class="w-full md:w-2/3 p-6 dark:bg-gray-800 shadow-sm sm:rounded-lg h-full">
                    <div class="mt-3">
                            <div class="mb-5">
                                <label for="installationType" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Rodzaj instalacji</label>
                                <select v-model="form.installationType" id="installationType" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="(installationType) in installationTypes"  :value="installationType.id" :key="installationType.id">{{installationType.title}}</option>
                                </select>
                            </div>

                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div>
                                <fieldset class="grid gap-6 lg:grid-cols-3">
                                    <legend class="sr-only">Rodzaj Zestawu</legend>
                                    <label class="block text-sm font-medium text-gray-900 dark:text-gray-300 mb-2">Rodzaj Zestawu</label>
                                    <div class="flex flex-col space-y-4">
                                        <div class="flex items-center">
                                            <input v-model="form.setType" id="standard" type="radio" name="countries" value="standard" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600" checked>
                                            <label for="standard" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Standard</label>
                                        </div>
                                        <div class="flex items-center">
                                            <input v-model="form.setType" id="premium" type="radio" name="countries" value="premium" class="w-4 h-4 border-gray-300 focus:ring-2 focus:ring-blue-300 dark:focus:ring-blue-600 dark:focus:bg-blue-600 dark:bg-gray-700 dark:border-gray-600">
                                            <label for="premium" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">Premium</label>
                                        </div>
                                    </div>
                                </fieldset>
                            </div>
                            <div>
                                <input v-model="displayForm.panel" disabled
                                       type="text" id="panel" class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"/>
                            </div>
                            <div>
                                <select id="panelType"
                                        v-model="form.panelType"
                                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="panel in panels" :value="panel.amount">{{panel.text}}</option>
                                </select>
                            </div>
                        </div>

                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <select v-model="form.inverter" id="inverter" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="hybrid">Falownik hybrydowy</option>
                                <option value="ordinary">Falownik zwykły</option>
                            </select>

                            <div>
                                <select id="product" v-model="form.product"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option v-for="product in products" :key="product.id" :value="product.netto">
                                        {{ product.title }}
                                    </option>
                                </select>
                            </div>
                            <Amount v-model="form.productsAmount" id="1" :defaultValue="1"/>
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



                        <div class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div>
                                <input disabled value="Wyłącznik PPOŻ" type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John" required />

                            </div>
                            <div>
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

                            <div>
                                <Amount v-model="form.fireProtectionAmount" id="2" :defaultValue="0"/>
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
                                <Amount v-model="form.extraCabelAmount" id="3" :defaultValue="0"/>
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
                                <Amount v-model="form.tunnelAmount" id="4" :defaultValue="0"/>
                            </div>
                        </div>

                        <div v-if="form.isEnergyStorage" class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div>
                                <select id="energy" v-model="form.energyStorage"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option :value="5">
                                        Magazyn Energii 5kW
                                    </option>
                                    <option :value="10">
                                        Magazyn Energii 10kW
                                    </option>
                                    <option :value="15">
                                        Magazyn Energii 15kW
                                    </option>
                                    <option :value="20">
                                        Magazyn Energii 20kW
                                    </option>
                                    <option :value="25">
                                        Magazyn Energii 25kW
                                    </option>
                                    <option :value="30">
                                        Magazyn Energii 30kW
                                    </option>
                                </select>
                            </div>

                            <div>
                                <select v-model="form.energyStorageFormat"
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
                                <Amount id="5" :defaultValue="0" v-model="form.energyStorageAmount"/>
                            </div>
                        </div>


                        <div v-if="form.isHeatStorage" class="grid gap-6 mb-6 lg:grid-cols-3">
                            <div>
                                <select id="energy" v-model="form.heatStorage"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option>Magazyn Ciepła</option>
                                    <option>Nie dotyczy</option>
                                </select>
                            </div>

                            <div>
                                <select id="fireProtection" v-model="form.heatStorageFormat"
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
                                <Amount id="6" :defaultValue="1" v-model="form.heatStorageAmount"/>
                            </div>
                        </div>



                    </div>
                </div>
                <!-- Kolumna Y -->
                <div class="w-full md:w-1/3 p-6 dark:bg-gray-800 shadow-sm sm:rounded-lg">
                    <div class="mt-3">
                        <label for="vatPercentage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">VAT</label>
                        <select v-model="form.vatPercentage" id="vatPercentage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option :value="8">8%</option>
                            <option :value="23">23%</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <label for="thermoDiscountPercentage" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ulga termomodernizacyjna</label>
                        <select v-model="form.thermoDiscountPercentage" id="thermoDiscountPercentage" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option :value="12">12%</option>
                            <option :value="19">19%</option>
                            <option :value="32">32%</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <Switcher
                            v-model="form.isMyEnergyGrant"
                            :label="'Dotacja Mój prąd 6.0'"
                            :checked="form.isMyEnergyGrant"
                        />
                    </div>

                    <div class="mt-3">
                        <label for="freshAirGrant" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Dotacja Czyste Powietrze</label>
                        <select v-model="form.freshAirGrant" id="freshAirGrant" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option :value="0">0zł</option>
                            <option :value="6000">1 Próg PV 6000zł</option>
                            <option :value="9000">2 Próg PV 9000zł</option>
                            <option :value="15000">3 Próg PV 15000zł</option>
                        </select>
                    </div>

                    <div class="mt-3">
                        <Switcher
                            id="details"
                            :label="'Rozwiń/zwiń szczegóły+'"
                            v-model="form.showDetails"
                            :checked="form.showDetails"
                        />
                    </div>

                    <div v-if="form.showDetails">
                        <div class="mt-3">
                            <Switcher
                                :label="'Dom+'"
                                v-model="form.homePlus"
                                :checked="form.homePlus"
                            />
                        </div>
                        <div class="mt-3">
                            <Switcher
                                :label="'Assistance+'"
                                v-model="form.assistancePlus"
                                :checked="form.assistancePlus"
                            />
                        </div>
                        <div class="mt-3">
                            <Switcher
                                :label="'Holiday+'"
                                v-model="form.holidayPlus"
                                :checked="form.holidayPlus"
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
                                            {{Number(displayForm.finalCommission).toLocaleString()}} zł
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
                                            {{ Number(displayForm.minSellingPriceNetto).toLocaleString()}} zł
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
                            v-model="form.isPreFinancing"
                            :checked="form.isPreFinancing"
                        />
                    </div>

                    <div v-if="form.isPreFinancing" class="mt-3">
                        <p class="text-white">
                            Wniosek na prefi: 1300,00 zł
                        </p>
                        <p class="text-white">
                            Audyt: 1200,00 zł
                        </p>
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
                                        {{ Number(displayForm.netto).toLocaleString() }} zł
                                    </td>
                                </tr>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        VAT
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ Number(displayForm.vat).toLocaleString() }} zł
                                    </td>
                                </tr>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Suma brutto
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ Number(displayForm.brutto).toLocaleString()}} zł
                                    </td>
                                </tr>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Ulga termomodernizacyjna
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ Number(displayForm.thermoGrant).toLocaleString() }} zł
                                    </td>
                                </tr>
                                <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        Finalna wartość inwestycji
                                    </th>
                                    <td class="px-6 py-4">
                                        {{Number(displayForm.finalInvestment).toLocaleString()}} zł
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="mt-3">
                        <Switcher v-model="form.confirmOffer"
                                  :checked="form.confirmOffer"
                                  label="Potwierdam, że skończyłem oferte"/>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                            Zapisz ofertę
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import { ref, watch } from 'vue';
import { router } from '@inertiajs/vue3';

const props = defineProps({
    route: {
        type: String,
        required: true
    },
    statuses: {
        type: Array,
        default: () => []
    },
    showStatus: {
        type: Boolean,
        default: true
    }
});

const selectedYear = ref(null);
const selectedMonth = ref(null);
const selectedStatus = ref(null);

const years = [
    new Date().getFullYear() - 1,
    new Date().getFullYear(),
    new Date().getFullYear() + 1
];

const months = [
    { value: 1, label: 'Styczeń' },
    { value: 2, label: 'Luty' },
    { value: 3, label: 'Marzec' },
    { value: 4, label: 'Kwiecień' },
    { value: 5, label: 'Maj' },
    { value: 6, label: 'Czerwiec' },
    { value: 7, label: 'Lipiec' },
    { value: 8, label: 'Sierpień' },
    { value: 9, label: 'Wrzesień' },
    { value: 10, label: 'Październik' },
    { value: 11, label: 'Listopad' },
    { value: 12, label: 'Grudzień' }
];

watch([selectedYear, selectedMonth, selectedStatus], ([year, month, status]) => {
    router.get(route(props.route), {
        year: year,
        month: month,
        status: status
    }, {
        preserveState: true,
        preserveScroll: true,
        replace: true
    });
});

const resetFilters = () => {
    selectedYear.value = null;
    selectedMonth.value = null;
    selectedStatus.value = null;
};
</script>

<template>
    <div class="flex flex-col sm:flex-row justify-end mb-4">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4 flex flex-col sm:flex-row items-start sm:items-center gap-4">
            <!-- Year Select -->
            <div class="w-full sm:w-32">
                <label for="year" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Rok
                </label>
                <select
                    id="year"
                    v-model="selectedYear"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option :value="null">Wszystkie</option>
                    <option v-for="year in years" :key="year" :value="year">{{ year }}</option>
                </select>
            </div>
            
            <!-- Month Select -->
            <div class="w-full sm:w-32">
                <label for="month" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Miesiąc
                </label>
                <select
                    id="month"
                    v-model="selectedMonth"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option :value="null">Wszystkie</option>
                    <option v-for="month in months" :key="month.value" :value="month.value">
                        {{ month.label }}
                    </option>
                </select>
            </div>

            <!-- Status Select -->
            <div v-if="showStatus" class="w-full sm:w-32">
                <label for="status" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Status
                </label>
                <select
                    id="status"
                    v-model="selectedStatus"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                >
                    <option :value="null">Wszystkie</option>
                    <option v-for="status in statuses" :key="status" :value="status">
                        {{ $t('vacation.status.' + status) }}
                    </option>
                </select>
            </div>

            <!-- Reset Button -->
            <div class="w-full sm:w-auto flex items-end">
                <button
                    @click="resetFilters"
                    class="w-full sm:w-auto text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-xs px-3 py-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"
                >
                    Resetuj
                </button>
            </div>
        </div>
    </div>
</template> 
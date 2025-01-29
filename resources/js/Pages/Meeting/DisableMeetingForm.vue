<script setup>

import moment from "moment";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import {Head, useForm, usePage} from "@inertiajs/vue3";
import '@vuepic/vue-datepicker/dist/main.css'
import { router } from '@inertiajs/vue3'
import InputError from "@/Components/InputError.vue";

const disableDateForm = useForm({
    date: null
});
const updateDate = (modelData) => {
    disableDateForm.date = modelData;
    router.reload({
        data: {
            date: modelData,
        }
    });

    form.disabled_hours = [];
};

const shouldBeChecked = (selectedDate, key) => {
    if (!selectedDate) {
        return true;
    }

    if (selectedDate.is_enabled == false) {
        return false;
    }

    if (checkDisabledHours(key)) {
        return false;
    }

    return true;
}

const checkDisabledHours = (key) => {
    const disabledHours = usePage().props.disabledHours;

    if (Array.isArray(disabledHours)) {
        return disabledHours.includes(key);
    } else if (typeof disabledHours === 'object' && disabledHours !== null) {
        return Object.values(disabledHours).includes(key);
    }
}

const updateHours = (key, isChecked) => {
    form.date = disableDateForm.date;
    form.isChecked = isChecked;
    form.hour = key;
    if (isChecked) {
        form.disabled_hours = form.disabled_hours.filter(hour => hour !== key);
    } else {
        form.disabled_hours.push(key);
    }

    form.post(route('meetingDates.store'), {
        preserveScroll: true,
    });
}

const form = useForm({
    date: disableDateForm.date,
    is_enabled: Boolean,
    isChecked: null,
    hour: null,
    disabled_hours: []
})

const submit = (date, isEnabled) => {
    form.date = date;
    form.is_enabled = isEnabled
    form.post(route('meetingDates.store'), {
        onSuccess: () => form.reset(),
        preserveScroll: true,
    });
};
defineProps({
    meetings: [],
    selectedDate: Object,
    disabledHours: []
})
</script>

<template>
    <Head title="Dashboard"/>
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Ustawienia Spotkań</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <template v-if="$page.props.auth.isAdmin">
                    <h2 class="font-semibold text-3xl dark:text-white text-center">Blokowanie terminów spotkań</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-2 items-center">
                        <div class="flex justify-center  mx-auto">
                            <VueDatePicker
                                :disabled="form.processing"
                                v-model="disableDateForm.date"
                                :enableTimePicker="false"
                                :select-text="$t('dataPicker.pick')"
                                :cancel-text="$t('dataPicker.cancel')"
                                locale="pl"
                                :min-date="new Date()"
                                class="mt-3"
                                inline
                                @date-update="updateDate"
                                :disabled-dates="disablePastDates"
                            ></VueDatePicker>
                            <InputError class="mt-2" :message="disableDateForm.errors.date"/>
                        </div>
                        <div class="flex flex-col items-center">
                            <h4 class="mb-4 font-semibold text-gray-900 dark:text-white">
                                <label v-if="disableDateForm.date !== null"
                                       class="inline-flex items-center cursor-pointer">
                                    <input :disabled="form.processing" type="checkbox" class="sr-only peer "
                                           :checked="selectedDate === null || selectedDate && selectedDate.is_enabled == 1"
                                           @change="submit(disableDateForm.date, $event.target.checked)">
                                    <span
                                        class="relative w-14 h-7 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-green-300 dark:peer-focus:ring-green-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-0.5 after:start-[4px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all dark:border-gray-600 peer-checked:bg-green-600"></span>
                                    <span
                                        class="ms-3 text-lg font-bold text-gray-900 dark:text-gray-300">{{ moment(disableDateForm.date).format("D-M-Y") }}</span>
                                </label>
                            </h4>
                            <ul v-if="disableDateForm.date !== null"
                                class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-2 items-center w-full text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                <li v-for="(index, key) in meetings" :key="index"
                                    class="w-full border-b border-gray-200 sm:border-b-0 sm:border-r dark:border-gray-600">
                                    <div class="flex items-center ps-3">
                                        <input
                                            :disabled="form.processing"
                                            :id="key" type="checkbox" value=""
                                            :checked="shouldBeChecked(selectedDate, key)"
                                            @change="updateHours(key, $event.target.checked)"
                                        class="w-6 h-6 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                        <label :for="key"
                                               class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{
                                                key
                                            }}</label>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </template>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

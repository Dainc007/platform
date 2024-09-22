<script setup lang="ts">
import {useForm} from "@inertiajs/vue3";
import {computed} from "vue";
import { type Meeting } from "./Index.vue";
import { DatePicker } from "qalendar";
import {isPeriodStale, isSameDay, allPeriods} from "@/Pages/Meeting/utils";

const props = defineProps<{
    meetings: Meeting[]
}>();

const form = useForm({
    title: '',
    description: '',
    date: '',
    period: '',
});

const today = new Date();

const availablePeriods = computed(() => {
    const selectedDayDate = new Date(form.date);

    const meetingsFromSelectedDay = props.meetings.filter((meeting) => {
        return isSameDay(selectedDayDate, new Date(meeting.start_date));
    });

    const notStaledPeriods = allPeriods.filter((period) => {
        if (!isSameDay(today, selectedDayDate)) {
            return true;
        }

        return !isPeriodStale(period);
    });

    return notStaledPeriods.filter((period) => {
        const [hour, minute] = period.from.split(':', 2);

        return meetingsFromSelectedDay.every((meeting) => {
            const meetingDate = new Date(meeting.start_date);

            const meetingHour = String(meetingDate.getHours());
            const meetingMinute = String(meetingDate.getMinutes());

            return meetingHour !== hour && meetingMinute !== minute;
        });
    });
});

const submit = () => {
    form.post(route('meetings.store'), {
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <form @submit.prevent="submit" class="space-y-8">
        <div>
            <label
                for="title"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Tytuł
            </label>
            <input
                name="title"
                type="text"
                id="title"
                v-model="form.title"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
            />
            <div v-if="form.errors.title" class="text-red-500 mt-1">{{ form.errors.title }}</div>
        </div>

        <div>
            <label
                for="description"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Opis
            </label>
            <textarea
                name="description"
                id="description"
                v-model="form.description"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
            ></textarea>
            <div v-if="form.errors.description" class="text-red-500 mt-1">{{ form.errors.description }}</div>
        </div>

        <div>
            <label
                for="date"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Dzień
            </label>

            <div class="relative">
                <DatePicker
                    name="date"
                    id="date"
                    locale="pl-PL"
                    firstDayOfWeek="monday"
                    :disable-dates="{
                        before: new Date(today.getFullYear(), today.getMonth(), today.getDate()),
                        after: new Date(new Date().setDate(today.getDate() + 30))
                    }"
                    @updated="(value) => form.date = new Date(value.year, value.month, value.date).toDateString()"
                />
            </div>
            <div v-if="form.errors.date" class="text-red-500 mt-1">{{ form.errors.date }}</div>
        </div>

        <div>
            <label
                for="period"
                class="block text-sm font-medium text-gray-700 dark:text-gray-300"
            >
                Termin
            </label>
            <div class="relative">
                <select
                    id="period"
                    name="period"
                    v-model="form.period"
                    class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                >
                    <option v-for="period in availablePeriods" :key="period.from">
                        {{ period.from }} - {{period.to}}
                    </option>
                </select>
                <div v-if="form.errors.period" class="text-red-500 mt-1">{{ form.errors.period }}</div>
            </div>
        </div>

        <button
            type="submit"
            class="w-full py-2 px-4 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
        >
            Dodaj
        </button>
    </form>
</template>

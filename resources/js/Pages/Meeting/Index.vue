<template>
<AuthenticatedLayout>
    <h1 v-if="form.recentlySuccessful" class="dark:text-white text-center mt-3 pt-3 font-semibold text-3xl w-full">Spotkanie zostało zaplanowane <span class="text-green-500">poprawnie</span></h1>

    <template #header>
        <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <MultiStepForm :steps="steps" :activeStep="activeStep" />
        </div>
    </template>

    <div class="p-12 grid grid-cols-1 md:grid-cols-3 gap-6">
        <section class="space-y-6 md:col-span-2" v-if="$page.props.auth.isAdmin">
            <h2 class="font-semibold text-3xl dark:text-white text-center">Nadchodzące Spotkania</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-center">
                            zgłaszający
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            termin
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            przepracowane godziny
                        </th>
                        <th scope="col" class="px-6 py-3 text-center">
                            notatka
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="meeting in upcomingMeetings.data" v-if="upcomingMeetings.data.length" :key="meeting.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4 text-center">
                            {{ meeting.user.name }}
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="ps-3">
                                <div class="font-normal text-gray-500">
                                    {{ moment(meeting.start_date).format("D-M-Y") }}
                                </div>
                                <div class="text-base font-semibold">
                                    {{ moment(meeting.start_date).format("HH:mm") }}-{{ moment(meeting.end_date).format("HH:mm") }}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-center">
                            {{ meeting.hours_worked }}h
                        </td>
                        <td class="px-6 py-4 text-center">
                            <template v-if="meeting.notes">
                                <div class="max-h-24 overflow-y-auto">
<span v-for="note in meeting.notes" :key="note.id">
{{ note.content }}
</span>
                                </div>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="text-green-500 bg-red-500/20">
                </div>
                <nav class=" m-2 flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                        <Link
                            v-for="(link, index) in upcomingMeetings.links"
                            :key="index"
                            :href="link.url"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            v-html="$t(link.label)"
                        />
                    </ul>
                </nav>
            </div>
        </section>

        <section class="space-y-6 md:col-span-1">
            <h2 class="font-semibold text-center text-3xl dark:text-white">Zaplanuj spotkanie</h2>
            <div class="hidden">
                <div class="days">
                    <div class="days-of-week grid grid-cols-7 mb-1 dow block flex-1 leading-9 border-0 rounded-lg cursor-default text-center text-gray-900 font-semibold text-sm"></div>
                    <div class="datepicker-grid w-64 grid grid-cols-7 block flex-1 leading-9 border-0 rounded-lg cursor-default text-center text-gray-900 font-semibold text-sm h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"></div>
                </div>
                <div class="calendar-weeks">
                    <div class="days-of-week flex"><span class="dow h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"></span></div>
                    <div class="weeks week block flex-1 leading-9 border-0 rounded-lg cursor-default text-center text-gray-900 font-semibold text-sm"></div>
                </div>
            </div>
            <VueDatePicker v-show="showCalendar"
                :enableTimePicker="false"
                v-model="form.date"
                clearable="true"
                :select-text="$t('dataPicker.pick')"
                :cancel-text="$t('dataPicker.cancel')"
                locale="pl"
                class="w-full"
                inline @date-update="handleDate"
            ></VueDatePicker>
            <InputError class="mt-2" :message="form.errors.date" />

            <label v-show="showTimeField" for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Godzina Spotkania
            </label>
            <select v-show="showTimeField" @change="handleTime"
                v-model="form.hours"
                id="time"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
            >
                <option v-for="(value, key) in meetings" :key="key" :value="{ start_date: key, end_date: value }">
                    {{ key }}
                </option>
            </select>

            <InputLabel v-show="showExtraFields" for="hoursWorked" value="Przepracowane Godziny" />
            <TextInput v-show="showExtraFields"
                name="hoursWorked"
                id="hoursWorked"
                type="text"
                class="mt-1 block w-full"
                v-model="form.hoursWorked"
                required
                autofocus
                autocomplete="hoursWorked"
            />
            <InputError class="mt-2" v-if="form.errors.hoursWorked" :message="$t('form.errors.hoursWorked')" />


            <div v-show="showExtraFields">
                           <TextArea
                               v-model="form.note"
                               name="note"
                               id="note"
                           />
            </div>
            <InputError class="mt-2" :message="form.errors.note" />
            <SecondaryButton v-show="showExtraFields"
                             @click="goToConfirmation"
                             :disabled="form.hoursWorked == null || form.hoursWorked <= 0 "
            >Przejdź do Podsumowania
            </SecondaryButton>
            <div v-show="showConfirmButton">

                <p>Pracownik: {{$page.props.auth.user.name}}</p>
                <p>Start Spotkania: {{moment(form.date).format("D-M-Y HH:MM")}}</p>

                <p>Przepracowane godziny {{form.hoursWorked}}</p>
                <p v-show="form.note">Notatka {{form.note}}</p>

                <SecondaryButton
                    :disabled="form.processing"
                    @click="submit(date)"
                    type="submit"
                >Potwierdź</SecondaryButton>
            </div>


        </section>
    </div>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import '@vuepic/vue-datepicker/dist/main.css'
import VueDatePicker from "@vuepic/vue-datepicker";
import {Link, router, useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";

import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import TextArea from "@/Components/TextArea.vue";
import MultiStepForm from "@/Components/Form/MultiStepForm.vue";
import moment from "moment/moment";


const date = ref('');
let showTimeField, showConfirmButton, showExtraFields = ref(false);
let showCalendar = ref(true);

const form = useForm({
   hoursWorked: null,
    date: date,
    note: null,
    hours: null
});

defineProps({
  meetings: [],
    upcomingMeetings: Object
})

const submit = (date) => {
    form.date = date;
    form.post(route('meetings.store'), {
        onSuccess: () => form.reset(),
    });
};

watch(date, (date) => {
  router.get('/meetings', { date: date }, { preserveState: true, replace: true });
});

const handleDate = (modelData) => {
    form.date = modelData;
    showTimeField = true;
    showCalendar = false;
}

const handleTime = () => {
    showTimeField = false;
    showExtraFields = true;
    activeStep.value = 3;
}

const goToConfirmation = () => {
    showExtraFields = false;
    showConfirmButton = true;
    activeStep.value = 4;
}

const activeStep = ref(2);
const steps = [
    { title: 'Operacja', description: '' },
    { title: 'Data i czas', description: '' },
    { title: 'Dane', description: '' },
    { title: 'Potwierdzenie', description: '' }
];

</script>

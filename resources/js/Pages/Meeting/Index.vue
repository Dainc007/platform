<template>
<AuthenticatedLayout>
    <div class="p-12 grid grid-cols-1 md:grid-cols-2 gap-6">
        <section class="space-y-6">
            <h2 class="font-semibold text-center text-3xl text-white">Zaplanuj spotkanie</h2>
            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                Dzień
            </label>
            <VueDatePicker
                no-today
                :placeholder="'Kliknij tutaj aby wybrać datę'"
                dark="true"
                :enableTimePicker="false"
                v-model="date"
                clearable="true"
                :select-text="$t('dataPicker.pick')"
                :cancel-text="$t('dataPicker.cancel')"
                :clear-text="123"
                locale="pl"
                class="w-full"
            ></VueDatePicker>
            <InputError class="mt-2" :message="form.errors.date" />

            <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                 Godzina Spotkania
            </label>
            <select
                v-model="form.hours"
                id="time"
                class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
            >
                <option v-for="(value, key) in meetings" :key="key" :value="{ start_date: key, end_date: value }">
                    {{ key }} => {{ value }}
                </option>
            </select>

            <InputLabel for="hoursWorked" value="Przepracowane Godziny" />
            <TextInput
                name="hoursWorked"
                id="hoursWorked"
                type="text"
                class="mt-1 block w-full"
                v-model="form.hoursWorked"
                required
                autofocus
                autocomplete="hoursWorked"
            />
            <InputError class="mt-2" :message="form.errors.hoursWorked" />

            <TextArea
                v-model="form.note"
                name="note"
                id="note"
            ></TextArea>
            <InputError class="mt-2" :message="form.errors.note" />
            <SecondaryButton
                :disabled="form.processing"
                @click="submit(date)"
                type="submit"
            >Dodaj</SecondaryButton>
        </section>

        <section class="space-y-6" v-if="$page.props.auth.isAdmin">
            <h2 class="font-semibold text-3xl text-white text-center">Nadchodzące Spotkania</h2>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            zgłaszający
                        </th>
                        <th scope="col" class="px-6 py-3">
                            termin
                        </th>
                        <th scope="col" class="px-6 py-3">
                                przepracowane godziny
                        </th>
                        <th scope="col" class="px-6 py-3">
                                notatka
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="meeting in upcomingMeetings.data" v-if="upcomingMeetings.data.length" :key="meeting.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="px-6 py-4">
                            {{meeting.user.name}}
                        </td>
                        <td class="px-6 py-4">
                            <div class="ps-3">
                                <div class="font-normal text-gray-500">
                                    {{moment(meeting.start_date).format("D-M-Y")}}
                                </div>
                                <div class="text-base font-semibold">
                                    {{moment(meeting.start_date).format("h:mm")}} - {{moment(meeting.end_date).format("h:mm")}}
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            {{meeting.hours_worked}}h
                        </td>
                        <td class="px-6 py-4">
                            <template v-if="meeting.notes">
                                <span v-for="note in meeting.notes" :key="note.id">{{ note.content }}</span>
                            </template>
                        </td>
                    </tr>
                    </tbody>
                </table>
                <nav class="flex items-center flex-column flex-wrap md:flex-row justify-between pt-4"
                     aria-label="Table navigation">
                    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                        <Link
                            v-for=" (link, index) in upcomingMeetings.links"
                            :key="index"
                            :href="link.url"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            v-html="link.label"
                        />
                    </ul>
                </nav>
            </div>
        </section>
    </div>
</AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import VueDatePicker from "@vuepic/vue-datepicker";
import {Link, router, useForm} from "@inertiajs/vue3";
import {ref, watch} from "vue";
import TextInput from "@/Components/TextInput.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextArea from "@/Components/TextArea.vue";
import moment from "moment/moment.js";

const date = ref('');

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
    form.post(route('meetings.store'), {});
};

watch(date, (date) => {
  router.get('/meetings', { date: date }, { preserveState: true, replace: true });
});
</script>

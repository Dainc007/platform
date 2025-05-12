<template>
    <AuthenticatedLayout>
        <h1 v-if="form.recentlySuccessful" class="dark:text-white text-center mt-3 pt-3 font-semibold text-3xl w-full">
            Spotkanie zostało zaplanowane <span class="text-green-500">poprawnie</span></h1>

        <template #header>
            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <ol v-if="!$page.props.auth.isAdmin"
                    class=" mt-3 items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
                    <li :class="['flex items-center dark:text-blue-500 space-x-2.5 rtl:space-x-reverse', { 'text-blue-600': activeStep === 1 }]">
                  <span
                      class="flex items-center justify-center w-8 h-8 border border-blue-600 rounded-full shrink-0 dark:border-blue-500">
            1
        </span>
                        <span>
            <h3 class="font-medium leading-tight">Operacja</h3>
        </span>
                    </li>
                    <li :class="['flex items-center dark:text-blue-500 space-x-2.5 rtl:space-x-reverse', { 'text-blue-600': activeStep === 2 }]">
        <span
            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            2
        </span>
                        <span>
            <h3 class="font-medium leading-tight">Data (spotkania i wniosek o dni wolne)</h3>
        </span>
                    </li>
                    <li :class="['flex items-center dark:text-blue-500 space-x-2.5 rtl:space-x-reverse', { 'text-blue-600': activeStep === 3 }]">
        <span
            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            3
        </span>
                        <span>
            <h3 class="font-medium leading-tight">Dane</h3>
        </span>
                    </li>
                    <li :class="['flex items-center dark:text-blue-500 space-x-2.5 rtl:space-x-reverse', { 'text-blue-600': activeStep === 4 }]">
        <span
            class="flex items-center justify-center w-8 h-8 border border-gray-500 rounded-full shrink-0 dark:border-gray-400">
            4
        </span>
                        <span>
            <h3 class="font-medium leading-tight">Potwierdzenie</h3>
        </span>
                    </li>
                </ol>
            </div>
        </template>

        <div v-show="activeStep === 1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto">
                    <Link :href="route('meetings.index')"
                          class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 text-center">
                        Spotkania
                    </Link>
                    <Link :href="route('vacations.index')"
                          class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                        Wniosek o dni wolne
                    </Link>
                </div>
            </div>
        </div>

        <div class="p-12 pt-0 grid grid-cols-1 ">
            <section class="space-y-6 md:col-span-2" v-if="$page.props.auth.isAdmin">
                <h2 class="font-semibold text-3xl dark:text-white text-center">Nadchodzące Spotkania</h2>

                <div class="flex justify-between items-center mb-4">
                    <div class="w-24">
                        <button v-if="selectedRows.length > 0"
                                @click="printSelectedRows"
                                class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                            Drukuj
                        </button>
                    </div>
                    <TableFilters
                        :modelName="'meeting'"
                        :route="'meetings.index'"
                        :statuses="['done', 'cancelled', 'pending']"
                        :show-status="true"
                    />
                </div>

                <div class="relative shadow-md sm:rounded-lg overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="p-4">
                                <div class="flex items-center">
                                    <input
                                        @change="toggleSelectAll"
                                        id="checkbox-all"
                                        type="checkbox"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-all-search" class="sr-only">checkbox</label>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                zgłaszający
                            </th>
                            <th scope="col"
                             class="px-6 py-3 cursor-pointer hover:bg-gray-50 dark:hover:bg-gray-700" @click="toggleSort">
                                <div class="flex items-center">
                                        Termin
                                    <svg v-if="sortDirection === 'asc'" class="w-3 h-3 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                    </svg>
                                    <svg v-else class="w-3 h-3 ml-1.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M8.574 11.024h6.852a2.075 2.075 0 0 0 1.847-1.086 1.9 1.9 0 0 0-.11-1.986L13.736 2.9a2.122 2.122 0 0 0-3.472 0L6.837 7.952a1.9 1.9 0 0 0-.11 1.986 2.074 2.074 0 0 0 1.847 1.086Zm6.852 1.952H8.574a2.072 2.072 0 0 0-1.847 1.087 1.9 1.9 0 0 0 .11 1.985l3.426 5.05a2.123 2.123 0 0 0 3.472 0l3.427-5.05a1.9 1.9 0 0 0 .11-1.985 2.074 2.074 0 0 0-1.846-1.087Z"/>
                                    </svg>
                                </div>
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                przepracowane godziny
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                notatka
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Status
                            </th>
                            <th scope="col" class="px-6 py-3 text-center">
                                Akcje
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr
                            v-for="meeting in upcomingMeetings.data"
                            v-if="upcomingMeetings.data.length"
                            :key="meeting.id"
                            :class="{
                'bg-green-100': meeting.status === 'done',
                'bg-orange-100': meeting.status === 'cancelled',
                'bg-white': meeting.status !== 'done' && meeting.status !== 'cancelled',
                'border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-blue-200 dark:hover:bg-gray-600': true
                }"
                        >
                            <td class="w-4 p-4">
                                <div class="flex items-center">
                                    <input :id="`checkbox-${meeting.id}`" type="checkbox"
                                           :value="meeting.id"
                                           @change="updateSelectRow(meeting.id)"
                                           :checked="selectedRows.includes(meeting.id)"
                                           class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                                    <label for="checkbox-table-search-1" class="sr-only">checkbox</label>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ meeting.user.name }}
                            </td>
                            <td class="px-6 py-4 text-center">
                                <div class="ps-3 text-center">
                                    <div class="font-normal text-gray-500">
                                        {{ moment(meeting.start_date).format("D-M-Y") }}
                                    </div>
                                    <div class="text-base font-semibold">
                                        {{
                                            moment(meeting.start_date).format("HH:mm")
                                        }}-{{ moment(meeting.end_date).format("HH:mm") }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-center">
                                {{ meeting.hours_worked }}h
                            </td>
                            <td class="px-6 py-4 text-center">
                                <template v-if="meeting.notes">
                                    <div class="max-h-24 overflow-y-auto text-center">
                <span v-for="note in meeting.notes" :key="note.id">
                    {{ note.content }}
                </span>
                                        <span v-if="meeting.description"><small>Notatka Admina:</small><br> {{meeting.description}}</span>
                                    </div>
                                </template>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <svg v-show="meeting.status !== 'done'" @click="handleUpdateMeeting(meeting, 'done')"
                                     class="w-8 h-8 md:w-6 md:h-6 sm:w-4 sm:h-4 text-green-500 mx-auto" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                          d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z"
                                          clip-rule="evenodd"/>
                                </svg>

                                <svg v-show="meeting.status !== 'cancelled'"
                                     @click="handleUpdateMeeting(meeting, 'cancelled')"
                                     class="w-6 h-6 text-red-600 dark:text-white mx-auto"
                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <button @click="destroy(meeting.id)" title="Usuń"
                                        class="p-2 text-white bg-red-600 dark:bg-red-700 hover:bg-red-500 dark:hover:bg-red-600 border border-red-200 dark:border-red-600 focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-700 font-medium rounded-lg text-xs inline-flex items-center">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                                <button v-if="hasAccessToAdminNotes"
                                        @click="openDescriptionModal(meeting)"
                                        :title="meeting.description"
                                        :class="[
            'p-2 text-white',
            meeting.description ? 'bg-blue-600 dark:bg-blue-800 hover:bg-blue-500 dark:hover:bg-blue-600' : 'bg-blue-300 dark:bg-blue-700 hover:bg-blue-400 dark:hover:bg-blue-500',
            'border border-blue-200 dark:border-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-100 dark:focus:ring-blue-700 font-medium rounded-lg text-xs inline-flex items-center ml-2'
        ]">
                                    <i class="fa-solid fa-note-sticky"></i>
                                </button>

                            </td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="text-green-500 bg-red-500/20">
                    </div>
                    <div class="flex justify-between items-center m-2">
                        <div class="w-24">
                            <button v-if="selectedRows.length > 0"
                                    @click="printSelectedRows"
                                    class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                Drukuj
                            </button>
                        </div>
                        <nav class="flex items-center flex-column flex-wrap md:flex-row justify-end pt-4"
                             aria-label="Table navigation">
                            <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                                <Link
                                    v-for="(link, index) in upcomingMeetings.links"
                                    :key="index"
                                    :href="link.url"
                                    preserve-state
                                    preserve-scroll
                                    class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                    v-html="$t(link.label)"
                                />
                            </ul>
                        </nav>
                    </div>
                </div>
            </section>

            <section class="mx-auto" v-if="!$page.props.auth.isAdmin">
                <Link v-show="activeStep === 2 && subStep === 1" :href="route('dashboard')">
                    <i class="fas fa-arrow-left text-blue-500 text-xl"> Cofnij</i>
                </Link>
                <i v-show="activeStep === 2 && subStep === 2" class="fas fa-arrow-left text-blue-500 text-xl" @click="subStep -= 1;"> Cofnij</i>
                <i v-show="activeStep === 3 && subStep === 1" class="fas fa-arrow-left text-blue-500 text-xl" @click="subStep = 2; activeStep = 2;"> Cofnij</i>
                <i v-show="activeStep === 4" class="fas fa-arrow-left text-blue-500 text-xl" @click="prevStep"> Cofnij</i>
                <div class="hidden">
                    <div class="days">
                        <div
                            class="days-of-week grid grid-cols-7 mb-1 dow block flex-1 leading-9 border-0 rounded-lg cursor-default text-center text-gray-900 font-semibold text-sm"></div>
                        <div
                            class="datepicker-grid w-64 grid grid-cols-7 block flex-1 leading-9 border-0 rounded-lg cursor-default text-center text-gray-900 font-semibold text-sm h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"></div>
                    </div>
                    <div class="calendar-weeks">
                        <div class="days-of-week flex"><span
                            class="dow h-6 leading-6 text-sm font-medium text-gray-500 dark:text-gray-400"></span></div>
                        <div
                            class="weeks week block flex-1 leading-9 border-0 rounded-lg cursor-default text-center text-gray-900 font-semibold text-sm"></div>
                    </div>
                </div>

                <VueDatePicker v-if="!$page.props.auth.isAdmin" v-show="activeStep === 2 && subStep === 1"
                               :max-date="addDays(new Date(), 30)"
                               :enableTimePicker="false"
                               v-model="form.date"
                               clearable="true"
                               :select-text="$t('dataPicker.pick')"
                               :cancel-text="$t('dataPicker.cancel')"
                               locale="pl"
                               :min-date="new Date()"
                               class="w-full mt-3"
                               inline @date-update="handleDate"
                               :disabled-dates="disabledDates"
                ></VueDatePicker>
                <InputError class="mt-2" :message="form.errors.date"/>
            </section>

            <div v-show="activeStep === 1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto">
                        <Link :href="route('meetings.index')"
                              class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 text-center">
                            Spotkania
                        </Link>
                        <Link :href="route('vacations.index')"
                              class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                            Wniosek o dni wolne
                        </Link>
                    </div>
                </div>
            </div>

            <div v-show="activeStep === 1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto">
                        <Link :href="route('meetings.index')"
                              class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 text-center">
                            Spotkania
                        </Link>
                        <Link :href="route('vacations.index')"
                              class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                            Wniosek o dni wolne
                        </Link>
                    </div>
                </div>
            </div>

            <div v-show="activeStep === 1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto">
                        <Link :href="route('meetings.index')"
                              class="block bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 text-center">
                            Spotkania
                        </Link>
                        <Link :href="route('vacations.index')"
                              class="block bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded text-center">
                            Wniosek o dni wolne
                        </Link>
                    </div>
                </div>
            </div>

            <div v-show="activeStep === 2 && subStep === 2">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto">
                        <InputLabel class="mt-3" for="time" value="Godzina Spotkania"/>
                        <select
                            @change="handleTime"
                            v-model="form.hours"
                            id="time"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                        >
                            <option v-for="(value, key) in meetings" :key="key"
                                    :value="{ start_date: key, end_date: value }">
                                {{ key }}
                            </option>
                        </select>
                    </div>
                </div>
            </div>

            <div v-show="activeStep === 3 && subStep === 1">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto">
                        <InputLabel class="mt-3" for="hoursWorked" value="Przepracowane Godziny"/>
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
                        <InputError class="mt-2" v-if="form.errors.hoursWorked"
                                    :message="$t('form.errors.hoursWorked')"/>

                        <TextArea
                            v-model="form.note"
                            name="note"
                            id="note"
                        />
                        <InputError class="mt-2" :message="form.errors.note"/>
                        <SecondaryButton
                            class="my-2"
                            @click="nextStep"
                            :disabled="form.hoursWorked == null || form.hoursWorked <= 0 "
                        >Przejdź do Podsumowania
                        </SecondaryButton>

                    </div>
                </div>
            </div>

            <div v-show="activeStep === 4">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto p-3">
                        <p class="text-gray-700 font-semibold">Pracownik: {{ $page.props.auth.user.name }}</p>
                        <p class="text-gray-600">Start Spotkania: {{ moment(form.date).format("D-M-Y") }}</p>
                        <p class="text-gray-600" v-if="form.hours">Godzina: {{ form.hours.start_date }}</p>
                        <p class="text-gray-600">Przepracowane godziny: {{ form.hoursWorked }}</p>
                        <p v-show="form.note" class="text-gray-600">Notatka: {{ form.note }}</p>

                        <SecondaryButton
                            :disabled="form.processing"
                            @click="submit(form.date)"
                            type="submit"
                            class="mt-4 bg-blue-500 py-2 px-4 rounded hover:bg-blue-400 hover:text-white disabled:opacity-50"
                        >
                            Potwierdź
                        </SecondaryButton>
                    </div>
                </div>
            </div>

        </div>
    </AuthenticatedLayout>

    <Modal :show="showDescriptionModal" @close="closeDescriptionModal">
        <div class="p-6">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Dodaj notatkę do spotkania
            </h2>

            <div class="mt-6">
                <InputLabel for="description" value="Treść" />
                <TextArea
                    id="description"
                    class="mt-1 block w-full"
                    v-model="descriptionForm.description"
                    required
                />
                <InputError class="mt-2" :message="descriptionForm.errors.description" />
            </div>

            <div class="mt-6 flex justify-end">
                <SecondaryButton @click="closeDescriptionModal" class="mr-3">
                    Anuluj
                </SecondaryButton>
                <PrimaryButton @click="submitDescription" :disabled="descriptionForm.processing">
                    Zapisz
                </PrimaryButton>
            </div>
        </div>
    </Modal>
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
import moment from "moment/moment";
import {addDays} from "date-fns";
import {Inertia} from "@inertiajs/inertia";
import TableFilters from '@/Components/TableFilters.vue';
import Modal from '@/Components/Modal.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';


const date = ref(new Date());
const activeStep = ref(2);
const subStep = ref(1);
const sortDirection = ref('asc');

function handleUpdateMeeting(meeting, status) {
    if (updateMeeting.processing) {
        return;
    }
    updateMeeting.status = status;
    updateMeeting.put(route('meetings.update', meeting), {preserveScroll: true});
}

function prevStep() {
    activeStep.value -= 1;
}

function nextStep() {
    activeStep.value += 1;
    subStep.value = 1;
}

const handleDate = (modelData) => {
    form.date = modelData;
    subStep.value += 1;

    router.reload({
        only: ['meetings'],
        data: { date: form.date }
    });
}


const handleTime = (modelData) => {
    nextStep();
}

const form = useForm({
    hoursWorked: null,
    date: date,
    note: null,
    hours: null
});

const updateMeeting = useForm({
    status: ''
});

const props = defineProps({
    meetings: [],
    upcomingMeetings: Object,
    disabledDates: [],
    hasAccessToAdminNotes: Boolean
})

const submit = (date) => {
    form.date = date;
    form.post(route('meetings.store'), {
        onSuccess: () => form.reset(),
    });
};

const destroy = (id) => {
    if(confirm('Jesteś pewien?')) {
        Inertia.delete(route('meetings.destroy', id))
    }
    return (destroy)
}

watch(date, (date) => {
    router.get('/meetings', {date: date}, {preserveState: true, replace: true});
});

const toggleSort = () => {
    sortDirection.value = sortDirection.value === 'asc' ? 'desc' : 'asc';
    router.get(route('meetings.index'), {
        sort: 'start_date',
        direction: sortDirection.value
    }, {
        preserveState: true,
        preserveScroll: true
    });
};

const selectedRows = ref([]);

const updateSelectRow = (rowId) => {
    if (selectedRows.value.includes(rowId)) {
        selectedRows.value = selectedRows.value.filter(id => id !== rowId);
    } else {
        selectedRows.value.push(rowId);
    }
};
const toggleSelectAll = (event) => {
    if (event.target.checked) {
        selectedRows.value = props.upcomingMeetings.data.map(meeting => meeting.id);
    } else {
        selectedRows.value = [];
    }
};

const showDescriptionModal = ref(false);
const selectedMeeting = ref(null);

const descriptionForm = useForm({
    description: '',
});

const openDescriptionModal = (meeting) => {
    selectedMeeting.value = meeting;
    descriptionForm.description = meeting.description ?? '';
    showDescriptionModal.value = true;
};

const closeDescriptionModal = () => {
    showDescriptionModal.value = false;
    selectedMeeting.value = null;
    descriptionForm.reset();
};

const submitDescription = () => {
    descriptionForm.patch(route('meetings.update', selectedMeeting.value), {
        onSuccess: () => {
            closeDescriptionModal();
        },
    });
};

const printSelectedRows = () => {
    if (selectedRows.value.length === 0) return;

    const url = route('reports.generate', {
        type: 'meetings',
        ids: selectedRows.value
    });
    window.open(url, '_blank');
};
</script>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {Link, useForm} from "@inertiajs/vue3";
import { ref} from "vue";

import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextArea from "@/Components/TextArea.vue";
import InputError from "@/Components/InputError.vue";
import InputLabel from "@/Components/InputLabel.vue";
import TextInput from "@/Components/TextInput.vue";
import moment from "moment";
import {Inertia} from "@inertiajs/inertia";

const form = useForm({
    hoursWorked: null,
    note: null,
    startDate: null,
    endDate: null,
    status: null,
    vacation: null,
    message: ''
})

const activeStep = ref(2);
const subStep = ref(1);

defineProps({
    vacations: Object,
    statuses: Array,
    upcomingVacations: Object
})

const reply = (vacation) => {
    response.value = true;
    form.vacation = vacation;
    form.status = vacation.status;
};

const destroy = (id) => {
    if(confirm('Jesteś pewien?')) {
        Inertia.delete(route('vacations.destroy', id))
    }
    return (destroy)
}

const response = ref(false);
let model = ref(null);


const closeModal = () => {
    response.value = false;
    form.reset();
};

const getStatusClass = (status) => {
    switch (status) {
        case 'accepted':
            return 'font-normal text-green-500';
        case 'rejected':
            return 'font-normal text-red-500';
        case 'pending':
            return 'font-normal text-yellow-500';
        default:
            return 'font-normal text-gray-500';
    }
};

const updateVacation = () => {
    form.patch(route('vacations.update', form.vacation), {
        onSuccess: () => closeModal(),
    });
};
const handleStartDate = (modelData) => {
    form.startDate = modelData;
    if (form.endDate) {
        activeStep.value += 1;
    }
}

const handleEndDate = (modelData) => {
    form.endDate = modelData;
    if (form.startDate) {
        activeStep.value += 1;
    }
}

function prevStep() {
    activeStep.value -= 1;
}

function nextStep() {
    activeStep.value += 1;
    subStep.value = 1;
}

</script>

<template>
    <AuthenticatedLayout>

        <template #header>
            <div class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <Link v-show="activeStep === 2 && subStep === 1" :href="route('dashboard')">
                    <i class="fas fa-arrow-left text-blue-500"> Cofnij</i>
                </Link>
                <i v-if="activeStep >= 3" class="fas fa-arrow-left text-blue-500" @click="prevStep"> Cofnij</i>

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


        <div class="p-12">
            <!--User Panel-->
            <div v-if="!$page.props.auth.isAdmin" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolumna z VueDatePicker i przyciskiem -->
                <div class="flex flex-col items-start space-y-4">
                    <VueDatePicker
                        v-show="activeStep === 2 && subStep === 1"
                        no-today
                        inline
                        :enableTimePicker="false"
                        v-model="form.startDate"
                        clearable="true"
                        :select-text="$t('dataPicker.pick')"
                        :cancel-text="$t('dataPicker.cancel')"
                        locale="pl"
                        class="w-full"
                        @date-update="handleStartDate"
                    ></VueDatePicker>
                    <div v-if="form.errors.startDate" class="text-red-500">{{ form.errors.startDate }}</div>
                </div>

                <div class="flex flex-col items-start space-y-4">
                    <VueDatePicker
                        v-show="activeStep === 2 && subStep === 1"
                        no-today
                        inline
                        :enableTimePicker="false"
                        v-model="form.endDate"
                        clearable="true"
                        :select-text="$t('dataPicker.pick')"
                        :cancel-text="$t('dataPicker.cancel')"
                        locale="pl"
                        class="w-full"
                        @date-update="handleEndDate"
                    ></VueDatePicker>
                </div>

                <div class="flex flex-col items-start space-y-4" v-show="activeStep === 3 && subStep === 1">
                    <InputLabel for="hoursWorked" value="Przepracowane Godziny"/>
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
                    <InputError class="mt-2" v-if="form.errors.hoursWorked" :message="$t('form.errors.hoursWorked')"/>

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

                <div v-show="activeStep === 4" class="overflow-hidden shadow-sm sm:rounded-lg my-2 mx-auto p-3">
                    <p class="text-gray-700 font-semibold">Pracownik: {{$page.props.auth.user.name}}</p>
                    <p class="text-gray-600">Start Urlopu: {{moment(form.startDate).format("D-M-Y")}}</p>
                    <p class="text-gray-600">Ostatni dzień urlopu: {{moment(form.endDate).format("D-M-Y")}}</p>
                    <p class="text-gray-600">Przepracowane godziny: {{form.hoursWorked}}</p>
                    <p v-show="form.note" class="text-gray-600">Notatka: {{form.note}}</p>

                    <SecondaryButton
                        :disabled="form.processing"
                        @click="!form.processing && form.post(route('vacations.store'))"
                        type="submit"
                        class="mt-4 bg-blue-500 py-2 px-4 rounded hover:bg-blue-400 hover:text-white disabled:opacity-50"
                    >
                        Potwierdź
                    </SecondaryButton>
                </div>
            </div>
            <!--Admin Panel-->
            <div v-if="$page.props.auth.isAdmin" class="grid grid-cols-1">
                <div class="flex flex-col items-start space-y-4 overflow-x-auto">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                {{$t('vacation.requester')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{$t('vacation.date')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{$t('vacation.status')}}
                            </th>

                            <th scope="col" class="px-6 py-3">
                                {{$t('actions')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="vacation in vacations.data" v-if="vacations" :key="vacation.id"
                            class="border-b hover:bg-blue-200"
                            :class="{
                                        'bg-green-100': vacation.status === 'accepted',
                                        'bg-red-100': vacation.status === 'rejected',
                                        }"
                        >
                            <th scope="col" class="px-6 py-3">
                                {{vacation.user.name}}
                            </th>

                            <th scope="row"
                                class="flex items-center px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">{{ vacation.start_at }} - {{ vacation.end_at }}</div>
                                    <div :class="getStatusClass(vacation.status)">{{ $t('vacation.status.' + vacation.status)}}</div>
                                </div>
                            </th>

                            <th scope="col" class="px-6 py-3">
                                <svg v-if="vacation.status === 'accepted'" class="w-8 h-8 md:w-6 md:h-6 sm:w-4 sm:h-4 text-gray-800 dark:text-green-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M12 2c-.791 0-1.55.314-2.11.874l-.893.893a.985.985 0 0 1-.696.288H7.04A2.984 2.984 0 0 0 4.055 7.04v1.262a.986.986 0 0 1-.288.696l-.893.893a2.984 2.984 0 0 0 0 4.22l.893.893a.985.985 0 0 1 .288.696v1.262a2.984 2.984 0 0 0 2.984 2.984h1.262c.261 0 .512.104.696.288l.893.893a2.984 2.984 0 0 0 4.22 0l.893-.893a.985.985 0 0 1 .696-.288h1.262a2.984 2.984 0 0 0 2.984-2.984V15.7c0-.261.104-.512.288-.696l.893-.893a2.984 2.984 0 0 0 0-4.22l-.893-.893a.985.985 0 0 1-.288-.696V7.04a2.984 2.984 0 0 0-2.984-2.984h-1.262a.985.985 0 0 1-.696-.288l-.893-.893A2.984 2.984 0 0 0 12 2Zm3.683 7.73a1 1 0 1 0-1.414-1.413l-4.253 4.253-1.277-1.277a1 1 0 0 0-1.415 1.414l1.985 1.984a1 1 0 0 0 1.414 0l4.96-4.96Z" clip-rule="evenodd"/>
                                </svg>

                                <svg v-if="vacation.status === 'rejected'" class="w-8 h-8 md:w-6 md:h-6 sm:w-4 sm:h-4 text-gray-800 dark:text-red-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm7.707-3.707a1 1 0 0 0-1.414 1.414L10.586 12l-2.293 2.293a1 1 0 1 0 1.414 1.414L12 13.414l2.293 2.293a1 1 0 0 0 1.414-1.414L13.414 12l2.293-2.293a1 1 0 0 0-1.414-1.414L12 10.586 9.707 8.293Z" clip-rule="evenodd"/>
                                </svg>

                                <svg v-if="vacation.status === 'cancelled'" class="w-6 h-6 text-gray-800 dark:text-white"
                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                     fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>

                                <svg v-if="vacation.status === 'pending'"
                                     class="w-8 h-8 md:w-6 md:h-6 sm:w-4 sm:h-4 text-gray-800 dark:text-white animate-spin-slow"
                                     aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                          stroke-width="3"
                                          d="M18.5 4h-13m13 16h-13M8 20v-3.333a2 2 0 0 1 .4-1.2L10 12.6a1 1 0 0 0 0-1.2L8.4 8.533a2 2 0 0 1-.4-1.2V4h8v3.333a2 2 0 0 1-.4 1.2L13.957 11.4a1 1 0 0 0 0 1.2l1.643 2.867a2 2 0 0 1 .4 1.2V20H8Z"/>
                                </svg>
                            </th>
                            <th class="px-6 py-4">
                                <div class="flex space-x-2">
                                    <button @click="reply(vacation)" class="p-2 dark:bg-gray-800 rounded hover:bg-gray-300 dark:hover:bg-gray-700">
                                        <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M14.502 7.046h-2.5v-.928a2.122 2.122 0 0 0-1.199-1.954 1.827 1.827 0 0 0-1.984.311L3.71 8.965a2.2 2.2 0 0 0 0 3.24L8.82 16.7a1.829 1.829 0 0 0 1.985.31 2.121 2.121 0 0 0 1.199-1.959v-.928h1a2.025 2.025 0 0 1 1.999 2.047V19a1 1 0 0 0 1.275.961 6.59 6.59 0 0 0 4.662-7.22 6.593 6.593 0 0 0-6.437-5.695Z"/>
                                        </svg>
                                    </button>

                                    <button @click="destroy(vacation.id)" title="Usuń" class="p-2 text-white bg-red-600 dark:bg-red-700 hover:bg-red-500 dark:hover:bg-red-600 border border-red-200 dark:border-red-600 focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-700 font-medium rounded-lg text-xs inline-flex items-center">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <div class="text-green-500 bg-red-500/20">
                </div>
                <nav class=" m-2 flex items-center flex-column flex-wrap md:flex-row justify-between pt-4" aria-label="Table navigation">
                    <ul class="inline-flex -space-x-px rtl:space-x-reverse text-sm h-8">
                        <Link
                            v-for="(link, index) in vacations.links"
                            :key="index"
                            :href="link.url"
                            class="flex items-center justify-center px-3 h-8 leading-tight text-gray-500 bg-white border border-gray-300 hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                            v-html="$t(link.label)"
                        />
                    </ul>
                </nav>
            </div>
            <!--Answer modal Panel-->
            <Modal :show="response" @close="closeModal">
                <div class="p-6">
                    <select
                        id="status"
                        v-model="form.status"
                        class="my-3 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    >
                        <option v-for="status in statuses" :key="status" :value="status">
                            {{$t('vacation.status.' + status)}}
                        </option>
                    </select>

                    <input id="newStartDate"
                           v-model="form.startDate"
                           class=" mt-1 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                           type='date'> do
                    <input id="newEndDate"
                           v-model="form.endDate"
                           class="mb-3 border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"

                           type='date'>


                    <TextArea v-model="form.message"></TextArea>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> {{$t('modal.cancel')}} </SecondaryButton>

                        <PrimaryButton
                            class="ms-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="updateVacation"
                        >
                            {{$t('vacation.send')}}
                        </PrimaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>
<style>
@keyframes spin-slow {
    0% {
        transform: rotate(0deg);
    }
    45% {
        transform: rotate(180deg);
    }
    50% {
        transform: rotate(180deg);
    }
    95% {
        transform: rotate(360deg);
    }
    100% {
        transform: rotate(360deg);
    }
}

.animate-spin-slow {
    animation: spin-slow 8s linear infinite;
}
</style>

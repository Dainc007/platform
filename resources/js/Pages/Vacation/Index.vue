<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {useForm} from "@inertiajs/vue3";
import { ref} from "vue";

import Modal from "@/Components/Modal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import TextArea from "@/Components/TextArea.vue";

const form = useForm({
    date: null,
    status: null,
    vacation: null
})

defineProps({
    vacations: Object,
    statuses: Array
})

const reply = (vacation) => {
    response.value = true;
    form.vacation = vacation;
    form.status = vacation.status;

};

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

</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <h1 class="text-white text-center mb-2 text-lg">{{$t('vacation.my')}}</h1>
            <div v-if="!$page.props.auth.isAdmin" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolumna z VueDatePicker i przyciskiem -->
                <div class="flex flex-col items-start space-y-4">
                    <VueDatePicker
                        no-today
                        :placeholder="'Kliknij tutaj aby wybrać datę'"
                        dark="true"
                        :enableTimePicker="false"
                        range
                        v-model="form.date"
                        clearable="true"
                        :select-text="$t('dataPicker.pick')"
                        :cancel-text="$t('dataPicker.cancel')"
                        :clear-text="123"
                        locale="pl"
                        class="w-full"
                    ></VueDatePicker>
                    <PrimaryButton
                        class="w-full flex justify-center"
                        @click="!form.processing && form.post(route('vacations.store'))"
                    >
                        {{$t('vacation.apply')}}
                    </PrimaryButton>
                    <div v-if="form.errors.date" class="text-red-500">{{ form.errors.date }}</div>
                </div>

                <!-- Kolumna z tabelą -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-9">
                                {{$t('vacation.date')}}
                            </th>
                            <th scope="col" class="px-6 py-3">
                                {{$t('vacation.status')}}
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="vacation in vacations" v-if="vacations" :key="vacation.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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

                                <svg v-if="vacation.status === 'cancelled'" class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7.757 12h8.486M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                </svg>

                                <svg v-if="vacation.status === 'pending'" class="w-8 h-8 md:w-6 md:h-6 sm:w-4 sm:h-4 text-gray-800 dark:text-white animate-spin-slow" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M18.5 4h-13m13 16h-13M8 20v-3.333a2 2 0 0 1 .4-1.2L10 12.6a1 1 0 0 0 0-1.2L8.4 8.533a2 2 0 0 1-.4-1.2V4h8v3.333a2 2 0 0 1-.4 1.2L13.957 11.4a1 1 0 0 0 0 1.2l1.643 2.867a2 2 0 0 1 .4 1.2V20H8Z"/>
                                </svg>
                            </th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!--            Admin Panel-->
            <div v-if="$page.props.auth.isAdmin" class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
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
                    <tr v-for="vacation in vacations" v-if="vacations" :key="vacation.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
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
                            <button @click="reply(vacation)">
                                <svg class="w-6 h-6 text-gray-800 dark:text-white" aria-hidden="true"
                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
                                     viewBox="0 0 24 24">
                                    <path
                                        d="M14.502 7.046h-2.5v-.928a2.122 2.122 0 0 0-1.199-1.954 1.827 1.827 0 0 0-1.984.311L3.71 8.965a2.2 2.2 0 0 0 0 3.24L8.82 16.7a1.829 1.829 0 0 0 1.985.31 2.121 2.121 0 0 0 1.199-1.959v-.928h1a2.025 2.025 0 0 1 1.999 2.047V19a1 1 0 0 0 1.275.961 6.59 6.59 0 0 0 4.662-7.22 6.593 6.593 0 0 0-6.437-5.695Z"/>
                                </svg>
                            </button>
                        </th>
                    </tr>
                    </tbody>
                </table>
            </div>

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

                    <TextArea></TextArea>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> {{$t('modal.cancel')}} </SecondaryButton>

                        <PrimaryButton
                            class="ms-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="closeModal && form.patch(route('vacations.update', form.vacation))"
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

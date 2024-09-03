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
    if (status === 'accepted') {
        return 'bg-green-500';
    } else if (status === 'rejected') {
        return 'bg-red-500';
    } else {
        return 'shadow-lg'; // Domyślny kolor
    }
};

</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <h1 class="text-white text-center mb-2 text-lg">Moje Urlopy</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kolumna z VueDatePicker i przyciskiem -->
                <div class="flex flex-col items-start space-y-4">
                    <VueDatePicker
                        dark="true"
                        :enableTimePicker="false"
                        range
                        v-model="form.date"
                        :select-text="'Wybierz'"
                        :cancel-text="'Anuluj'"
                        locale="pl"
                        class="w-full"
                    ></VueDatePicker>
                    <PrimaryButton
                        class="w-full sm:w-auto"
                        @click="!form.processing && form.post(route('vacations.store'))"
                    >
                        Zgłoś Urlop
                    </PrimaryButton>
                </div>

                <!-- Kolumna z tabelą -->
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
                        <thead class="text-xs text-white uppercase bg-blue-600 dark:text-white">
                        <tr>
                            <th scope="col" class="px-6 py-3">Status</th>
                            <th scope="col" class="px-6 py-3">Od - Do</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="vacation in vacations" :key="vacation.id" :class="getStatusClass(vacation.status)">
                            <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                                {{ vacation.status }}
                            </th>
                            <td class="px-6 py-4">{{ vacation.start_at }} do {{ vacation.end_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>



            <!--            Admin Panel-->
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg mt-3">
                <table class="w-full text-sm text-left rtl:text-right text-blue-100 dark:text-blue-100">
                    <thead class="text-xs text-white uppercase bg-blue-600 dark:text-white">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            Status
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Od - Do
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Actions
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="vacation in vacations" :class="getStatusClass(vacation.status)">
                        <th scope="row" class="px-6 py-4 font-medium text-blue-50 whitespace-nowrap dark:text-blue-100">
                            {{vacation.status}}
                        </th>
                        <td class="px-6 py-4">
                            {{vacation.start_at}} - {{vacation.end_at}}

                        </td>
                        <td class="px-6 py-4">
                            <button @click="reply(vacation)">Odpowiedz</button>
<!--                            <a :href="route('vacations.update', vacation)" class="font-medium text-blue-600 dark:text-blue-500 hover:underline mx-auto">Odpowiedz</a>-->
                        </td>
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
                            {{ status }}
                        </option>
                    </select>

                    <TextArea></TextArea>

                    <div class="mt-6 flex justify-end">
                        <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                        <PrimaryButton
                            class="ms-3"
                            :class="{ 'opacity-25': form.processing }"
                            :disabled="form.processing"
                            @click="closeModal && form.patch(route('vacations.update', form.vacation))"
                        >
                            Wyślij
                        </PrimaryButton>
                    </div>
                </div>
            </Modal>
        </div>
    </AuthenticatedLayout>
</template>

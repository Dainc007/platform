<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Link, useForm, usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

const { props } = usePage();
const contractor = props.contractor;
const currencies = props.currencies;
const brands = props.brands;

const form = useForm({
    name: contractor.name,
});

const uploadForm = useForm({
    file: null,
    currency_id: null,
    brand_id: null,
    contractor_id: contractor.id,
    type: 'standard'
})
function submit() {
  uploadForm.post('/files', {
    data: uploadForm,
    onSuccess: () => {
      uploadForm.reset();
    },
    onError: (errors) => {
      form.errors = errors;
    }
  });
}

const handleFileUpload = (event) => {
  uploadForm.file = event.target.files[0];
};
</script>

<template>
<AuthenticatedLayout>
    <div class="max-w-6xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md dark:bg-gray-800 sm:rounded-lg">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-1 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <header>
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{$t('contractor')}}</h2>
                    <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                      {{$t('contractor.lastUpdate')}} {{ contractor.updated_at }}
                    </p>
                </header>

                <form @submit.prevent="form.patch(route('contractors.update', { contractor: contractor }))" class="mt-6 space-y-6">
                    <div>
                        <InputLabel for="name" value="Name" />
                        <TextInput
                            id="name"
                            type="text"
                            class="mt-1 block w-full"
                            v-model="form.name"
                            required
                            autofocus
                            autocomplete="name"
                        />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="form.processing">{{$t('contractor.save')}}</PrimaryButton>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="form.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">{{$t('contractor.saved')}}.</p>
                        </Transition>
                    </div>
                </form>

                <header class="mt-10">
                    <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">{{$t('contractor.file.upload')}}</h2>
                </header>

                <form @submit.prevent="submit" class="mt-6 space-y-6">
                    <div>
                        <InputLabel for="file" value="File" />
                        <input
                            id="file"
                            type="file"
                            @change="handleFileUpload"
                            class="block w-full text-sm text-gray-500 dark:text-gray-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-gray-700 file:text-blue-700 dark:file:text-gray-300 hover:file:bg-blue-100 dark:hover:file:bg-gray-600"
                        />
                      <progress v-if="uploadForm.progress" :value="uploadForm.progress.percentage" max="100">
                        {{ uploadForm.progress.percentage }}%
                      </progress>
                    </div>

                    <div>
                        <label for="type"
                               class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{ $t('contractor.offer.type') }}</label>
                        <select
                            id="type"
                            v-model="uploadForm.type"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                        >
                            <option value="standard">
                                Standard
                            </option>
                            <option value="stock">
                                Stock
                            </option>
                        </select>
                        <div v-if="uploadForm.errors.type" class="text-red-500">{{ uploadForm.errors.type }}</div>
                    </div>

                    <div>
                        <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$t('contractor.currency')}}</label>
                        <select
                            id="currency_id"
                            v-model="uploadForm.currency_id"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                        >
                            <option v-for="currency in currencies" :key="currency.id" :value="currency.id">
                                {{ currency.code }}
                            </option>
                        </select>
                    </div>
                    <div v-if="form.errors.currency_id" class="text-red-500">{{ form.errors.currency_id }}</div>

                    <div>
                        <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$t('contractor.brand')}}</label>
                        <select
                            id="brand_id"
                            v-model="uploadForm.brand_id"
                            class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                        >
                            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
                                {{ brand.name }}
                            </option>
                        </select>
                    </div>
                    <div v-if="form.errors.brand_id" class="text-red-500">{{ form.errors.brand_id }}</div>

                    <div class="flex items-center gap-4">
                        <PrimaryButton :disabled="uploadForm.processing">{{$t('contractor.file.upload')}}</PrimaryButton>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-if="uploadForm.recentlySuccessful" class="text-sm text-gray-600 dark:text-gray-400">{{$t('contractor.file.uploaded')}}.</p>
                        </Transition>
                    </div>
                </form>
            </div>

            <div class="lg:col-span-2 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
                <div class="overflow-x-auto">
                    <table class="min-w-full bg-white dark:bg-gray-800">
                        <thead>
                        <tr>
                            <th class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{$t('contractor.file.path')}}</th>
                            <th class="py-2 px-4 bg-gray-200 dark:bg-gray-700 text-left text-xs font-semibold text-gray-600 dark:text-gray-300 uppercase tracking-wider">{{$t('contractor.file.updatedAt')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="file in contractor.files" :key="file.id" class="border-b border-gray-200 dark:border-gray-700">
                            <td class="py-2 px-4 text-gray-900 dark:text-gray-200">{{ file.path }}</td>
                            <td class="py-2 px-4 text-gray-900 dark:text-gray-200">{{ file.updated_at }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</AuthenticatedLayout>
</template>

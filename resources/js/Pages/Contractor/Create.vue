<template>
  <AuthenticatedLayout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">{{$t('contractor.header')}}</h1>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$t('contractor.name')}}</label>
          <input
              type="text"
              id="name"
              v-model="form.name"
              class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
          />
          <div v-if="form.errors.name" class="text-red-500">{{ form.errors.name }}</div>
        </div>
        <div>
          <label for="file" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$t('contractor.file')}}</label>
          <input
              type="file"
              id="file"
              @change="handleFileUpload"
              class="mt-1 block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 dark:file:bg-blue-900 file:text-blue-700 dark:file:text-blue-300 hover:file:bg-blue-100 dark:hover:file:bg-blue-800"
          />
          <div v-if="form.errors.file" class="text-red-500">{{ form.errors.file }}</div>
        </div>
        <div>
          <label for="currency" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$t('contractor.currency')}}</label>
          <select
              id="currency_id"
              v-model="form.currency_id"
              class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
          >
            <option v-for="currency in currencies" :key="currency.id" :value="currency.id">
              {{ currency.code }}
            </option>
          </select>
          <div v-if="form.errors.currency_id" class="text-red-500">{{ form.errors.currency_id }}</div>
        </div>
        <div>
          <label for="brand" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$t('contractor.brand')}}</label>
          <select
              id="brand_id"
              v-model="form.brand_id"
              class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
          >
            <option v-for="brand in brands" :key="brand.id" :value="brand.id">
              {{ brand.name }}
            </option>
          </select>
          <div v-if="form.errors.brand_id" class="text-red-500">{{ form.errors.brand_id }}</div>
        </div>
        <button
            type="submit"
            class="w-full py-2 px-4 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
        >
          {{$t('contractor.submit')}}
        </button>
      </form>
    </div>
  </AuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
  components: { AuthenticatedLayout },
  props: {
    brands: Array,
    currencies: Array,
    errors: Object
  },
  setup(props) {
    const form = useForm({
      name: '',
      file: null,
      currency_id: null,
      brand_id: null
    });

    const handleFileUpload = (event) => {
      form.file = event.target.files[0];
    };

    const submit = () => {
      form.post(route('contractors.store'), {
        onSuccess: () => {
          form.reset();
        },
        onError: (errors) => {
          form.errors = errors;
        }
      });
    };

    return {
      form,
      handleFileUpload,
      submit,
      currencies: props.currencies,
      errors: props.errors
    };
  },
};
</script>

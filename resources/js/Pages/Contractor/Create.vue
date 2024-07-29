<template>
  <AuthenticatedLayout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-4">Add Contractor</h1>
      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input
              type="text"
              id="name"
              v-model="form.name"
              class="mt-1 block w-full py-2 px-3 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
          />
        </div>
        <div>
          <label for="file" class="block text-sm font-medium text-gray-700">File</label>
          <input
              type="file"
              id="file"
              @change="handleFileUpload"
              class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
          />
        </div>
        <button
            type="submit"
            class="w-full py-2 px-4 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
        >
          Submit
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
  components: {AuthenticatedLayout},
  setup() {
    const form = useForm({
      name: '',
      file: null,
    });

    const handleFileUpload = (event) => {
      form.file = event.target.files[0];
    };

    const submit = () => {
      form.post(route('contractors.store'), {
        onSuccess: () => {
          form.reset();
        },
      });
    };

    return {
      form,
      handleFileUpload,
      submit,
    };
  },
};
</script>


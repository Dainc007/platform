<template>
<AuthenticatedLayout>
  <div class="max-w-4xl mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-4">Uploaded Files</h1>
    <table class="min-w-full bg-white">
      <thead>
      <tr>
        <th class="py-2 px-4 border-b">ID</th>
        <th class="py-2 px-4 border-b">File Path</th>
      </tr>
      </thead>
      <tbody>
      <tr v-for="file in files" :key="file.id">
        <td class="py-2 px-4 border-b">{{ file.id }}</td>
        <td class="py-2 px-4 border-b">{{ file.path }}</td>
      </tr>
      </tbody>
    </table>
  </div>
</AuthenticatedLayout>
</template>

<script>
import { ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
  components: {AuthenticatedLayout},
  setup() {
    const { props } = usePage();
    const files = ref(props.files);

    return {
      files,
    };
  },
};
</script>

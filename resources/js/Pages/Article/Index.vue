<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head} from '@inertiajs/vue3';
import Card from "@/Components/Card.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import NavLink from "@/Components/NavLink.vue";

defineProps({
  articles: Array
});
</script>

<template>
  <Head title="Articles"/>
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Articles</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-4">
              <NavLink :href="route('articles.create')">Add Article</NavLink>
          </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg my-4">
          <Card v-for="article in articles" :article></Card>
        </div>
      </div>


    </div>
  </AuthenticatedLayout>
</template>

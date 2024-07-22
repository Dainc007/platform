<template>
  <Head title="Dashboard" />
  <AuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Articles</h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="w-full max-w-xs mx-auto">
          <FlashMessage></FlashMessage>
          <form class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4"  @submit.prevent="submit">
            <div class="mb-4">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                Title
              </label>
              <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                     id="title" v-model="form.title" type="text" placeholder="Title">
              <small class="text-red-500" v-if="$page.props.errors.title">{{$page.props.errors.title}}</small>
            </div>
            <div class="mb-6">
              <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                Content
              </label>
              <textarea class="shadow appearance-none border border-red-500 rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
                        id="content" v-model="form.content" type="text">
                </textarea>
              <small class="text-red-500" v-if="$page.props.errors.content">{{$page.props.errors.content}}</small>
            </div>
            <SecondaryButton type="submit" class="w-full">Create</SecondaryButton>
          </form>
        </div>
      </div>
    </div>
  </AuthenticatedLayout>
</template>

<script setup>
import { reactive } from 'vue'
import {Head, router} from '@inertiajs/vue3'
import SecondaryButton from "@/Components/SecondaryButton.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import FlashMessage from "@/Components/FlashMessage.vue";


const form = reactive({
    title: null,
    content: null,
})

defineProps({
    status: String
})

function submit() {
    router.post('/articles', form)
}
</script>

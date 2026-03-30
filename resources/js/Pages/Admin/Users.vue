<script setup>
import { ref, watch } from 'vue';
import { router, Link } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from '@/Components/Table/Pagination.vue';
import axios from 'axios';

const props = defineProps({
  users: Object,
});

const search = ref('');
const loadingActivity = ref(false);
const selectedUser = ref(null);
const sessions = ref([]);

watch(search, (value) => {
  router.get(route('admin.users.index'), { search: value }, { preserveState: true, replace: true });
});

const toggle = (userId) => {
  router.post(route('admin.users.toggle', userId), {}, { preserveScroll: true });
};

const viewActivity = async (user) => {
  selectedUser.value = user;
  loadingActivity.value = true;
  sessions.value = [];
  try {
    const { data } = await axios.get(route('admin.users.activity', user.id));
    sessions.value = data.sessions || [];
  } catch (e) {
    console.error(e);
  } finally {
    loadingActivity.value = false;
  }
};
</script>

<template>
  <AuthenticatedLayout>
    <div class="p-12">
      <div v-if="selectedUser" class="mb-8">
        <div class="flex items-center justify-between mb-2">
          <h2 class="text-xl font-semibold dark:text-white">{{ $t('admin.users.activity_for') }} {{ selectedUser.name }}</h2>
          <button @click="selectedUser = null" class="text-sm text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200">
            {{ $t('admin.users.close_activity') }}
          </button>
        </div>
        <div v-if="loadingActivity" class="text-gray-500">{{ $t('admin.users.loading_activity') }}</div>
        <div v-else>
          <div v-if="sessions.length === 0" class="text-gray-500">{{ $t('admin.users.no_sessions') }}</div>
          <div v-else class="relative overflow-x-auto shadow sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-700 dark:text-gray-400">
              <thead class="text-xs uppercase bg-gray-50 dark:bg-gray-700">
                <tr>
                  <th class="px-6 py-3">{{ $t('admin.users.last_activity') }}</th>
                  <th class="px-6 py-3">{{ $t('admin.users.ip_address') }}</th>
                  <th class="px-6 py-3">{{ $t('admin.users.location') }}</th>
                  <th class="px-6 py-3">{{ $t('admin.users.user_agent') }}</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="s in sessions" :key="s.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                  <td class="px-6 py-4">{{ new Date((s.last_activity || 0) * 1000).toLocaleString() }}</td>
                  <td class="px-6 py-4">{{ s.ip_address || '-' }}</td>
                  <td class="px-6 py-4">{{ s.location || $t('admin.users.unknown_location') }}</td>
                  <td class="px-6 py-4 truncate max-w-[40ch]" :title="s.user_agent">{{ s.user_agent || '-' }}</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="flex items-center justify-between mb-4">
        <h1 class="text-2xl font-semibold dark:text-white">{{ $t('admin.users.title') }}</h1>
        <div class="relative">
          <div class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
              <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
            </svg>
          </div>
          <input type="text" v-model="search" class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" :placeholder="$t('admin.users.search_placeholder')">
        </div>
      </div>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
          <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">{{ $t('admin.users.name') }}</th>
              <th scope="col" class="px-6 py-3">{{ $t('admin.users.email') }}</th>
              <th scope="col" class="px-6 py-3">{{ $t('admin.users.status') }}</th>
              <th scope="col" class="px-6 py-3">{{ $t('admin.users.actions') }}</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="user in users.data" :key="user.id" class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
              <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">{{ user.name }}</td>
              <td class="px-6 py-4">{{ user.email }}</td>
              <td class="px-6 py-4">
                <span :class="user.is_active ? 'text-green-700 dark:text-green-500' : 'text-red-700 dark:text-red-500'">
                  {{ user.is_active ? $t('admin.users.active') : $t('admin.users.inactive') }}
                </span>
              </td>
              <td class="px-6 py-4 space-x-2">
                <button class="px-3 py-1 rounded bg-gray-100 hover:bg-gray-200 text-gray-900 border dark:bg-gray-700 dark:text-white dark:border-gray-600 dark:hover:bg-gray-600" @click="viewActivity(user)">
                  {{ $t('admin.users.activity') }}
                </button>
                <button v-if="user.id !== $page.props.auth.user.id" class="px-3 py-1 rounded text-white" :class="user.is_active ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700'" @click="toggle(user.id)">
                  {{ user.is_active ? $t('admin.users.deactivate') : $t('admin.users.activate') }}
                </button>
                <span v-else class="px-3 py-1 text-sm text-gray-400 italic">{{ $t('admin.users.current_user') }}</span>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-4">
        <Pagination :links="users.links" />
      </div>
    </div>
  </AuthenticatedLayout>
</template>

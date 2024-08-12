<template>
    <AuthenticatedLayout>
        <div class="max-w-md mx-auto mt-10 p-6 bg-white dark:bg-gray-800 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4 text-gray-900 dark:text-gray-100">{{$t('brand.header')}}</h1>
            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300">{{$t('brand.name')}}</label>
                    <input
                        type="text"
                        id="name"
                        v-model="form.name"
                        class="mt-1 block w-full py-2 px-3 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-gray-100"
                    />
                </div>
                <div v-if="errors.name" class="text-red-500">{{ errors.name }}</div>
                <button
                    type="submit"
                    class="w-full py-2 px-4 bg-gray-800 dark:bg-gray-200 text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800"
                >
                    {{$t('brand.submit')}}
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
        errors: Object
    },
    setup(props) {
        const form = useForm({
            name: '',
        });


        const submit = () => {
            form.post(route('brands.store'), {
                onSuccess: () => {
                    form.reset();
                },
            });
        };

        return {
            form,
            submit,
        };
    },
};
</script>

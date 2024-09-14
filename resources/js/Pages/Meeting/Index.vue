<template>
    <Head title="Dashboard" />
    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{$t('meeting.header')}}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <Qalendar
                    :events="events"
                >

                </Qalendar>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<style>
@import "qalendar/dist/style.css";
</style>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'
import {useForm} from "@inertiajs/vue3";
import {Qalendar} from "qalendar";
import {ref} from "vue";

const form = useForm({
    date: null,
    status: null,
    vacation: null,
    message: ''
})

defineProps({
})

const events = ref([
    {
        title: "Advanced algebra",
        with: "Chandler Bing",
        time: { start: "2024-09-12 01:05", end: "2024-09-12 02:35" },
        color: "yellow",
        isEditable: true,
        id: "753944708f0f",
        description: "Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores assumenda corporis doloremque et expedita molestias necessitatibus quam quas temporibus veritatis. Deserunt excepturi illum nobis perferendis praesentium repudiandae saepe sapiente voluptatem!"
    },
    {
        title: "Ralph on holiday",
        with: "Rachel Greene",
        time: { start: "2022-05-10", end: "2022-05-22" },
        color: "green",
        isEditable: true,
        id: "5602b6f589fc"
    }
]);

</script>

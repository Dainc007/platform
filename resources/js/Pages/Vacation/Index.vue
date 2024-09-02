<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <div class="flex flex-col sm:flex-row justify-center items-center sm:items-start">
                    <DatePicker class="w-full sm:w-auto"></DatePicker>
                    <PrimaryButton class="mt-4 sm:mt-0 sm:ml-4 w-full sm:w-auto">Zgłoś Urlop</PrimaryButton>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import DatePicker from "@/Components/Date/DatePicker.vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";
</script>

<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import DataTable from "@/Components/Table/DataTable.vue";
import Search from "@/Components/Table/Search.vue";

defineProps({
    employees: Array,
    columns: Array,
});

</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <DataTable :rows="employees" :columns="columns" :hasImage="true">
                    <Search :model="'employees'"/>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

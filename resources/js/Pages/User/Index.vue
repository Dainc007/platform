<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import DataTable from "@/Components/Table/DataTable.vue";
import Search from "@/Components/Table/Search.vue";

defineProps({
    users: Array,
    columns: Array,
    values: Array
});

</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <DataTable :rows="users" :columns="columns" :values="values">
                    <Search :model="'users'"/>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

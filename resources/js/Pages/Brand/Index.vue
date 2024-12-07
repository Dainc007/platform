<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

import DataTable from "@/Components/Table/DataTable.vue";
import Search from "@/Components/Table/Search.vue";

defineProps({
    brands: Array,
    columns: Array,
});

</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <DataTable :rows="brands" :columns="columns">
                    <Search :model="'brands'"/>
                </DataTable>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

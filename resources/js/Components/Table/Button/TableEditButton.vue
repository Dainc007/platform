<script setup>
import { Inertia } from "@inertiajs/inertia";

const props = defineProps({
    id: {
        required: true
    },
});

const edit = (id) => {

    let path = route().current();
    path = path.replace('index', 'edit');

    Inertia.get(route(path, id));
    return (edit);
}
</script>

<template>
    <button @click="edit(id)" title="Edytuj" class="m-1 p-1 text-white bg-blue-600 dark:bg-blue-700 hover:bg-blue-500 dark:hover:bg-blue-600 border border-blue-200 dark:border-blue-600 focus:ring-4 focus:outline-none focus:ring-blue-100 dark:focus:ring-blue-700 font-medium rounded-lg text-xs px-2 py-1 text-center inline-flex items-center">
        <i class="mx-1 py-1 fa-solid fa-edit"></i> <!-- Ikona edycji -->
    </button>
</template>

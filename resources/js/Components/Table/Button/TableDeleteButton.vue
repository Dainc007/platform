<script setup>

import {Inertia} from "@inertiajs/inertia";

const props = defineProps({
    id: {
        required: true
    },
});

const destroy = (id, confirmationMessage) => {
    if(confirm(confirmationMessage)) {

        let path = route().current();
        path = path.replace('index', 'destroy');

        Inertia.delete(route(path, id))
    }
    return (destroy)
}
</script>

<template>
    <button @click="destroy(id, $t('confirm.deletion'))" title="Usuń"  class="m-1 p-1 text-white bg-red-600 dark:bg-red-700 hover:bg-red-500 dark:hover:bg-red-600 border border-red-200 dark:border-red-600 focus:ring-4 focus:outline-none focus:ring-red-100 dark:focus:ring-red-700 font-medium rounded-lg text-xs px-2 py-1 text-center inline-flex items-center" >
        <i class="mx-1 py-1 fa-solid fa-trash"></i> <!-- Ikona usuwania -->
    </button>
</template>

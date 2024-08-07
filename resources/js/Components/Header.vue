<template>
    <template>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">{{ title }}</h2>
    </template>
</template>
<script>
export default {
    props: {
        title: {
            type: String,
            required: true
        }
    }
};
</script>

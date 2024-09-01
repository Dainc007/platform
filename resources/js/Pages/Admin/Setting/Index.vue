<template>
    <AuthenticatedLayout>
        <div>
            <div v-for="setting in settings" :key="setting.id">
                <label>{{ setting.name }}</label>
                <input type="checkbox" :checked="setting.value" @click="toggleSetting(setting)">
            </div>
        </div>
    </AuthenticatedLayout>

</template>

<script>
import { Inertia } from '@inertiajs/inertia';
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";

export default {
    components: {AuthenticatedLayout},
    props: {
        settings: Object
    },
    methods: {
        toggleSetting(setting) {
            setting.value = !setting.value;
            Inertia.put(`/admin/settings/${setting.id}`, setting);
        }
    }
};
</script>

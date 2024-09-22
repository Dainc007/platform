<script setup lang="ts">
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import MeetingsCalendar from "@/Pages/Meeting/MeetingsCalendar.vue";
import CreateMeeting from "@/Pages/Meeting/CreateMeeting.vue";

export type Meeting = {
    id: number,
    title: string,
    description: string,
    start_date: string,
    end_date: string,
    user: {
        id: number,
        name: string,
    }
}

defineProps<{
    meetings: Meeting[]
    auth: {
        isAdmin
    }
}>();
</script>

<template>
    <AuthenticatedLayout>
        <div class="p-12 space-y-12">
            <section v-if="auth.isAdmin">
                <h2 class="font-semibold text-3xl text-white">Kalendarz spotkań</h2>
                <MeetingsCalendar :meetings="meetings" />
            </section>

            <section class="md:max-w-md space-y-6">
                <h2 class="font-semibold text-3xl text-white">Zaplanuj spotkanie</h2>
                <CreateMeeting :meetings="meetings" />
            </section>
        </div>
    </AuthenticatedLayout>
</template>

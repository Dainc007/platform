<script setup lang="ts">
import {Qalendar} from "qalendar";
import {computed, toValue} from "vue";
import { type Meeting } from "./Index.vue";
import {mapMeetingsToEvents} from "@/Pages/Meeting/utils";

const props = defineProps<{
    meetings: Meeting[]
}>();

const config = {
    locale: "pl-PL",
    defaultMode: "month",
    style: {
        colorSchemes: {
            meetings: {
                color: "#fff",
                backgroundColor: "#131313",
            },
        },
    },
};

const events = computed(() => props.meetings.map(mapMeetingsToEvents));
</script>

<template>
    <Qalendar
        :events="toValue(events)"
        :config="config"
    />
</template>

<style>
@import "qalendar/dist/style.css";

@media (prefers-color-scheme: light) {
    .calendar-root-wrapper .calendar-root:not(.is-light-mode .calendar-root-wrapper .calendar-root) {
        background: transparent;
    }
}

@media (prefers-color-scheme: dark) {
    .calendar-root-wrapper .calendar-root:not(.is-light-mode .calendar-root-wrapper .calendar-root) {
        background: transparent;
    }
}

@media (min-width: 768px) {
    .calendar-month__weekday {
        min-height: 86px;
    }
}

.date-picker__week-picker {
    background: rgb(55 65 81)!important;
}
</style>

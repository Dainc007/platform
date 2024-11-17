<script setup>
import { defineProps, ref } from 'vue';
import FormStep from '@/Components/Form/FormStep.vue';

const props = defineProps({
    steps: {
        type: Array,
        required: true
    },
    activeStep: {
        type: Number,
        required: true
    }
});

const currentStep = ref(props.activeStep);
</script>

<template>
    <ol class="items-center w-full space-y-4 sm:flex sm:space-x-8 sm:space-y-0 rtl:space-x-reverse">
        <FormStep
            v-for="(step, index) in props.steps"
            :key="index"
            :id="index + 1"
            :title="step.title"
            :description="step.description"
            :isActive="currentStep === index + 1"
        />
    </ol>
</template>

<script setup>
import DangerButton from '@/Components/DangerButton.vue';
import Modal from '@/Components/Modal.vue';
import SecondaryButton from '@/Components/SecondaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

const confirmingDeletion = ref(false);

const form = useForm({
  id:null
});

const props = defineProps({
  article: {
    type: Object,
    required: true,
  },
});

const confirmDeletion = () => {
    confirmingDeletion.value = true;
};

const deleteRecord = () => {
    form.delete(route('articles.destroy', props.article), {
        article: props.article,
        preserveScroll: true,
        onSuccess: () => closeModal(),
        onFinish: () => form.reset(),
    });
};

const closeModal = () => {
    confirmingDeletion.value = false;
    form.reset();
};
</script>

<template>
    <section class="space-y-6">

        <DangerButton @click="confirmDeletion">Delete</DangerButton>

        <Modal :show="confirmingDeletion" @close="closeModal">
            <div class="p-6">
                <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                    Are you sure you want to delete your record?
                </h2>

                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    Once your account is deleted, all of its resources and data will be permanently deleted. Please
                    enter your password to confirm you would like to permanently delete your account.
                </p>
                <div class="mt-6 flex justify-end">
                    <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                    <DangerButton
                        class="ms-3"
                        :class="{ 'opacity-25': form.processing }"
                        :disabled="form.processing"
                        @click="deleteRecord"
                    >
                        Delete
                    </DangerButton>
                </div>
            </div>
        </Modal>
    </section>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage } from '@inertiajs/vue3';
import { ref } from 'vue';

const form = useForm({});
const message = ref(null);

function submit() {
    form.post('/test', {
        onSuccess: () => {
            message.value = 'Event Triggered!';
        },
        onError: () => {
            message.value = 'Event not Triggered!';
        },
    });
}

const { app_version } = usePage().props;
</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <!-- <p>App version: {{ app_version }}</p> -->

                    <!-- <form @submit.prevent="submit">
                        <button
                            type="submit"
                            class="px-4 py-2 bg-blue-500 text-white rounded"
                        >
                            Submit
                        </button>
                    </form>

                    <p v-if="message" class="mt-4 text-green-600">
                        {{ message }}
                    </p> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

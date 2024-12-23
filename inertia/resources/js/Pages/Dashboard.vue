<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm, usePage} from '@inertiajs/vue3';

const form = useForm({});
function submit() {
    form.post('/test');
}

const { app_version } = usePage().props;

</script>

<template>
    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <p>App version: {{ app_version }}</p>
                    <!-- <form @submit.prevent="submit">
                        <button>Submit</button>
                    </form> -->
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

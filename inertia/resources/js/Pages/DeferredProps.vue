<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const { props } = usePage();
const users = props.users;
const companyCount = props.companyCount;
const companies = ref(null);

const loadCompanies = () => {
    companies.value = props.companies;
};

// Polling logic
let pollInterval;


onMounted(() => {
    console.log('Polling request started');
    
    pollInterval = setInterval(() => {
        console.log('Polling request in progress...');
    }, 2000);
});

onBeforeUnmount(() => {
    clearInterval(pollInterval);
    console.log('Polling request finished');
});
</script>


<template>
    <Head title="Deferred Props" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Deferred Props
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <h1><b>Polling</b></h1>
                            <p>Total Company: {{ companyCount }}</p> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <div>
                            <h1><b>Users</b></h1>
                            <ul>
                                <li v-for="user in users" :key="user.id">
                                    {{ user.name }}
                                </li>
                            </ul>
                        </div>

                        <div class="mt-8">
                            <h1><b>Companies</b></h1>
                            <ul v-if="companies">
                                <li v-for="company in companies" :key="company.id">
                                    {{ company.name }}
                                </li>
                            </ul>
                            <button @click="loadCompanies" class="btn btn-primary mt-4">Load Companies</button>
                            <p>No companies loaded. Click the button to load.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

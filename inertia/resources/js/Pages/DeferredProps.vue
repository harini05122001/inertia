<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3';
import { ref, onMounted, onBeforeUnmount } from 'vue';

const { props } = usePage();
const users = props.users;
const companyCount = ref(props.companyCount);  
const companies = ref(null);
const pollingMessage = ref('Polling request not started');

const loadCompanies = () => {
    companies.value = props.companies;
};

const fetchCompanyCount = async () => {
    try {
        const response = await fetch('/company-count');
        const data = await response.json();
        companyCount.value = data.companyCount;  
        pollingMessage.value = 'Polling request successful';
    } catch (error) {
        pollingMessage.value = 'Error fetching company count';
        console.error('Error fetching company count:', error);
    }
};

// Polling logic
let pollInterval;

onMounted(() => {
    console.log('Polling request started');
    pollingMessage.value = 'Polling request started';
    
    pollInterval = setInterval(fetchCompanyCount, 5000);  
    fetchCompanyCount();
});

onBeforeUnmount(() => {
    clearInterval(pollInterval);  
    pollingMessage.value = 'Polling request finished';
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
                            <p>{{ pollingMessage }}</p>  
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

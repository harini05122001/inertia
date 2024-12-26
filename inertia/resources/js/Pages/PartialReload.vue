<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage, router} from '@inertiajs/vue3';
import axios from 'axios'; 
import { ref } from 'vue';

const count = ref(0); 
const message = ref(''); 

const { users, companies } = usePage().props;
const usersData = ref(users);  
const companiesData = ref(companies);  
const selectedCompany = ref(null);

function reloadUsers() {
    axios.post('/partial-reload/users', { company_id: selectedCompany.value })
        .then(response => {
            usersData.value = response.data.users; 
        })
        .catch(error => {
            console.error('Error reloading users:', error);
        });
}

function reloadPartialData() {
    axios.post('/partial-reload/reload') 
        .then((response) => {
            count.value = response.data.count; 
            message.value = 'Count reloaded successfully!';
        })
        .catch(() => {
            message.value = 'Failed to reload data.';
        });
}
</script>

<template>
    <Head title="Partial Reload" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                Partial Reload
            </h2>
        </template>

        <div>
            <div class="py-12">
                <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <select v-model="selectedCompany" @change="reloadUsers">
                                <option value="">Select Company</option>
                                <option v-for="company in companiesData" :key="company.id" :value="company.id">
                                    {{ company.name }}
                                </option>
                            </select>
                        </div>

                        <div>
                            <ul>
                                <li v-for="user in usersData" :key="user.id">
                                    {{ user.name }} 
                                </li>
                            </ul>
                        </div> 
                    </div>
                </div>
            </div>
        </div>

        <!-- Section for reloading partial data (like count) -->
        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg p-6">
                    <p>Current Count: <strong>{{ count }}</strong></p>

                    <button
                        @click="reloadPartialData"
                        class="px-4 py-2 bg-blue-500 text-white rounded mt-4"
                    >
                        Reload Count
                    </button>

                    <p v-if="message" class="mt-4 text-green-600">
                        {{ message }}
                    </p>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

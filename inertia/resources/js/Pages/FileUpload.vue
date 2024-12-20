<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import axios from 'axios';

const file = ref(null);
const message = ref('');

const handleFileChange = (event) => {
    file.value = event.target.files[0];
};

const uploadFile = async () => {
    const formData = new FormData();
    formData.append('file', file.value);

    try {
        const response = await axios.post('/file-upload', formData, {
            headers: { 'Content-Type': 'multipart/form-data' },
        });
        message.value = response.data.message;
        file.value = null;
    } catch (error) {
        console.error(error);
        message.value = 'File upload failed!';
    }
};
</script>

<template>
    <Head title="File-Upload" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="text-xl font-semibold leading-tight text-gray-800">
                File Upload
            </h2>
        </template>

        <div class="py-12">
            <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
                <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-bold mb-4">Upload a File</h3>

                        <form @submit.prevent="uploadFile">
                            <div class="mb-4">
                                <input
                                    type="file"
                                    @change="handleFileChange"
                                    class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none"
                                />
                            </div>
                            <button
                                type="submit"
                                :disabled="!file"
                                class="px-4 py-2 font-bold text-white bg-blue-500 rounded hover:bg-blue-700 focus:outline-none focus:shadow-outline"
                            >
                                Upload
                            </button>
                        </form>

                        <p v-if="message" class="mt-4 text-green-600">
                            {{ message }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

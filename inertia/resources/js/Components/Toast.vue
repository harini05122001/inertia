<script setup>
import ToastList from '@/Components/ToastList.vue';
import {ref} from 'vue';
import {Inertia} from '@inertiajs/inertia';
import { usePage } from '@inertiajs/vue3';

const items = ref([
    {message: "Set yourself free."},
    // {message: "Custom message."},
    // {message: "And another one."},
]);

const page = usePage();

Inertia.on('finish', () => {
    console.log(page.props); 
    if (page.props?.value?.toast) {
        items.value.unshift({
            message: page.props,
        });
    }
});

function remove(index){
    items.value.splice(index,1);
}
</script>
<template>
    <div class="fixed top-4 right-4 z-50 space-y-4 w-full max-w-xs">
        <ToastList
        v-for="(item, index) in items"
        :key="index"
        :message="item.message"
        @remove="remove(index)"
        />
    </div>
</template>
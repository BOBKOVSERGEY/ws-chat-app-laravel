<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
const props = defineProps({
    chat: {
        type: Object
    }
});
</script>
<template>
    <Head title="Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chat</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                        <!--<div class="
                        w-1/3
                         p-6
                          text-gray-900
                          bg-slate-200
                        ">

                        </div>-->
                        <div class="p-6 text-gray-900 bg-slate-200">
                            {{chat}}
                        </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

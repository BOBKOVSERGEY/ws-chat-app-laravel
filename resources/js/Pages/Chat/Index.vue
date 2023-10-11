<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import { useForm } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';
import {reactive} from "vue";

const props = defineProps({
    users: {
        type: Array
    },
    chats: {
        type: Array
    }
})

function submit(id) {
    router.post('/chats', {title: null, users: [id]})
}
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
                    <div class="flex ">
                        <div class="
                        w-1/3
                         p-6
                          text-gray-900
                          bg-slate-200
                        ">
                            Users
                                <div class="bg-white mb-3 p-3 shadow-sm rounded-lg" v-for="user in users" :key="user.id">
                                    <div class="flex items-center space-x-4">
                                        <div class="flex-1 min-w-0">
                                            <p
                                                @click.prevent="submit(user.id)"
                                                class="font-medium text-gray-900 ">
                                                {{user.name}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            Chats
                            <div class="bg-white mb-3 p-3 shadow-sm rounded-lg"
                                 v-for="chat in chats" :key="chat.id">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <Link :href="route('chats.show', chat.id)">
                                            <p
                                                class="font-medium text-gray-900 ">
                                                {{ chat.title ?? 'Your Chat' }} {{ chat.id }}
                                            </p>
                                        </Link>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 text-gray-900">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import {Head, usePage} from '@inertiajs/vue3';
import {computed, onMounted, ref} from "vue";

const authUser = usePage().props.auth.user;
const props = defineProps({
    chat: {
        type: Object
    },
    users: {
        type: Array
    },
    messages: {
        type: Array
    }
});

const model = ref({
    body: ''
});

onMounted(() => {
    Echo.channel(`store-message.${props.chat.id}`)
        .listen('.store-message', res => {
            props.messages.push(res.message)
        })
});

const userIds = computed(() => {
   return  props.users.map(user => {
        return user.id
    }).filter(userId => {
        return userId !== authUser.id
   })
});



const store = () => {
    axios.post('/messages', {
        chat_id: props.chat.id,
        body: model.value.body,
        user_ids: userIds.value
    }).then( res => {
        props.messages.push(res.data)
        model.value.body = ''
    })
};
</script>
<template>
    <Head title="Chat"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Chat</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="flex ">
                        <div class="
                        w-[300px]
                        flex-[0_0_auto]
                         p-6
                          text-gray-900
                          bg-slate-200
                        ">
                            Users
                            <div class="bg-white mb-3 p-3 shadow-sm rounded-lg" v-for="user in users" :key="user.id">
                                <div class="flex items-center space-x-4">
                                    <div class="flex-1 min-w-0">
                                        <p
                                            class="font-medium text-gray-900 ">
                                            {{ user.name }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="p-6 text-gray-900 w-full">
                            <h3 class="text-lg text-gray-700 mb-4">{{ chat.title ?? 'Your chat' }}</h3>


                            <div
                                v-for="message in messages" :key="message.id"
                                :class="['mb-3', message.is_owner ? 'text-end' : '2']"
                            >
                                <div>
                                    <small>{{ message.user.name }}</small>
                                </div>
                                <p
                                    :class="['mb-3', message.is_owner ? 'bg-indigo-200' : 'bg-gray-200']"
                                    class=" p-3 rounded-md inline-block">
                                    {{ message.body }}
                                </p>
                                <div>
                                    <small>{{ message.time }}</small>
                                </div>
                            </div>
                            <div class="flex my-3">
                    <textarea
                        v-model="model.body"
                        placeholder="Input message"
                        class="
                        border-gray-300 focus:border-indigo-500
                        focus:ring-indigo-500
                        rounded-md shadow-sm mt-1 block w-full"
                    >
                    </textarea>
                                <button
                                    @click.prevent="store"
                                    class="
                        inline-flex items-center px-4 py-2 bg-gray-800
                        border border-transparent
                        rounded-md font-semibold text-xs
                        text-white uppercase tracking-widest hover:bg-gray-700
                        focus:bg-gray-700 active:bg-gray-900 focus:outline-none
                        focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transiti on
                        ease-in-out duration-150 ml-3">
                                    Send
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

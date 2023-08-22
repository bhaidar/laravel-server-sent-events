<script setup>
import { nextTick, ref, watch } from "vue";
import axios from "axios";
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';

const chatMessages = ref([]);
const prompt = ref(null);
const processing = ref(false);
const scrollHere = ref(null);

watch(chatMessages, () => {
    nextTick(() => {
        scrollHere.value?.scrollIntoView({
            behavior:'smooth',
        });
    });
}, {
        deep: true,
        immediate: true
});

const addMessage = ({ role, content}) => {

    const lastMessage = chatMessages.value[chatMessages.value.length - 1];

    if (lastMessage && lastMessage.role === 'user' && role === 'user') return false;

    // Add the chat message
    chatMessages.value.push({ role, content });

    return true;
}

const updateResponse = (response) => {
    let lastMessage = chatMessages.value[chatMessages.value.length - 1];

    if (lastMessage?.role === 'user') {

        addMessage({
            role: 'assistant',
            content: response,
        });

        return;
    }

    // Update the message
    lastMessage.content = response
}

const streamChatResponse = () => {
    processing.value = true;

    let response = "";

    if ('EventSource' in window) {
        const eventSource = new EventSource(route('chat-stream.index'), {withCredentials: true});

        const messageHandler = (event) => {

            let json = JSON.parse(event.data);

            // Append token to response
            response += json.content;

            updateResponse(response);
        }

        const stopHandler = () => {
            // Close the event source
            eventSource.close();

            processing.value = false;

            // Remove the event listeners
            eventSource.removeEventListener('message', messageHandler);
            eventSource.removeEventListener('stop', stopHandler);
        }

        eventSource.addEventListener('message', messageHandler);
        eventSource.addEventListener('stop', stopHandler);
    }
};

const storeChat = async (prompt) => {
    return axios.post(route('chat.store'), {prompt});
};

const askQuestion = async () => {

    const messageAdded = addMessage({
        role: 'user',
        content: prompt.value
    });

    // trigger a new chat stream
    if (messageAdded) {

        await storeChat(prompt.value);

        streamChatResponse();
    }

    // Reset input
    prompt.value = null;
};

</script>

<template>
    <Head title="OpenAI Chat" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">OpenAI Chat</h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <div class="bg-white rounded-lg shadow-lg p-4">
                        <!-- Message Display Area -->
                        <div class="h-96 overflow-scroll border-b border-gray-300 pb-4 prose max-w-full">
                            <div
                                v-for="message in chatMessages" :key="message"
                                class="mb-2"
                             >
                                <div class="flex items-center">
                                    <div
                                        class="w-8 h-8 bg-blue-500 rounded-full flex-shrink-0 mr-2"
                                        :class="message.role === 'user' ? 'bg-blue-500' : 'bg-green-500'">
                                    </div>
                                    <div class="flex-1 bg-gray-200 rounded-md p-2">
                                        <div class="text-sm text-gray-600" v-html="message.content" />
                                    </div>
                                </div>
                            </div>
                            <div ref="scrollHere" id="scroll-here" class="w-full h-1" />
                        </div>

                        <!-- Message Input Area -->
                        <div class="mt-4">
                            <div class="flex items-center">
                                <input v-model="prompt" type="text" class="flex-1 rounded-l-md py-2 px-4 border border-gray-300 focus:outline-none focus:ring focus:border-blue-500" placeholder="Type a message...">
                                <button :disabled="processing" @click="askQuestion" class="bg-blue-500 text-white rounded-r-md px-4 py-2 hover:bg-blue-600 focus:outline-none focus:ring focus:border-blue-500">Send</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

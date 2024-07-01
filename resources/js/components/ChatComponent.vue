<template>
    <div>
        <h1>Chat Application</h1>
        <input v-model="message" placeholder="Enter your message" />
        <button @click="sendMessage">Send</button>
        <div v-if="error" class="error">{{ error }}</div>
        <div>
            <h2>Messages:</h2>
            <ul>
                <li v-for="msg in messages" :key="msg.id">{{ msg.text }}</li>
            </ul>
        </div>
    </div>
</template>

<script>
import axios from 'axios';
import Echo from 'laravel-echo';
import Pusher from 'pusher-js';

export default {
    data() {
        return {
            message: '',
            messages: [],
            error: ''
        };
    },
    mounted() {
        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'pusher',
            key: 'aebe193b0ba319240597',
            cluster: 'eu',
            forceTLS: true
        });

        window.Echo.channel('my-channel')
            .listen('.my-event', (e) => {
                console.log('Received event:', e);
                this.messages.push({ text: e.message });
                console.log('Updated messages:', this.messages);
            });
    },
    methods: {
        async sendMessage() {
            this.error = '';
            try {
                const response = await axios.get('/broadcast', {
                    params: { message: this.message }
                });
                console.log('Message sent:', response.data);
                this.messages.push({ text: this.message });
                this.message = '';
            } catch (error) {
                this.error = error.response ? error.response.data.error : error.message;
                console.error('Error sending message:', error);
            }
        }
    }
};
</script>


<style>
.error {
    color: red;
}
</style>

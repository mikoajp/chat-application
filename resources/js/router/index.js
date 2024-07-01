import { createRouter, createWebHistory } from 'vue-router';
import HomeComponent from '../components/HomeComponent.vue';
import AboutComponent from '../components/AboutComponent.vue';
import ChatComponent from "../components/ChatComponent.vue";

const routes = [
    {
        path: '/',
        name: 'Chat',
        component: ChatComponent
    },
    {
        path: '/about',
        name: 'About',
        component: AboutComponent
    }
];

const router = createRouter({
    history: createWebHistory(),
    routes
});

export default router;

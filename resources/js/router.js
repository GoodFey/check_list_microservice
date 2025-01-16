import {createRouter, createWebHistory} from "vue-router";

// Настройка маршрутов
const routes = [
    {
        path: '/',
        component: () => import('./components/IndexComponent.vue'),
        name: 'index'
    },
    {
        path: '/create',
        component: () => import('./components/CreateComponent.vue'),
        name: 'create'
    },
    {
        path: '/admin',
        component: () => import('./components/AdminComponent.vue'),
        name: 'admin'
    },
    {
        path: '/telegramLogin',
        component: () => import('./components/LoginComponent.vue'),
        name: 'telegramLogin'
    },
    {
        path: '/edit/:checklistId',
        component: () => import('./components/EditComponent.vue'),
        name: 'edit'
    },
];

// Создание роутера
const router = createRouter({
    history: createWebHistory('/'),
    routes,
});

export default router;

import { createRouter, createWebHistory } from "vue-router";
import AuthenticateToken from "./middleware/AuthentificateToken.js";

// Настройка маршрутов
const routes = [
    {
        path: '/test',
        component: () => import('./components/TestComponent.vue'),
        name: 'test'
    },
    {
        path: '/',
        component: () => import('./components/IndexComponent.vue'),
        name: 'index',
        meta: { requiresAuth: true },
    },
    {
        path: '/create',
        component: () => import('./components/CreateComponent.vue'),
        name: 'create',
        meta: { requiresAuth: true },
    },
    {
        path: '/admin',
        component: () => import('./components/AdminComponent.vue'),
        name: 'admin',
        meta: { requiresAuth: true },
    },
    {
        path: '/telegramLogin',
        component: () => import('./components/LoginComponent.vue'),
        name: 'telegramLogin'
    },
    {
        path: '/edit/:checklistId',
        component: () => import('./components/EditComponent.vue'),
        name: 'edit',
        meta: { requiresAuth: true },
    },
];

// Создание роутера
const router = createRouter({
    history: createWebHistory('/'),
    routes,
});

// Перед каждым маршрутом, если маршрут требует авторизации
router.beforeEach((to, from, next) => {
    if (to.meta.requiresAuth) {
        console.log(to.meta.requiresAuth);
        AuthenticateToken(to, from, next); // Применяем middleware для маршрутов с requiresAuth
    } else {
        next(); // Разрешаем переход, если авторизация не требуется
    }
});

export default router;

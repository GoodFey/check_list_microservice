<template>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">CheckList Microservice</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">

                    <li class="nav-item" v-if="isAuthenticated">
                        <router-link class="nav-link" to="/">Мои Чек-Листы</router-link>
                    </li>

                    <li class="nav-item" v-if="isAuthenticated">
                        <router-link class="nav-link" to="/create">Создать</router-link>
                    </li>

                    <li class="nav-item" v-if="isAuthenticated && isAdmin">
                        <router-link class="nav-link" to="/admin">Админка</router-link>
                    </li>

                    <li class="nav-item" v-if="!isAuthenticated">
                        <router-link class="nav-link" to="/telegramLogin">Логин</router-link>
                    </li>

                    <li class="nav-item" v-if="isAuthenticated">
                        <router-link @click.prevent="logout" class="nav-link" to="/telegramLogin">Логаут</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import apiClient from '../services/apiClient.js';

export default {
    data() {
        return {
            isAuthenticated: false, // Состояние аутентификации
            isAdmin: false, // Состояние администратора
        };
    },
    methods: {
        async checkAuth() {
            try {
                const response = await apiClient.get('/auth/validate-token');
                if (response.data.message === 'Token is valid') {
                    this.isAuthenticated = true;
                    // Если в ответе есть информация о пользователе, проверяем, является ли он админом
                    if (response.data.user && response.data.user.is_admin === 1) {
                        this.isAdmin = true;
                    }
                }
            } catch (error) {
                this.isAuthenticated = false;
                this.isAdmin = false;
                console.error('Ошибка проверки токена:', error);
            }
        },
        logout() {
            localStorage.removeItem('auth_token');
            this.isAuthenticated = false;
            this.isAdmin = false;
            this.$router.push('/telegramLogin');
        },
    },
    mounted() {
        this.checkAuth(); // Проверяем аутентификацию при загрузке компонента
    },
    watch: {
        '$route'(to, from) {
            // Проверка состояния при изменении маршрута
            this.checkAuth();
        }
    },

};
</script>

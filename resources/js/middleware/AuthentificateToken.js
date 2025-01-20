// src/middleware/AuthenticateToken.js
import apiClient from '../services/apiClient.js';

export default async function AuthenticateToken(to, from, next) {
    const token = localStorage.getItem('auth_token'); // Берем токен из localStorage

    if (token) {
        try {
            const response = await apiClient.get('/auth/validate-token');
            if (response.data.message === 'Token is valid') {
                next(); // Переход на страницу, если токен валиден
            } else {
                next('/telegramLogin'); // Если токен невалиден, перенаправляем на страницу логина
            }
        } catch (error) {
            next('/telegramLogin'); // Если произошла ошибка, перенаправляем на страницу логина
        }
    } else {
        next('/telegramLogin'); // Если токена нет, перенаправляем на страницу логина
    }
}

import apiClient from './apiClient';

export const telegramAuth = async (telegramData) => {
    try {
        const response = await apiClient.post('/auth/telegram', telegramData);
        const { token, user } = response.data;

        // Сохраняем токен и данные пользователя
        localStorage.setItem('authToken', token);
        localStorage.setItem('user', JSON.stringify(user));

        return user;
    } catch (error) {
        console.error('Ошибка авторизации через Telegram:', error.response?.data || error.message);
        throw error;
    }
};

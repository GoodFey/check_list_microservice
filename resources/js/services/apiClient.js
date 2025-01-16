import axios from 'axios';

// Создаем экземпляр axios
const apiClient = axios.create({
    baseURL: '/api', // Laravel API доступен по этому пути
});

// Интерцептор для добавления токена
apiClient.interceptors.request.use((config) => {
    const token = localStorage.getItem('authToken'); // Берем токен из localStorage
    if (token) {
        config.headers.Authorization = `Bearer ${token}`; // Добавляем заголовок
    }
    return config;
}, (error) => {
    return Promise.reject(error);
});

export default apiClient;

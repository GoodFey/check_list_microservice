<template>
    <div>
        <h1>Авторизация через Telegram</h1>
        <div id="telegram-login-button"></div>
    </div>
</template>

<script>
export default {
    name: "LoginComponent",
    mounted() {
        // Вставляем Telegram-виджет в компонент
        const script = document.createElement("script");
        script.src = "https://telegram.org/js/telegram-widget.js?22";
        script.async = true;
        script.setAttribute("data-telegram-login", "BTW_telega_bot"); // Имя вашего бота
        script.setAttribute("data-size", "large");
        script.setAttribute("data-onauth", "onTelegramAuth(user)");
        script.setAttribute("data-request-access", "write");

        document.getElementById("telegram-login-button").appendChild(script);

        // Обработчик авторизации
        window.onTelegramAuth = (user) => {
            this.handleTelegramAuth(user);

        };
    },
    methods: {
        async handleTelegramAuth(user) {
            try {
                const response = await axios.post('/api/auth/telegram', {
                    id: user.id,
                    auth_date: user.auth_date,
                    first_name: user.first_name,
                    hash: user.hash,
                    photo_url: user.photo_url,
                    username: user.username,
                });
                console.log(response.data);
                const data = await response.data;
                if (response.status >= 200 && response.status < 300) {
                    // Сохраняем токен и перенаправляем пользователя
                    localStorage.setItem('auth_token', data.token);
                    // this.$router.push('/dashboard'); // Перенаправление на защищенную страницу
                } else {
                    console.error('Ошибка авторизации:', data.error);
                }
            } catch (error) {
                console.error('Ошибка при отправке запроса:', error);
            }
        },
    },
};
</script>

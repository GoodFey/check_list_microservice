<template>
    <div>
        <h1>Авторизация через Telegram</h1>
        <!-- Место для виджета Telegram -->
        <div id="telegram-login-button"></div>
    </div>
</template>

<script>
export default {
    name: 'IndexController',
    data() {
        return {
            telegramAuthUrl: '/api/auth/telegram', // Laravel API URL
        };
    },
    mounted() {
        // Загружаем скрипт Telegram после того, как компонент был монтирован
        const script = document.createElement('script');
        script.src = 'https://telegram.org/js/telegram-widget.js?22';
        script.async = true;
        script.setAttribute('data-telegram-login', 'BTW_telega_bot'); // Замените на имя вашего бота
        script.setAttribute('data-size', 'large');
        script.setAttribute('data-radius', '10');
        script.setAttribute('data-auth-url', this.telegramAuthUrl);
        script.setAttribute('data-request-access', 'write');
        script.setAttribute('data-iframe', 'true'); // Добавь это


        document.getElementById('telegram-login-button').appendChild(script);
    },
};
</script>


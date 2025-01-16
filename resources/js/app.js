import './bootstrap';
import { createApp } from 'vue';
import router from './router.js'
import LoginComponent from "./components/LoginComponent.vue";

const app = createApp({});

app.use(router)
app.component('login-component', LoginComponent)


app.mount('#app');

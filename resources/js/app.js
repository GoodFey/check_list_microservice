import './bootstrap';
import { createApp } from 'vue';
import router from './router.js'
import LoginComponent from "./components/LoginComponent.vue";
import NavbarComponent from "./components/NavbarComponent.vue";

const app = createApp({});

app.use(router)
app.component('login-component', LoginComponent)
app.component('navbar-component', NavbarComponent)


app.mount('#app');

import axios from 'axios';
window.axios = axios;

axios.defaults.baseURL = 'http://localhost:8811';

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

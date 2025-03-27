import { createApp } from 'vue';
import App from './App.vue';
import router from './router';
import { createPinia } from 'pinia';
import 'bootstrap/dist/css/bootstrap.min.css';
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost/kishan-patel-vue-laravel-practical/public/';

const app = createApp(App);
app.use(createPinia());
app.use(router);
app.mount('#app');
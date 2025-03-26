import axios from 'axios';

const api = axios.create({
    baseURL: 'http://localhost/kishan-patel-vue-laravel-practical/public/api/',
});

export default api;

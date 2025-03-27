<template>
    <div class="container mt-5">
        <h2>Login</h2>
        <form @submit.prevent="login">
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" v-model="email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Password:</label>
                <input type="password" v-model="password" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>
</template>

<script setup>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

const email = ref('');
const password = ref('');
const errorMessage = ref('');
const router = useRouter();

const login = async () => {
    try {
        const response = await axios.post('/api/auth/login', {
            email: email.value,
            password: password.value,
        });

        localStorage.setItem('token', response.data.token);
        localStorage.setItem('role', 'user');
        localStorage.setItem('user', JSON.stringify(response.data.user));
        axios.defaults.headers.common['Authorization'] = `Bearer ${response.data.token}`;
        router.push('/dashboard');
    } catch (error) {
        alert(error);
        errorMessage.value = error.response?.data?.message || 'Login failed';
    }
};
</script>
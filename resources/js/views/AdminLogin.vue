<template>
    <div class="container mt-5">
        <h2>Admin Login</h2>
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

<script>
import api from '../axios.js';

import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

export default {
    setup() {
            const email = ref('');
            const password = ref('');
            const router = useRouter();

        const login = async () => {
            try {
                const response = await axios.post('admin/login', {
                    email: email.value,
                    password: password.value,
                });
                localStorage.setItem('admin_token', response.data.token);
                router.push('/admin/dashboard');
            } catch (error) {
                alert('Invalid credentials');
            }
        };
        return { email, password, login };
    },
};
</script>

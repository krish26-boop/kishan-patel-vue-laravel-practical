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

<script>
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
                const response = await axios.post('http://localhost/kishan-patel-vue-laravel-practical/public/api/auth/login', {
                    email: email.value,
                    password: password.value,
                });
                localStorage.setItem('token', response.data.token);
                router.push('/dashboard');
            } catch (error) {
                console.log(error);
                alert('Invalid credentials');
            }
        };

        return { email, password, login };
    },
};
</script>

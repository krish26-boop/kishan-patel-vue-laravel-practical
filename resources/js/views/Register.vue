<template>
    <div class="container mt-5">
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div class="mb-3">
                <label>First Name:</label>
                <input type="text" v-model="form.first_name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Last Name:</label>
                <input type="text" v-model="form.last_name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" v-model="form.email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Password:</label>
                <input type="password" v-model="form.password" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Confirm Password:</label>
                <input type="password" v-model="form.password_confirmation" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Phone:</label>
                <input type="text" v-model="form.phone" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>How did you hear about us?</label>
                <select v-model="form.referral_source" class="form-control">
                    <option>LinkedIn</option>
                    <option>Facebook</option>
                    <option>Google</option>
                    <option>Friend</option>
                    <option>Website</option>
                    <option>Other</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    data() {
        return {
            form: {
                first_name: '',
                last_name: '',
                email: '',
                password: '',
                password_confirmation: '',
                phone: '',
                referral_source: 'Google',
            },
        };
    },
    setup() {
        const router = useRouter();
        const register = async () => {
            try {
                await axios.post('/api/auth/register', this.form);
                alert('Registration successful!');
                router.push('/');
            } catch (error) {
                alert('Registration failed. Please try again.');
            }
        };
        return { register };
    },
};
</script>

<template>
    <div class="container mt-5">
        <h2>Register</h2>
        <form @submit.prevent="register">
            <div class="mb-3">
                <label>First Name:</label>
                <input type="text" v-model="form.first_name" class="form-control" required />
                <div class="invalid-feedback" v-if="errors.first_name">{{ errors.first_name[0] }}</div>
            </div>
            <div class="mb-3">
                <label>Last Name:</label>
                <input type="text" v-model="form.last_name" class="form-control" required />
                <div class="invalid-feedback" v-if="errors.last_name">{{ errors.last_name[0] }}</div>
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" v-model="form.email" class="form-control" required />
                <div class="invalid-feedback" v-if="errors.email">{{ errors.email[0] }}</div>
            </div>
            <div class="mb-3">
                <label>Password:</label>
                <input type="password" v-model="form.password" class="form-control" required />
                <div class="invalid-feedback" v-if="errors.password">{{ errors.password[0] }}</div>
            </div>
            <div class="mb-3">
                <label>Confirm Password:</label>
                <input type="password" v-model="form.password_confirmation" class="form-control" required />
                <div class="invalid-feedback" v-if="errors.password_confirmation">{{ errors.password[1] }}</div>
            </div>
            <div class="mb-3">
                <label>Phone:</label>
                <input type="text" v-model="form.phone" class="form-control" required />
                <div class="invalid-feedback" v-if="errors.phone">{{ errors.phone[0] }}</div>
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
                <div class="invalid-feedback" v-if="errors.referral_source">{{ errors.referral_source[0] }}</div>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
</template>

<script>
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import axios from 'axios';

export default {
    setup() {
        const router = useRouter();
        
        // Correctly define form using ref()
        const form = ref({
            first_name: '',
            last_name: '',
            email: '',
            password: '',
            password_confirmation: '',
            phone: '',
            referral_source: 'Google',
        });

        const errors = ref({});

        const register = async () => {
            try {
                await axios.post('/api/auth/register', form.value);
                alert('Registration successful!');
                router.push('/'); // Redirect to home/login page
            } catch (error) {
                                console.log(error);

               if (error.response && error.response.status === 422) {
                    // Store validation errors
                     console.log(error.response.data.errors);
                    errors.value = error.response.data.errors;
                } else {
                    alert('Registration failed. Please try again.');
                }
            }
        };
                                console.log(errors);

        return { form, errors, register };
    },
};
</script>

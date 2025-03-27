<template>
    <div>
     <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="#">Client Management</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item me-3"><router-link to="/profile" class="navbar-brand">Profile</router-link></li>
                        <li class="nav-item">
                            <button class="btn btn-danger" @click="logout">Logout</button>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container">
            <h1 class="mt-3">Dashboard</h1>
            <p class="mt-3">Welcome, <b>{{ fullName }}!</b></p>
        </div>
        
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { useRouter } from 'vue-router';

const fullName = ref('');
const router = useRouter();

onMounted(() => {
    const user = JSON.parse(localStorage.getItem('user')) || {};
    fullName.value = `${user.first_name || 'Guest'} ${user.last_name || ''}`.trim();
});

const logout = () => {
    localStorage.removeItem('token');
    localStorage.removeItem('role');
    localStorage.removeItem('user');
    router.push('/');
};
</script>

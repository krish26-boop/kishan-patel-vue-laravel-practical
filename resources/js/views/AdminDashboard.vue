<template>
<nav class="sidebar">
            <ul class="row">
                <li><router-link to="/admin/technology">Technology</router-link></li>
                <li><router-link to="/admin/clients">Clients</router-link></li>
                <li><router-link to="/admin/client-map">Map-Based Report</router-link></li>
                <li><router-link to="/admin/registration-report">Registration Report</router-link></li>
                <li><router-link to="/admin/technology-report">Technology Report</router-link></li>
            </ul>
        </nav>
    <div class="container mt-5">
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin!</p>
        <button @click="logout" class="btn btn-danger">Logout</button>
    </div>
    

</template>

<script>
import api from '../axios.js';
import axios from 'axios';
import { useRouter } from 'vue-router';

export default {
    setup() {
        const router = useRouter();
        const logout = async () => {
            try {
                await axios.post('admin/logout', {}, {
                    headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` },
                });
                localStorage.removeItem('admin_token');
                router.push('/admin/login');
            } catch (error) {
                alert('Logout failed');
            }
        };
        return { logout };
    },
};
</script>

<template>
 <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <router-link to="/admin/dashboard" class="navbar-brand">Client Management</router-link>
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav"
            >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item me-3">
                        <router-link to="/admin/technologies" class="navbar-brand">Technology</router-link>
                    </li>
                    <li class="nav-item me-3">
                        <router-link to="/admin/client-map" class="navbar-brand"
                            >Map-Based Report</router-link
                        >
                    </li>
                    <li class="nav-item me-3">
                        <router-link to="/admin/registration-report" class="navbar-brand"
                            >Registration Report</router-link
                        >
                    </li>
                    <li class="nav-item me-3">
                        <router-link to="/admin/technology-report" class="navbar-brand"
                            >Technology Report</router-link
                        >
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container mt-5">
        <h2 class="container mb-3">Technology Management</h2>

        <form @submit.prevent="saveTechnology">
            <div class="mb-3">
                <label>Technology Name:</label>
                <input type="text" v-model="techName" class="form-control" required />
            </div>
            <button type="submit" class="btn btn-primary">{{ editing ? 'Update' : 'Add' }}</button>
        </form>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tech in technologies" :key="tech.id">
                    <td>{{ tech.id }}</td>
                    <td>{{ tech.name }}</td>
                    <td>
                        <button @click="editTechnology(tech)" class="btn btn-warning btn-sm me-2">Edit</button>
                        <button @click="deleteTechnology(tech.id)" class="btn btn-danger btn-sm">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
import axios from 'axios';

export default {
    data() {
        return {
            technologies: [],
            techName: '',
            editing: false,
            editId: null,
        };
    },
    mounted() {
        this.fetchTechnologies();
    },
    methods: {
        async fetchTechnologies() {
            const response = await axios.get('/api/admin/technologies', {
                headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
            });
            this.technologies = response.data;
        },
        async saveTechnology() {
            try {
                if (this.editing) {
                    await axios.put(`/api/admin/technologies/${this.editId}`, { name: this.techName }, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
                    });
                } else {
                    await axios.post('/api/admin/technologies', { name: this.techName }, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
                    });
                }
                this.techName = '';
                this.editing = false;
                this.fetchTechnologies();
            } catch (error) {
                alert('Error saving technology');
            }
        },
        editTechnology(tech) {
            this.techName = tech.name;
            this.editing = true;
            this.editId = tech.id;
        },
        async deleteTechnology(id) {
            if (confirm('Are you sure?')) {
                await axios.delete(`/api/admin/technologies/${id}`, {
                    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
                });
                this.fetchTechnologies();
            }
        },
    },
};
</script>

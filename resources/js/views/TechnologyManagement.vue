<template>
    <div class="container mt-5">
        <h2>Technology Management</h2>

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
                        <button @click="editTechnology(tech)" class="btn btn-warning btn-sm">Edit</button>
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
                headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` },
            });
            this.technologies = response.data;
        },
        async saveTechnology() {
            try {
                if (this.editing) {
                    await axios.put(`/api/admin/technologies/${this.editId}`, { name: this.techName }, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` },
                    });
                } else {
                    await axios.post('/api/admin/technologies', { name: this.techName }, {
                        headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` },
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
                    headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` },
                });
                this.fetchTechnologies();
            }
        },
    },
};
</script>

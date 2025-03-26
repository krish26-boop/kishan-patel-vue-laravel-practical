<template>
    <div class="container mt-5">
        <h2>Client List</h2>

        <div class="mb-3">
            <label>Filter by Referral Source:</label>
            <select v-model="referralFilter" class="form-control" @change="fetchClients">
                <option value="">All</option>
                <option v-for="source in referralSources" :key="source" :value="source">{{ source }}</option>
            </select>
        </div>

        <table class="table mt-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Referral Source</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="client in clients.data" :key="client.id">
                    <td>{{ client.id }}</td>
                    <td>{{ client.first_name }} {{ client.last_name }}</td>
                    <td>{{ client.email }}</td>
                    <td>{{ client.phone }}</td>
                    <td>{{ client.referral_source }}</td>
                </tr>
            </tbody>
        </table>

        <button @click="fetchClients(prevPage)" :disabled="!clients.prev_page_url" class="btn btn-primary">Previous</button>
        <button @click="fetchClients(nextPage)" :disabled="!clients.next_page_url" class="btn btn-primary">Next</button>
    </div>
</template>

<script>
import api from '../axios.js';
import axios from 'axios';

export default {
    data() {
        return {
            clients: { data: [] },
            referralFilter: '',
            referralSources: ['LinkedIn', 'Facebook', 'Google', 'Friend', 'Website', 'Other'],
        };
    },
    mounted() {
        this.fetchClients();
    },
    methods: {
        async fetchClients(url = 'admin/clients') {
        console.log(url);
            const response = await axios.get(url, {
                headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` },
                params: { referral_source: this.referralFilter },
            });
            this.clients = response.data;
        },
    },
};
</script>

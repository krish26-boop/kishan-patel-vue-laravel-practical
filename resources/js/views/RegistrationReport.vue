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
        <h2>Registration Report</h2>

         <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Source</th>
                    <th># of Registration</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="tech in reportData" :key="tech.technology">
                    <td>{{ tech.date }}</td>
                    <td>{{ tech.source }}</td>
                    <td>{{ tech.total }}</td>
                </tr>
            </tbody>
        </table>

    </div>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            reportData: []
        };
    },
    mounted() {
        this.fetchReport();
    },
    methods: {
        async fetchReport() {
            try {
                const token = localStorage.getItem('token');
                const response = await axios.post("/api/admin/clients/registration-report", {},
                { headers: { Authorization: `Bearer ${token}` } });
                this.reportData = response.data;
                console.log(this.reportData);
            } catch (error) {
                console.error("Error fetching report:", error);
            }
        }
    }
};
</script>
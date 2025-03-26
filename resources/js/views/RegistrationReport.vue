<template>
    <div class="container mt-5">
        <h2>Registration Report</h2>

        <div class="mb-3">
            <label>Filter by:</label>
            <select v-model="reportType" class="form-control" @change="fetchReport">
                <option value="daily">Daily</option>
                <option value="monthly">Monthly</option>
                <option value="yearly">Yearly</option>
            </select>
        </div>

        <canvas id="registrationChart"></canvas>
    </div>
</template>

<script>
import api from '../axios.js';
import axios from "axios";
import Chart from "chart.js/auto";

export default {
    data() {
        return {
            reportType: "daily",
            chart: null,
        };
    },
    mounted() {
        this.fetchReport();
    },
    methods: {
        async fetchReport() {
            const response = await axios.get("clients/registration-report", {
                headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` },
                params: { type: this.reportType },
            });

            this.renderChart(response.data);
        },
        renderChart(data) {
            const ctx = document.getElementById("registrationChart").getContext("2d");

            if (this.chart) this.chart.destroy();

            this.chart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: data.map(d => d.period),
                    datasets: [{
                        label: "Registrations",
                        data: data.map(d => d.total),
                        backgroundColor: "rgba(75, 192, 192, 0.6)",
                    }]
                }
            });
        }
    }
};
</script>

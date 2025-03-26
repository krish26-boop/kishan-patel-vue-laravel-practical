<template>
    <div class="container mt-5">
        <h2>Technology Interest Report</h2>

        <canvas id="technologyChart"></canvas>
    </div>
</template>

<script>
import api from '../axios.js';
import axios from "axios";
import Chart from "chart.js/auto";

export default {
    data() {
        return { chart: null };
    },
    mounted() {
        this.fetchReport();
    },
    methods: {
        async fetchReport() {
            const response = await axios.get("clients/technology-report", {
                headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` },
            });

            this.renderChart(response.data);
        },
        renderChart(data) {
            const ctx = document.getElementById("technologyChart").getContext("2d");

            if (this.chart) this.chart.destroy();

            this.chart = new Chart(ctx, {
                type: "pie",
                data: {
                    labels: data.map(d => d.technology),
                    datasets: [{
                        label: "Interest",
                        data: data.map(d => d.total),
                        backgroundColor: ["#FF6384", "#36A2EB", "#FFCE56", "#4BC0C0"],
                    }]
                }
            });
        }
    }
};
</script>

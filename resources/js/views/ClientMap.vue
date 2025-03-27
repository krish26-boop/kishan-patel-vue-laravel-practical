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
                        <router-link to="/admin/registration-report" class="navbar-brand">Registration Report</router-link>
                    </li>
                    <li class="nav-item me-3">
                        <router-link to="/admin/technology-report" class="navbar-brand">Technology Report</router-link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2>Client Map Report</h2>

        <l-map style="height: 500px" :zoom="3" :center="[20, 0]">
            <l-tile-layer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                attribution="&copy; OpenStreetMap contributors">
            </l-tile-layer>

            <l-marker v-for="client in clients" :key="client.id" :lat-lng="parseLocation(client.location)">
                <l-popup>
                    <b>{{ client.first_name }} {{ client.last_name }}</b><br>
                    {{ client.email }}
                </l-popup>
            </l-marker>
        </l-map>
    </div>
</template>

<script>
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import "leaflet/dist/leaflet.css"; // Ensure CSS is loaded
import L from "leaflet"; // Import Leaflet
import axios from "axios";

// Fix marker icon issue in Leaflet (ES module compatible)
import markerIcon from "leaflet/dist/images/marker-icon.png";
import markerIcon2x from "leaflet/dist/images/marker-icon-2x.png";
import markerShadow from "leaflet/dist/images/marker-shadow.png";

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.mergeOptions({
    iconRetinaUrl: markerIcon2x,
    iconUrl: markerIcon,
    shadowUrl: markerShadow,
});

export default {
    components: { LMap, LTileLayer, LMarker, LPopup },
    data() {
        return {
            clients: [],
        };
    },
    mounted() {
        this.fetchClients();
    },
    methods: {
        async fetchClients() {
            const token = localStorage.getItem('token');
            const response = await axios.get("/api/admin/clients", {},
            { headers: { Authorization: `Bearer ${token}` } });

            this.clients = response.data;
            console.log(this.clients);
        },
        parseLocation(location) {
            const loc = JSON.parse(location);
            return [loc.lat, loc.lng];
        }
    }
};
</script>

<template>
    <div class="container mt-5">
        <h2>Client Map Report</h2>

        <l-map style="height: 500px" :zoom="2" :center="[20, 0]">
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
import api from '../axios.js';
import { LMap, LTileLayer, LMarker, LPopup } from "@vue-leaflet/vue-leaflet";
import axios from "axios";
import "leaflet/dist/leaflet.css"; // Ensure CSS is loaded
import L from "leaflet"; // Import Leaflet

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
            const response = await axios.get("http://localhost/kishan-patel-vue-laravel-practical/public/api/admin/clients", {
                headers: { Authorization: `Bearer ${localStorage.getItem('admin_token')}` }
            });
            this.clients = response.data;
        },
        parseLocation(location) {
            const loc = JSON.parse(location);
            return [loc.lat, loc.lng];
        }
    }
};
</script>

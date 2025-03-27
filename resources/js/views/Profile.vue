<template>
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
    <div class="container mt-5">
        <h2>Profile</h2>
        <form @submit.prevent="updateProfile">
            <div class="mb-3">
                <label>First Name:</label>
                <input type="text" v-model="profile.first_name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Last Name:</label>
                <input type="text" v-model="profile.last_name" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Email:</label>
                <input type="email" v-model="profile.email" class="form-control" required />
            </div>
            <div class="mb-3">
                <label>Phone:</label>
                <input type="text" v-model="profile.phone" class="form-control" />
            </div>

            <!-- Additional Phone Numbers -->
            <div class="mb-3">
                <label>Additional Phone Numbers:</label>
                <div v-for="(phone, index) in profile.additional_phones" :key="index" class="d-flex">
                    <input type="text" v-model="profile.additional_phones[index]" class="form-control me-2" />
                    <button type="button" class="btn btn-danger" @click="removePhone(index)">Remove</button>
                </div>
                <button type="button" class="btn btn-secondary mt-2" @click="addPhone">Add Phone</button>
            </div>

            <!-- Map Location -->
            <div class="mb-3">
                <label>Select Location:</label>
                <l-map v-model:zoom="zoom" v-model:center="center" style="height: 300px">
                    <l-tile-layer :url="tileLayer" />
                    <l-marker :lat-lng="center" draggable @moveend="updateLocation"></l-marker>
                </l-map>
            </div>

            <!-- Technology Interests -->
            <div class="mb-3">
                <label>Technology Interests:</label>
                <select v-model="profile.technology_interests" class="form-control" multiple style="height: 150px; overflow: auto;">
                    <option v-for="tech in technologies" :key="tech.id" :value="tech.id">
                        {{ tech.name }}
                    </option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
    </div>
</template>

<script>
import axios from 'axios';
import { useRouter } from 'vue-router';
import { LMap, LTileLayer, LMarker } from '@vue-leaflet/vue-leaflet';

export default {
    components: { LMap, LTileLayer, LMarker },
    data() {
        return {
            profile: {
                first_name: '',
                last_name: '',
                email: '',
                phone: '',
                additional_phones: [],
                location: '',
                technology_interests: {},
                errors:{}
            },
            technologies: {},
            zoom: 10,
            center: [40.7128, -74.0060],
            tileLayer: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        };
    },
    async created() {
        try {
            const profileResponse = await axios.get('/api/profile', {
                headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
            });
            this.profile = profileResponse.data;
            if (this.profile.location) {
                this.center = this.profile.location.split(',').map(Number);
            }

            const techResponse = await axios.get('/api/profile/gettechs', {
                headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
            });
            this.technologies = techResponse.data;
        } catch (error) {
            console.error('Error loading profile:', error);
        }
    },
    methods: {
        async updateProfile() {
              this.errors = {}; // Reset server errors

            try {
                await axios.post('/api/profile/update', this.profile, {
                    headers: { Authorization: `Bearer ${localStorage.getItem('token')}` },
                });
                alert('Profile updated successfully!');
            } catch (error) {
            if (error.response?.status === 422) {
          this.errors = error.response.data.errors;
        }
                alert('Profile update failed.');
            }
        },
        addPhone() {
            this.profile.additional_phones.push('');
        },
        removePhone(index) {
            this.profile.additional_phones.splice(index, 1);
        },
        updateLocation(event) {
            this.profile.location = `${event.latlng.lat},${event.latlng.lng}`;
        },
    },
};
</script>

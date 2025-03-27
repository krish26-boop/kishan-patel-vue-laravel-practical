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
        <h2>Admin Dashboard</h2>
        <p>Welcome, Admin!</p>
        <button @click="logout" class="btn btn-danger">Logout</button>
    </div>
</template>

<script>
import axios from "axios";
import { useRouter } from "vue-router";

export default {
    setup() {
        const router = useRouter();
        const logout = async () => {
            try {
                await axios.post(
                    "/api/admin/logout",
                    {},
                    {
                        headers: {
                            Authorization: `Bearer ${localStorage.getItem(
                                "token"
                            )}`,
                        },
                    }
                );
                localStorage.removeItem("token"); 
                localStorage.removeItem("role"); 
                router.push("/admin/login");
            } catch (error) {
                if (!localStorage.getItem("token")) {
                    router.push("/admin/login");
                } else {
                    console.log(error);
                    alert("Logout failed");
                }
            }
        };
        return { logout };
    },
};
</script>

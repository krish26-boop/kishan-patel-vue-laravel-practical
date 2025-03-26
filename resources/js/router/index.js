import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Dashboard from '../views/Dashboard.vue';
import Profile from '../views/Profile.vue';
import AdminLogin from '../views/AdminLogin.vue';
import AdminDashboard from '../views/AdminDashboard.vue';
import TechnologyManagement from '../views/TechnologyManagement.vue';
import ClientList from '../views/ClientList.vue';
import ClientMap from '../views/ClientMap.vue';
import RegistrationReport from '../views/RegistrationReport.vue';
import TechnologyReport from '../views/TechnologyReport.vue';


const routes = [
    { path: '/', component: Login },
    { path: '/register', component: Register },
    { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/profile', component: Profile, meta: { requiresAuth: true } },
    { path: '/admin/login', component: AdminLogin },
    { path: '/admin/dashboard', component: AdminDashboard, meta: { requiresAuth: true } },
    { path: '/admin/technologies', component: TechnologyManagement, meta: { requiresAuth: true } },
    { path: '/admin/clients', component: ClientList, meta: { requiresAuth: true } },
    { path: '/admin/client-map', component: ClientMap, meta: { requiresAuth: true } },
    { path: '/admin/registration-report', component: RegistrationReport, meta: { requiresAuth: true } },
    { path: '/admin/technology-report', component: TechnologyReport, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory('/kishan-patel-vue-laravel-practical/public/'),
    routes,
});

router.beforeEach((to, from, next) => {
    const adminToken = localStorage.getItem('admin_token');

    // if (to.meta.requiresAuth && !adminToken) {
    //     next('/admin/login');
    // } else {
        next();
    // }
});

export default router;

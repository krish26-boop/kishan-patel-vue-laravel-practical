import { createRouter, createWebHistory } from 'vue-router';
import Login from '../views/Login.vue';
import Register from '../views/Register.vue';
import Dashboard from '../views/Dashboard.vue';
import Profile from '../views/Profile.vue';
import AdminLogin from '../views/AdminLogin.vue';
import AdminDashboard from '../views/AdminDashboard.vue';
import TechnologyManagement from '../views/TechnologyManagement.vue';
import ClientMap from '../views/ClientMap.vue';
import RegistrationReport from '../views/RegistrationReport.vue';
import TechnologyReport from '../views/TechnologyReport.vue';


const routes = [
    { path: '/', component: Login,name: 'Login'},
    { path: '/register', component: Register },
    { path: '/dashboard', component: Dashboard, meta: { requiresAuth: true } },
    { path: '/profile', component: Profile, meta: { requiresAuth: true } },
    { path: '/admin/login', component: AdminLogin ,name:'AdminLogin' },
    { path: '/admin/dashboard', component: AdminDashboard,name:'AdminDashboard', meta: { requiresAuth: true } },
    { path: '/admin/technologies', component: TechnologyManagement, meta: { requiresAuth: true } },
    { path: '/admin/client-map', component: ClientMap, meta: { requiresAuth: true } },
    { path: '/admin/registration-report', component: RegistrationReport, meta: { requiresAuth: true } },
    { path: '/admin/technology-report', component: TechnologyReport, meta: { requiresAuth: true } },
];

const router = createRouter({
    history: createWebHistory('/kishan-patel-vue-laravel-practical/public/'),
    routes,
});

router.beforeEach((to, from, next) => {
    const token = localStorage.getItem('token');
     const role = localStorage.getItem('role');

    // if (to.meta.requiresAuth) {
    //     if (!token || role !== to.meta.role) {
    //         next({ name: role === 'admin' ? 'AdminLogin' : 'Login' });
    //     } else {
    //         next();
    //     }
    // } else {
        next();
    // }
});

export default router;

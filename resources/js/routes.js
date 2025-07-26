import Register from './views/Register.vue';
import Login from './views/Login.vue';

export default [
  {
    path: '/',
    redirect: '/login' // Otomatis arahkan ke login
  },
  {
    path: '/login',
    name: 'login',
    component: Login
  },
  {
    path: '/register',
    name: 'register',
    component: Register
  }
];
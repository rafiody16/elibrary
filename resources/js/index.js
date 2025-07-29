import { createRouter, createWebHistory } from "vue-router";
import routes from './routes';
import axios from 'axios';
import {auth} from './auth';

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('isLoggedIn');

  if (to.path === '/unauthorized') {
    localStorage.removeItem('isLoggedIn');
    auth.isAuthenticated = false;
    auth.role = '';
    next();
    return;
  }

  if (to.meta.requiresAuth && !isLoggedIn) {
    next({ name: 'login' });
  } else if (to.meta.role && auth.role !== to.meta.role) {
    localStorage.removeItem('isLoggedIn');
    auth.isAuthenticated = false;
    auth.role = '';
    next({ name: 'login' });
  } else {
    next();
  }
}); 

axios.interceptors.response.use(
  response => response,
  error => {
    if (error.response) {
        const status = error.response.status;

        if (status === 401) {
          localStorage.removeItem('isLoggedIn');
          router.push({ name:'login' })
        }

        if (status === 403) {
          localStorage.removeItem('isLoggedIn');
          auth.isAuthenticated = false;
          auth.role = '';
          router.push({ name:'login' });
        }
    }
    return Promise.reject(error);
  }
);

export default router;
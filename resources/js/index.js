import { createRouter, createWebHistory } from "vue-router";
import routes from './routes';

const router = createRouter({
    history: createWebHistory(),
    routes
});

router.beforeEach((to, from, next) => {
  const isLoggedIn = localStorage.getItem('isLoggedIn');

  if (to.meta.requiresAuth && !isLoggedIn) {
    next({ name: 'login' });
  } else {
    next();
  }
}); 

export default router;
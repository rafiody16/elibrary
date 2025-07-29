import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import Role from './components/role/Role.vue';
import Category from './components/category/Category.vue';
import Book from './components/book/Book.vue';
import Member from './components/member/Member.vue';
import Loan from './components/loan/Loan.vue';

const routes = [
  { path: '/', redirect: '/login' },
  { path: '/unauthorized', name: 'unauthorized', component: () => import('./components/auth/Login.vue')},
  { path: '/register', name: 'register', component: Register },
  { path: '/login', name: 'login', component: Login },
  { path: '/role', name: 'role', component: Role, meta: { requiresAuth: true } },
  { path: '/category', name: 'category', component: Category, meta: { requiresAuth: true } },
  { path: '/book', name: 'book', component: Book, meta: { requiresAuth: true } },
  { path: '/member', name: 'member', component: Member, meta: { requiresAuth: true, role: 'Admin' } },
  { path: '/loan', name: 'loan', component: Loan, meta: { requiresAuth: true } },
];

export default routes;



import Register from './components/auth/Register.vue';
import Login from './components/auth/Login.vue';
import Role from './components/role/Role.vue';
import Category from './components/category/Category.vue';
import Book from './components/book/Book.vue';
import Member from './components/member/Member.vue';
import Loan from './components/loan/Loan.vue';

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
  },
  {
    path: '/role',
    name: 'role',
    component: Role,
  },
  {
    path: '/category',
    name: 'category',
    component: Category,
  },
  {
    path: '/book',
    name: 'book',
    component: Book,
  },
  {
    path: '/member',
    name: 'member',
    component: Member,
  },
  {
    path: '/loan',
    name: 'loan',
    component: Loan,
  }
];
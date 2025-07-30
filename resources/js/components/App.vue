<template>
  <div class="flex min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-white">
    <!-- Sidebar -->
    <aside
      v-if="auth.isAuthenticated"
      class="w-64 h-screen bg-white border-r border-gray-200 shadow-sm"
      aria-label="Sidebar"
    >
      <div class="h-full px-4 py-6">
        <ul class="space-y-2 font-medium text-gray-700">
          <li>
            <router-link
              to="/dashboard"
              class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition"
            >
              <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M10 2a1 1 0 01.993.883L11 3v1h3a1 1 0 01.117 1.993L14 6h-3v8h3a1 1 0 01.117 1.993L14 16h-3v1a1 1 0 01-1.993.117L9 17v-1H6a1 1 0 01-.117-1.993L6 14h3V6H6a1 1 0 01-.117-1.993L6 4h3V3a1 1 0 011-1z" />
              </svg>
              <span class="ml-3">Dashboard</span>
            </router-link>
          </li>

          <li>
            <router-link
              to="/book"
              class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition"
            >
              <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M4 3a1 1 0 011-1h10a1 1 0 011 1v14a.997.997 0 01-1.555.832L10 14.118l-4.445 3.714A.997.997 0 014 17V3z" />
              </svg>
              <span class="ml-3">Books</span>
            </router-link>
          </li>

          <li v-if="auth.role === 'Admin'">
            <router-link
              to="/member"
              class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition"
            >
              <svg class="w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                <path d="M13 7a3 3 0 100-6 3 3 0 000 6zM7 7a3 3 0 100-6 3 3 0 000 6zm0 2a5 5 0 00-5 5v3h4v-3a1 1 0 011-1h2a1 1 0 011 1v3h4v-3a5 5 0 00-5-5H7z" />
              </svg>
              <span class="ml-3">Members</span>
            </router-link>
          </li>

          <li v-if="auth.role === 'Admin'">
            <router-link
              to="/category"
              class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition"
            >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
              </svg>
              <span class="ml-3">Books Category</span>
            </router-link>
          </li>

          <li v-if="auth.role === 'Admin'">
            <router-link
              to="/role"
              class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition"
            >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.982 18.725A7.488 7.488 0 0 0 12 15.75a7.488 7.488 0 0 0-5.982 2.975m11.963 0a9 9 0 1 0-11.963 0m11.963 0A8.966 8.966 0 0 1 12 21a8.966 8.966 0 0 1-5.982-2.275M15 9.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
              </svg>
              <span class="ml-3">User Category</span>
            </router-link>
          </li>

          <li v-if="auth.role === 'Admin'">
            <router-link
              to="/loan"
              class="flex items-center px-3 py-2 rounded-lg hover:bg-gray-100 transition"
            >
              <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                <path stroke-linecap="round" stroke-linejoin="round" d="M11.35 3.836c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m8.9-4.414c.376.023.75.05 1.124.08 1.131.094 1.976 1.057 1.976 2.192V16.5A2.25 2.25 0 0 1 18 18.75h-2.25m-7.5-10.5H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V18.75m-7.5-10.5h6.375c.621 0 1.125.504 1.125 1.125v9.375m-8.25-3 1.5 1.5 3-3.75" />
              </svg>
              <span class="ml-3">Loans</span>
            </router-link>
          </li>

          <li>
            <a
              href="#"
              @click.prevent="logout"
              class="flex items-center px-3 py-2 rounded-lg text-red-500 hover:bg-red-100 transition"
            >
              <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                <path
                  fill-rule="evenodd"
                  d="M3 4a1 1 0 011-1h6a1 1 0 010 2H5v10h5a1 1 0 110 2H4a1 1 0 01-1-1V4zm10.293 1.293a1 1 0 011.414 0L19 9l-4.293 4.293a1 1 0 01-1.414-1.414L15.586 10H9a1 1 0 110-2h6.586l-1.293-1.293a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                />
              </svg>
              <span class="ml-3">Logout</span>
            </a>
          </li>
        </ul>
      </div>
    </aside>

    <!-- Main content -->
    <main class="flex-1 p-6">
      <router-view />
    </main>
  </div>
</template>


<script>
import axios from 'axios';
import { auth } from '../auth';

export default {
  name: 'App',
  setup () {
    return { auth };
  },
  methods: {
    async logout() {
      try {
        await axios.post('/api/logout');
        localStorage.removeItem('isLoggedIn');
        auth.isAuthenticated = false;
        auth.role = '';
        this.$router.push({ path: '/' });
      } catch (error) {
        console.error('Logout error: ', error)
      }
    }
  }
};
</script>

<style scoped>
.app-layout {
  min-height: 100vh;
}
</style>

<template>
  <div class="app-layout d-flex">
    
    <div v-if="auth.isAuthenticated" class="d-flex flex-column flex-shrink-0 p-3 bg-light" style="width: 280px;">
      <router-link to="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        <svg class="bi me-2" width="40" height="32">
          <use xlink:href="#bootstrap" />
        </svg>
        <span class="fs-4">Sidebar</span>
      </router-link>
      <hr />

      <ul class="nav nav-pills flex-column mb-auto">
        <li>
          <router-link to="/book" class="nav-link" active-class="active" exact>
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#speedometer2" />
            </svg>
            Books
          </router-link>
        </li>
        <li>
          <router-link to="/member" class="nav-link" active-class="active" exact>
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#table" />
            </svg>
            Members
          </router-link>
        </li>
        <li>
          <router-link to="/loan" class="nav-link" active-class="active" exact>
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#grid" />
            </svg>
            Loans
          </router-link>
        </li>
        <li>
          <a href="#" @click.prevent="logout" class="nav-link">
            <svg class="bi me-2" width="16" height="16">
              <use xlink:href="#grid" />
            </svg>
            Logout
          </a>
        </li>
      </ul>

      <hr />

    
      <div class="dropdown">
        <a
          href="#"
          class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle"
          id="dropdownUser2"
          data-bs-toggle="dropdown"
          aria-expanded="false"
        >
          <img
            src="https://github.com/mdo.png"
            alt=""
            width="32"
            height="32"
            class="rounded-circle me-2"
          />
          <strong>mdo</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
          <li><a class="dropdown-item" href="#">New project...</a></li>
          <li><a class="dropdown-item" href="#">Settings</a></li>
          <li><a class="dropdown-item" href="#">Profile</a></li>
          <li><hr class="dropdown-divider" /></li>
          <li><a class="dropdown-item" href="#">Sign out</a></li>
        </ul>
      </div>
    </div>
    <!-- Main Content -->
    <div class="main-content flex-grow-1 d-flex flex-column">
      <main class="flex-grow-1 p-4">
          <router-view />
      </main>

      <footer v-if="auth.isAuthenticated" class="bg-light text-center py-3">
        <small>&copy; 2025 MyApp. All rights reserved.</small>
      </footer>
    </div>
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

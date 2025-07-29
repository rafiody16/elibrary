<template>
    <section class="vh-100 bg-light">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-body p-5">
                            <h3 class="mb-4 text-center">Login Form</h3>
                        </div>
                        <div class="card-body p-5">
                            <form v-on:submit.prevent="submitForm">
                                <!-- Email input -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="email">Email address</label>
                                    <input type="email" id="email" v-model="email" class="form-control" />
                                </div>
                            
                                <!-- Password input -->
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="password">Password</label>
                                    <input type="password" id="password" v-model="password" class="form-control" />
                                </div>
                            
                                <!-- Submit button -->
                                <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block mb-4">Sign in</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> 
</template>
<script>
import axios from 'axios';
import { auth } from '../../auth';
export default {
    data() {
        return {
            email: '',
            password: '',
            error: null,
        };
    },
    methods: {
        async submitForm() {
            try {
                await axios.get('/api/sanctum/csrf-cookie'); // wajib sebelum login

                const response = await axios.post('/api/login', {
                    email: this.email,
                    password: this.password,  
                }, {withCredentials: true});

                // Simpan status login
                localStorage.setItem('isLoggedIn', 'true');
                localStorage.setItem('userRole', response.data.user.role.name_role);
                auth.isAuthenticated = true;
                auth.role = response.data.user.role.name_role;
                
                this.$router.push({ name: 'book' });
            } catch (error) {
                this.error = 'Login failed. Please check your credentials.';
                console.error('Login error:', error);
            }
        }
    }
};
</script>
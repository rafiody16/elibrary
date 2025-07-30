<template>
    <section class="bg-gray-50 not-dark:bg-gray-300">
        <div class="flex flex-col items-center justify-center px-6 py-8 md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="font-bold text-xl leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">Log in</h1>
                    <form v-on:submit.prevent="submitForm" class="space-y-4 md:space-y-6">
                        <!-- Email input -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="email">Email address</label>
                            <input type="email" id="email" v-model="email" class="bg-gray-5 border border-gray-300 text-gray-900 rounded-lg focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required=""/>
                        </div>
                    
                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" v-model="password" class="bg-gray-5 border border-gray-300 text-gray-900 rounded-lg focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="*********" required=""/>
                        </div>
                    
                        <!-- Submit button -->
                        <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="w-full bg-blue-800 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Sign in</button>
                    </form>
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
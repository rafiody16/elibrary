<template>
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-lg-9 col-xl-7">
                    <div class="card shadow-2-strong card-registration" style="border-radius: 15px;">
                        <div class="card-body p-4 p-md-5">
                            <h3 class="mb-4 pb-2 pb-md-0 mb-md-5">Registration Form</h3>

                            <form @submit.prevent="submitForm">

                                <div class="mb-4">
                                    <label class="form-label">Name</label>
                                    <input type="text" v-model="form.name" class="form-control form-control-lg" required />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Email</label>
                                    <input type="email" v-model="form.email" class="form-control form-control-lg" required />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Password</label>
                                    <input type="password" v-model="form.password" class="form-control form-control-lg" required />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Password Confirmation</label>
                                    <input type="password" v-model="form.password_confirmation" class="form-control form-control-lg" required />
                                </div>

                                <div class="mb-4">
                                    <label class="form-label">Role</label>
                                    <select v-model="form.id_role" class="form-control-lg">
                                        <option v-for="role in roles" :value="role.id_role">
                                            {{ role.name }}
                                        </option>
                                    </select>
                                </div>

                                <div class="mt-4 pt-2">
                                    <button class="btn btn-primary btn-lg" type="submit">Register</button>
                                </div>

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

    export default {
        data() {
            return {
                form: {
                    name: '',
                    email: '',
                    password: '',
                    password_confirmation: '',
                    id_role: '',
                },

                roles: [],
                error: '',
                success: ''            
            };
        },
        mounted() {
            this.getRoles();
        },

        methods: {
            async getRoles() {
                try {
                    const response = await axios.get('/api/roles');
                    this.roles = response.data.roles;
                } catch (err) {
                    this.error = 'Failed to load roles';
                }
            },
            async submitForm() {
                try {
                    const response = await axios.post('/api/register', this.form);

                    if (response.data.success) {
                        this.success = response.data.message;
                        this.error = '';

                        this.form = {
                            name: '',
                            email: '',
                            password: '',
                            password_confirmation: '',
                            id_role: '',
                        };
                    }
                } catch (err) {
                    this.error = err.response?.data?.message || 'Registration failed';
                    this.success = '';
                }
            }
        }
    };
</script>
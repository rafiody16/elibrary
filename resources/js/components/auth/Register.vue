<template>
    <section class="vh-100 bg-light">
        <div class="container py-5 h-100">
            <div class="row justify-content-center align-items-center h-100">
                <div class="col-12 col-md-9 col-lg-7 col-xl-6">
                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-body p-5">
                
                            <h3 class="mb-4 text-center">Registration Form</h3>
                
                            <!-- Alert -->
                            <div v-if="success" class="alert alert-success" role="alert">
                                {{ success }}
                            </div>
                            <div v-if="error" class="alert alert-danger" role="alert">
                                {{ error }}
                            </div>
              
                            <form @submit.prevent="submitForm">
                                <div class="form-group mb-3">
                                    <label for="name">Name</label>
                                    <input
                                      type="text"
                                      v-model="form.name"
                                      class="form-control"
                                      id="name"
                                      required
                                    />
                                </div>
                            
                                <div class="form-group mb-3">
                                    <label for="email">Email</label>
                                    <input
                                      type="email"
                                      v-model="form.email"
                                      class="form-control"
                                      id="email"
                                      required
                                    />
                                </div>
                            
                                <div class="form-group mb-3">
                                    <label for="password">Password</label>
                                    <input
                                      type="password"
                                      v-model="form.password"
                                      class="form-control"
                                      id="password"
                                      required
                                    />
                                </div>
                            
                                <div class="form-group mb-3">
                                    <label for="password_confirmation">Password Confirmation</label>
                                    <input
                                      type="password"
                                      v-model="form.password_confirmation"
                                      class="form-control"
                                      id="password_confirmation"
                                      required
                                    />
                                </div>
                            
                                <div class="form-group mb-4">
                                    <label for="id_role">Role</label>
                                    <select
                                      v-model="form.id_role"
                                      class="form-control"
                                      id="id_role"
                                      required
                                    >
                                      <option value="" disabled>-- Pilih Role --</option>
                                      <option
                                        v-for="role in roles"
                                        :key="role.id_role"
                                        :value="role.id_role"
                                      >
                                        {{ role.name_role }}
                                      </option>
                                    </select>
                                </div>
                            
                                <button type="submit" class="btn btn-primary btn-block">
                                  Register
                                </button>
                            </form>
              
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>

<script>
import axios from "axios";

export default {
    data() {
        return {
            form: {
                name: "",
                email: "",
                password: "",
                password_confirmation: "",
                id_role: "",
            },
            roles: [],
            error: "",
            success: "",
        };
    },
    mounted() {
        this.getRoles();
    },
    methods: {
        async getRoles() {
            try {
                const response = await axios.get("/api/roles");
                this.roles = response.data.roles ?? [];
            } catch (err) {
                console.error("Gagal load roles", err);
                this.error = "Gagal mengambil data role.";
            }
        },
        async submitForm() {
            try {
                const response = await axios.post("/api/register", this.form);
                
                this.success = response.data.message || "Registrasi berhasil.";
                this.error = "";
                
                this.form = {
                    name: "",
                    email: "",
                    password: "",
                    password_confirmation: "",
                    id_role: "",
                };
            } catch (err) {
                this.error = err.response?.data?.message || "Registrasi gagal.";
                this.success = "";
            }
        },
    },
};
</script>

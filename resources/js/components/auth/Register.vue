<template>
    <section class="bg-gray-50 not-dark:bg-gray-300">
        <div class="flex flex-col items-center justify-center px-6 py-8 md:h-screen lg:py-0">
            <div class="w-full bg-white rounded-lg shadow dark:border md:mt-0 sm:max-w-md xl:p-0 dark:bg-gray-800 dark:border-gray-700">
                <div class="p-6 space-y-4 md:space-y-6 sm:p-8">
                    <h1 class="font-bold text-xl leading-tight tracking-tight text-gray-900 md:text-2xl dark:text-white">Register</h1>
                    <form v-on:submit.prevent="submitForm" class="space-y-4 md:space-y-6">
                        <!-- Fullname input -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="name">Fullname</label>
                            <input type="text" id="name" v-model="form.name" class="bg-gray-5 border border-gray-300 text-gray-900 rounded-lg focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required=""/>
                        </div>

                        <!-- Email input -->
                        <div>
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="email">Email address</label>
                            <input type="email" id="email" v-model="form.email" class="bg-gray-5 border border-gray-300 text-gray-900 rounded-lg focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="name@company.com" required=""/>
                        </div>
                        
                        <!-- Role input -->
                        <div>
                            <label for="id_role" class="block text-sm font-medium text-gray-700 m-1.5">Role</label>
                            <select id="id_role" v-model.number="form.id_role"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Choose Roles</option>
                                <option v-for="role in roles" :key="role.id_role" :value="role.id_role">
                                    {{ role.name_role }}
                                </option>
                            </select>
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password">Password</label>
                            <input type="password" id="password" v-model="form.password" class="bg-gray-5 border border-gray-300 text-gray-900 rounded-lg focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="*********" required=""/>
                        </div>

                        <!-- Password input -->
                        <div data-mdb-input-init class="form-outline mb-4">
                            <label class="form-label" for="password_confirmation">Password Confirmation</label>
                            <input type="password" id="password_confirmation" v-model="form.password_confirmation" class="bg-gray-5 border border-gray-300 text-gray-900 rounded-lg focus:border-primary-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="*********" required=""/>
                        </div>
                    
                        <!-- Submit button -->
                        <button  type="submit" data-mdb-button-init data-mdb-ripple-init class="w-full bg-blue-800 text-white bg-primary-600 hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">Register</button>
                    </form>
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
                await axios.post("/api/register", this.form);
                
                this.$router.push({ name:"login" });
            } catch (err) {
                this.error = err.response?.data?.message || "Registrasi gagal.";
                this.success = "";
            }
        },
    },
};
</script>

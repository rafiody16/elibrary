<template>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row justify-content-left align-items-left h-100">
                <div class="col-12">
                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-header bg-primary text-white text-center" style="border-radius: 15px 15px 0 0;">
                            <h3 class="mb-0">Role Management</h3>
                        </div>
                        <div class="card-body p-5">
                            <div class="d-flex justify-content-between mb-4">
                                <button class="btn btn-success" @click="addData">Add Data</button>
                            </div>
                            <div v-if="success" class="alert alert-success">{{ success }}</div>
                            <div v-if="error" class="alert alert-danger">{{ error }}</div>
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">No</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(role, index) in roles" :key="role.id_role">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ role.name_role }}</td>
                                        <td>{{ role.description }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-warning sm" @click="updateRole(role)">Edit</button>
                                                <button class="btn btn-danger sm" @click="deleteRole(role.id_role)">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="roles.length === 0">
                                        <td colspan="4" class="text-center">No roles found</td>
                                    </tr>
                                </tbody>
                            </table>
                            <RoleForm v-if="showCreateForm" :role="currentRole" @close="closeModal" @refreshRoles="getData" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import axios from 'axios';
    import RoleForm from './RoleForm.vue';

    export default {
        components: {
            RoleForm
        },
        data() {
            return {
                roles: [],
                error: null,
                success: null,
                showCreateForm: false,
                currentRole: null,
            };
        },
        methods: {
            getData() {
                this.error = null;
                this.success = null;
                axios.get('api/roles')
                    .then(response => {
                        this.roles = response.data.roles;
                    })
                    .catch(error => {
                        this.error = 'Error fetching roles';
                    });
            },
            deleteRole(roleId) {
                if (confirm('Are you sure you want to delete this role?')) {
                    axios.delete(`api/role/delete/${roleId}`)
                        .then(() => {
                            this.success = 'Role deleted successfully';
                            this.getData();
                    })
                    .catch(()=> {
                        this.error = 'Error deleting role';
                    });
                }
            },
            addData() {
                console.log("Opening modal");
                this.showCreateForm = true;
            },
            closeModal() {
                this.showCreateForm = false;
                this.currentRole = null;
            },
            updateRole(role) {
                this.currentRole = role;
                this.showCreateForm = true;
            },
        },
        mounted() {
            this.getData();
        }
    };
</script>
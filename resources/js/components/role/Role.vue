<template>
    <section class="h-min dark:bg-gray-900 py-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-x-auto">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Roles Data</h2>
                    <button @click="addData" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded text-sm">
                        Add Data
                    </button>
                </div>

                <!-- Alerts -->
                <div v-if="success" class="bg-green-100 text-green-800 px-6 py-3 text-sm">
                    {{ success }}
                </div>
                <div v-if="error" class="bg-red-100 text-red-800 px-6 py-3 text-sm">
                    {{ error }}
                </div>

                <!-- Table -->
                <table class="w-full text-sm text-left text-gray-700 dark:text-gray-300">
                    <thead class="text-xs uppercase bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300">
                        <tr>
                            <th class="px-6 py-3 text-center">No</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Description</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(role, index) in roles" :key="role.id_role"
                            class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <td class="px-6 py-3 text-center">{{ index + 1 }}</td>
                            <td class="px-6 py-3">{{ role.name_role }}</td>
                            <td class="px-6 py-3">{{ role.description }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm"
                                            @click="updateRole(role)">
                                        Edit
                                    </button>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                            @click="deleteRole(role.id_role)">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="roles.length === 0">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <RoleForm v-if="showCreateForm" :role="currentRole" @close="closeModal" @refreshRoles="getData" />
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
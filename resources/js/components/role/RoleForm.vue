<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-200/75 bg-opacity-100">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl mx-4 my-10">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold">{{ form.id_role ? 'Edit Role' : 'Create Role' }}</h2>
                <button class="text-gray-500 hover:text-gray-800" @click="closeModal">&times;</button>
            </div>

            <div class="px-6 py-4">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label for="name_role" class="block text-sm font-medium text-gray-700 dark:text-white m-1.5">Category</label>
                        <input type="text" id="name_role" v-model="form.name_role"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter Category Role" required/>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 m-1.5">Description</label>
                        <textarea id="description" v-model="form.description" rows="3"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    </div>

                    <div v-if="error" class="text-red-600">{{ error }}</div>

                    <div class="flex justify-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ form.id_role ? 'Update' : 'Create' }}
                        </button>
                        <button type="button" class="px-4 py-2 bg-gray-200 rounded-md hover:bg-gray-300" @click="closeModal">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>
    import axios from 'axios';

    export default {
        props: {
            role: {
                type: Object,
                default: () => null
            }
        },
        data() {
            return {
                form: {
                    name_role: '',
                    description: '',
                },
                error: null,
                success: null,
            };
        },
        watch: {
            role: {
                immediate: true,
                deep: true,
                handler(newVal) {
                    if (newVal) {
                        this.form = {
                            id_role: newVal.id_role || null,
                            name_role: newVal.name_role || '',
                            description: newVal.description || '',
                        }
                    } else {
                        this.resetForm();
                    }
                }
            },
        },
        methods: {
            submitForm() {
                this.error = null;
                this.success = null;

                const payload = {
                    name_role: this.form.name_role,
                    description: this.form.description,
                }

                let request;
                if (this.role && this.role.id_role) {
                    request = axios.put(`/api/role/update/${this.role.id_role}`, payload);
                } else {
                    request = axios.post('/api/role/create', payload);
                }

                request.then(() => {
                    this.$emit('refreshRoles');
                    this.closeModal();
                })
                .catch(error => {
                    if (error.response && error.response.data) {
                        this.error = error.response.data.message || 'An error occurred while creating the role.';
                    } else {
                        this.error = 'An unexpected error occurred.';
                    }
                });

            },
            closeModal() {
                this.resetForm();
                this.$emit('close');
            },
            resetForm() {
                this.form = {
                    id_role: null,
                    name_role: '',
                    description: '',
                };
                this.error = null;
                this.success = null;
            }
        }
    }
</script>
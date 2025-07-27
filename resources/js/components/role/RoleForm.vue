<template>
    <div class="modal-backdrop" style="position: fixed; background-color: rgba(0, 0, 0, 0.5); z-index: 1050;">
        <div class="modal d-block" tabindex="-1" style="z-index: 1060;">
            <div class="modal-dialog" style="max-width: 500px; margin: auto; top: 20%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Role</h5>
                        <button type="button" class="btn-close" @click="$emit('close')"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="name_role" class="form-label">Role Name</label>
                                <input type="text" v-model="form.name_role" class="form-control" id="name_role" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea v-model="form.description" id="description" class="form-control"></textarea>
                            </div>
                            <div v-if="error" class="alert alert-danger">{{ error }}</div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">{{form.id_role ? 'Update' : 'Create'}}</button>
                                <button type="button" class="btn btn-secondary ms-2" @click="$emit('close')">Cancel</button>
                            </div>
                        </form>       
                    </div>
                </div>
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
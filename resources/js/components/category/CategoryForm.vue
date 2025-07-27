<template>
    <div class="modal-backdrop" style="position: fixed; background-color: rgba(0, 0, 0, 0.5); z-index: 1050;">
        <div class="modal d-block" tabindex="-1" style="z-index: 1060;">
            <div class="modal-dialog" style="max-width: 500px; margin: auto; top: 20%;">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create Category</h5>
                        <button type="button" class="btn-close" @click="$emit('close')"></button>
                    </div>
                    <div class="modal-body">
                        <form @submit.prevent="submitForm">
                            <div class="mb-3">
                                <label for="name_category" class="form-label">Category Name</label>
                                <input type="text" v-model="form.name_category" class="form-control" id="name_category" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea v-model="form.description" id="description" class="form-control"></textarea>
                            </div>
                            <div v-if="error" class="alert alert-danger">{{ error }}</div>
                            <div class="d-flex justify-content-end gap-2">
                                <button type="submit" class="btn btn-primary">{{form.id_category ? 'Update' : 'Create'}}</button>
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
            category: {
                type: Object,
                default: () => null
            }
        },
        data() {
            return {
                form: {
                    name_category: '',
                    description: '',
                },
                error: null,
                success: null,
            };
        },
        watch: {
            category: {
                immediate: true,
                deep: true,
                handler(newVal) {
                    if (newVal) {
                        this.form = {
                            id_category: newVal.id_category || null,
                            name_category: newVal.name_category || '',
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
                    name_category: this.form.name_category,
                    description: this.form.description,
                }

                let request;
                if (this.category && this.category.id_category) {
                    request = axios.put(`/api/category/update/${this.category.id_category}`, payload);
                } else {
                    request = axios.post('/api/category/create', payload);
                }

                request.then(() => {
                    this.$emit('refreshCategories');
                    this.closeModal();
                })
                .catch(error => {
                    if (error.response && error.response.data) {
                        this.error = error.response.data.message || 'An error occurred while creating the category.';
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
                    id_category: null,
                    name_category: '',
                    description: '',
                };
                this.error = null;
                this.success = null;
            }
        }
    }
</script>
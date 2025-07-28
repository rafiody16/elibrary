<template>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row justify-content-left align-items-left h-100">
                <div class="col-12">
                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-header bg-primary text-white text-center" style="border-radius: 15px 15px 0 0;">
                            <h3 class="mb-0">Category Data</h3>
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
                                    <tr v-for="(category, index) in categories" :key="category.id_category">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ category.name_category }}</td>
                                        <td>{{ category.description }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-warning sm" @click="updateCategory(category)">Edit</button>
                                                <button class="btn btn-danger sm" @click="deleteCategory(category.id_category)">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="categories.length === 0">
                                        <td colspan="4" class="text-center">No categorys found</td>
                                    </tr>
                                </tbody>
                            </table>
                            <CategoryForm v-if="showCreateForm" :category="currentCategory" @close="closeModal" @refreshCategories="getData" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import axios from 'axios';
    import CategoryForm from './CategoryForm.vue';

    export default {
        components: {
            CategoryForm
        },
        data() {
            return {
                categories: [],
                error: null,
                success: null,
                showCreateForm: false,
                currentCategory: null,
            };
        },
        methods: {
            getData() {
                this.error = null;
                this.success = null;
                axios.get('api/categories')
                    .then(response => {
                        this.categories = response.data.categories;
                    })
                    .catch(error => {
                        this.error = 'Error fetching categories';
                    });
            },
            deleteCategory(categoryId) {
                if (confirm('Are you sure you want to delete this category?')) {
                    axios.delete(`api/category/delete/${categoryId}`)
                        .then(() => {
                            this.success = 'category deleted successfully';
                            this.getData();
                    })
                    .catch(()=> {
                        this.error = 'Error deleting category';
                    });
                }
            },
            addData() {
                console.log("Opening modal");
                this.showCreateForm = true;
            },
            closeModal() {
                this.showCreateForm = false;
                this.currentCategory = null;
            },
            updateCategory(category) {
                this.currentCategory = category;
                this.showCreateForm = true;
            },
        },
        mounted() {
            this.getData();
        }
    };
</script>
<template>
    <section class="h-min dark:bg-gray-900 py-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-x-auto">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Categories Data</h2>
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
                        <tr v-for="(category, index) in categories" :key="category.id_category"
                            class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <td class="px-6 py-3 text-center">{{ index + 1 }}</td>
                            <td class="px-6 py-3">{{ category.name_category }}</td>
                            <td class="px-6 py-3">{{ category.description }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm"
                                            @click="updateCategory(category)">
                                        Edit
                                    </button>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                            @click="deleteCategory(category.id_category)">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="categories.length === 0">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No categories found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <CategoryForm v-if="showCreateForm" :category="currentCategory" @close="closeModal" @refreshCategories="getData" />
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
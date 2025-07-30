<template>
    <div class="fixed inset-0 z-50 flex pt-20 items-center justify-center bg-gray-200/75 bg-opacity-100 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl mx-4 my-10">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold">{{ form.id_book ? 'Edit Book' : 'Create Book' }}</h2>
                <button class="text-gray-500 hover:text-gray-800" @click="closeModal">&times;</button>
            </div>

            <div class="px-6 py-4">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div class="mb-6">
                        <label for="name_book" class="block text-sm font-medium text-gray-700 dark:text-white m-1.5">Title</label>
                        <input type="text" id="name_book" v-model="form.name_book"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Title Books" required/>
                    </div>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="author" class="block text-sm font-medium text-gray-700 m-1.5">Author</label>
                            <input type="text" id="author" v-model="form.author"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="Author Name" required/>
                        </div>
                        <div>
                            <label for="publisher" class="block text-sm font-medium text-gray-700 m-1.5">Publisher</label>
                            <input type="text" id="publisher" v-model="form.publisher"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="Publisher Name" required/>
                        </div>
                    </div>

                    <div>
                        <label for="publication_date" class="block text-sm font-medium text-gray-700 m-1.5">Publication Date</label>
                        <input type="date" id="publication_date" v-model="form.publication_date"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            required/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="id_category" class="block text-sm font-medium text-gray-700 m-1.5">Category</label>
                            <select id="id_category" v-model.number="form.id_category"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Pilih kategori</option>
                                <option v-for="category in categories" :key="category.id_category" :value="category.id_category">
                                    {{ category.name_category }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label for="stock" class="block text-sm font-medium text-gray-700 m-1.5">Stock</label>
                            <input type="number" id="stock" v-model="form.stock"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                    </div>

                    <div>
                        <label for="cover_book" class="block text-sm font-medium text-gray-700 m-1.5">Cover</label>
                        <input type="file" id="cover_book" @change="handleFileUpload"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 m-1.5">Description</label>
                        <textarea id="description" v-model="form.description" rows="3"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                    </div>

                    <div v-if="error" class="text-red-600">{{ error }}</div>

                    <div class="flex justify-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ form.id_book ? 'Update' : 'Create' }}
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
        book: {
            type: Object,
            default: () => null
        }
    },
    data() {
        return {
            form: {
                id_book: null,
                name_book: '',
                author: '',
                publisher: '',
                publication_date: '',
                id_category: null,
                cover_book: null,
                description: '',
                stock: 0,
            },
            error: null,
            categories: [],
        };
    },
    watch: {
        book: {
            immediate: true,
            deep: true,
            handler(newVal) {
                if (newVal) {
                    this.form = {
                        id_book: newVal.id_book || null,
                        name_book: newVal.name_book || '',
                        author: newVal.author || '',
                        publisher: newVal.publisher || '',
                        publication_date: newVal.publication_date || '',
                        id_category: newVal.id_category || '',
                        cover_book: null,
                        description: newVal.description || '',
                        stock: newVal.stock || 0,
                    };
                } else {
                    this.resetForm();
                }
            }
        },
    },
    mounted() {
        this.getCategories();
    },
    methods: {
        submitForm() {
            this.error = null;

            const formData = new FormData();
            formData.append('name_book', this.form.name_book);
            formData.append('author', this.form.author);
            formData.append('publisher', this.form.publisher);
            formData.append('publication_date', this.form.publication_date);
            formData.append('id_category', parseInt(this.form.id_category));
            formData.append('description', this.form.description);
            formData.append('stock', parseInt(this.form.stock));
            if (this.form.cover_book) {
                formData.append('cover_book', this.form.cover_book);
            }

            let request;
            if (this.form.id_book) {
                // mode update: pakai POST dengan method override
                formData.append('_method', 'PUT');
                request = axios.post(`/api/book/update/${this.form.id_book}`, formData);
            } else {
                // mode create: langsung POST
                request = axios.post('/api/book/create', formData);
            }

            request.then(() => {
                this.$emit('refreshBooks');
                this.closeModal();
            }).catch(error => {
                this.error = error.response?.data?.message || 'An error occurred.';
            });
        },
        handleFileUpload(event) {
            this.form.cover_book = event.target.files[0];
        },
        closeModal() {
            this.resetForm();
            this.$emit('close');
        },
        resetForm() {
            this.form = {
                id_book: null,
                name_book: '',
                author: '',
                publisher: '',
                publication_date: '',
                id_category: '',
                cover_book: null,
                description: '',
                stock: 0,
            };
            this.error = null;
        },
        getCategories() {
            axios.get('/api/categories')
                .then(res => this.categories = res.data.categories || [])
                .catch(() => this.error = 'Failed to load categories.');
        }
    }
};
</script>

<style scoped>
.modal {
    overflow-y: auto;
}
</style>

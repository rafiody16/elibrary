<template>
    <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">{{ form.id_book ? 'Edit Book' : 'Create Book' }}</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="name_book" class="form-label">Title</label>
                            <input type="text" class="form-control" v-model="form.name_book" id="name_book" placeholder="Enter book title">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="author" class="form-label">Author</label>
                                <input type="text" class="form-control" v-model="form.author" id="author" placeholder="Enter author name">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="publisher" class="form-label">Publisher</label>
                                <input type="text" class="form-control" v-model="form.publisher" id="publisher" placeholder="Enter publisher name">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="publication_date" class="form-label">Publication Date</label>
                            <input type="date" class="form-control" v-model="form.publication_date" id="publication_date" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="id_category" class="form-label">Category</label>
                                <select id="id_category" class="form-control" v-model.number="form.id_category">
                                    <option value="" disabled>Choose Categories</option>
                                    <option v-for="category in categories" :key="category.id_category" :value="category.id_category">
                                        {{ category.name_category }}
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="stock" class="form-label">Stock</label>
                                <input type="number" class="form-control" id="stock" v-model="form.stock" placeholder="Enter Book Stock">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cover_book" class="form-label">Cover Book</label>
                            <input type="file" class="form-control" @change="handleFileUpload" id="cover_book">
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" v-model="form.description" id="description" rows="3"></textarea>
                        </div>

                        <div v-if="error" class="alert alert-danger">{{ error }}</div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ form.id_book ? 'Update' : 'Create' }}
                            </button>
                            <button type="button" class="btn btn-secondary" @click="closeModal">Cancel</button>
                        </div>
                    </form>
                </div>
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

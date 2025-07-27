<template>
    <section class="vh-100 bg-light">
        <div class="container py-5 h-100">
            <div class="row justify-content-left align-items-left h-100">
                <div class="col-12">
                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-header bg-primary text-white text-center" style="border-radius: 15px 15px 0 0;">
                            <h3 class="mb-0">Books Data</h3>
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
                                        <th scope="col">Cover</th>
                                        <th scope="col">Title</th>
                                        <th scope="col">Author</th>
                                        <th scope="col">Publisher</th>
                                        <th scope="col">Publication Date</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(book, index) in books" :key="book.id_book">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <img :src="`/storage/${book.cover_book}`" alt="Book Cover" class="img-thumbnail" style="width: 100px; height: auto;">
                                        </td>
                                        <td>{{ book.name_book }}</td>
                                        <td>{{ book.author }}</td>
                                        <td>{{ book.publisher }}</td>
                                        <td>{{ book.publication_date }}</td>
                                        <td>{{ book.stock }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-warning sm" @click="updateBook(book)">Edit</button>
                                                <button class="btn btn-danger sm" @click="deleteBook(book.id_book)">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="books.length === 0">
                                        <td colspan="4" class="text-center">No books found</td>
                                    </tr>
                                </tbody>
                            </table>
                            <BookForm v-if="showCreateForm" :book="currentBook" @close="closeModal" @refreshBooks="getData" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import axios from 'axios';
    import BookForm from './BookForm.vue';

    export default {
        components: {
            BookForm
        },
        data() {
            return {
                books: [],
                error: null,
                success: null,
                showCreateForm: false,
                currentBook: null,
            };
        },
        methods: {
            getData() {
                this.error = null;
                this.success = null;
                axios.get('api/books')
                    .then(response => {
                        this.books = response.data.books;
                    })
                    .catch(error => {
                        this.error = 'Error fetching books';
                    });
            },
            deleteBook(bookId) {
                if (confirm('Are you sure you want to delete this book?')) {
                    axios.delete(`api/book/delete/${bookId}`)
                        .then(() => {
                            this.success = 'book deleted successfully';
                            this.getData();
                    })
                    .catch(()=> {
                        this.error = 'Error deleting book';
                    });
                }
            },
            addData() {
                console.log("Opening modal");
                this.showCreateForm = true;
            },
            closeModal() {
                this.showCreateForm = false;
                this.currentBook= null;
            },
            updateBook(book) {
                this.currentBook = book;
                this.showCreateForm = true;
            },
        },
        mounted() {
            this.getData();
        }
    };
</script>
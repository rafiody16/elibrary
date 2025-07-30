<template>
    <section class="h-min dark:bg-gray-900 py-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-x-auto">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Books Data</h2>
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
                            <th class="px-6 py-3">Cover</th>
                            <th class="px-6 py-3">Title</th>
                            <th class="px-6 py-3">Author</th>
                            <th class="px-6 py-3">Publisher</th>
                            <th class="px-6 py-3">Publication Date</th>
                            <th class="px-6 py-3 text-center">Stock</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(book, index) in books" :key="book.id_book"
                            class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <td class="px-6 py-3 text-center">{{ index + 1 }}</td>
                            <td class="px-6 py-3">
                                <img :src="`/storage/${book.cover_book}`" alt="Cover" class="w-20 h-auto rounded">
                            </td>
                            <td class="px-6 py-3">{{ book.name_book }}</td>
                            <td class="px-6 py-3">{{ book.author }}</td>
                            <td class="px-6 py-3">{{ book.publisher }}</td>
                            <td class="px-6 py-3">{{ book.publication_date }}</td>
                            <td class="px-6 py-3 text-center">{{ book.stock }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm"
                                            @click="updateBook(book)">
                                        Edit
                                    </button>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                            @click="deleteBook(book.id_book)">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="books.length === 0">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No books found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <BookForm v-if="showCreateForm" :book="currentBook" @close="closeModal" @refreshBooks="getData" />
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
        .catch(() => {
          this.error = 'Error fetching books';
        });
    },
    deleteBook(bookId) {
      if (confirm('Are you sure you want to delete this book?')) {
        axios.delete(`api/book/delete/${bookId}`)
          .then(() => {
            this.success = 'Book deleted successfully';
            this.getData();
          })
          .catch(() => {
            this.error = 'Error deleting book';
          });
      }
    },
    addData() {
      this.showCreateForm = true;
    },
    closeModal() {
      this.showCreateForm = false;
      this.currentBook = null;
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

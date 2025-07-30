<template>
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-gray-200/75 bg-opacity-100">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl mx-4 my-10">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold">{{ form.id_loan ? 'Edit Loan' : 'Create Loan' }}</h2>
                <button class="text-gray-500 hover:text-gray-800" @click="closeModal">&times;</button>
            </div>

            <div class="px-6 py-4">
                <form @submit.prevent="submitForm" class="space-y-4">

                    <div>
                        <label for="id_book" class="block text-sm font-medium text-gray-700 m-1.5">Books</label>
                        <select id="id_book" v-model.number="form.id_book"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled>Choose Books</option>
                            <option v-for="book in filteredBooks" :key="book.id_book" :value="book.id_book">
                                {{ book.name_book }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="id_member" class="block text-sm font-medium text-gray-700 m-1.5">Members</label>
                        <select id="id_member" v-model.number="form.id_member"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            <option value="" disabled>Choose Members</option>
                            <option v-for="member in members" :key="member.id_member" :value="member.id_member">
                                {{ member.name_member }}
                            </option>
                        </select>
                    </div>

                    <div>
                        <label for="loan_date" class="block text-sm font-medium text-gray-700 dark:text-white m-1.5">Category</label>
                        <input type="date" id="loan_date" v-model="form.loan_date"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required/>
                    </div>

                    <div v-if="error" class="text-red-600">{{ error }}</div>

                    <div class="flex justify-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ form.id_loan ? 'Update' : 'Create' }}
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
        loans: {
            type: Object,
            default: () => null
        }
    },
    data() {
        return {
            form: {
                id_loan: null,
                id_member: null,
                id_book: null,
                loan_date: null,
            },
            error: null,
            members: [],
            books: [],
        };
    },
    watch: {
        loan: {
            immediate: true,
            deep: true,
            handler(newVal) {
                if (newVal) {
                    this.form = {
                        id_loan: newVal.id_loan || null,
                        id_member: newVal.id_member || null,
                        id_book: newVal.id_book || null,
                        loan_date: newVal.loan_date || null,
                    };
                } else {
                    this.resetForm();
                }
            }
        },
    },
    mounted() {
        this.getMembers();
        this.getBooks();
    },
    computed: {
        filteredBooks() {
            if (this.form.id_loan) {
                return this.books.filter( book => book.id_book !== this.form.id_book)
            }
            return this.books;
        }
    },
    methods: {
        submitForm() {
            this.error = null;

            const formData = new FormData();
            formData.append('id_member', parseInt(this.form.id_member));
            formData.append('id_book', parseInt(this.form.id_book));
            formData.append('loan_date', this.form.loan_date);

            let request;
            if (this.form.id_loan) {
                // mode update: pakai POST dengan method override
                formData.append('_method', 'PUT');
                request = axios.post(`/api/loan/update/${this.form.id_loan}`, formData);
            } else {
                // mode create: langsung POST
                request = axios.post('/api/loan/create', formData);
            }

            request.then(() => {
                this.$emit('refreshLoans');
                this.closeModal();
            }).catch(error => {
                this.error = error.response?.data?.message || 'An error occurred.';
            });
        },
        closeModal() {
            this.resetForm();
            this.$emit('close');
        },
        resetForm() {
            this.form = {
                id_loan: null,
                id_member: null,
                id_book: null,
                loan_date: null,
            };
            this.error = null;
        },
        getMembers() {
            axios.get('/api/members')
                .then(res => this.members = res.data.members || [])
                .catch(() => this.error = 'Failed to load members.');
        },
        getBooks() {
            axios.get('/api/books')
                .then(res => this.books = res.data.books || [])
                .catch(() => this.error = 'Failed to load books.');
        }
    }
};
</script>

<style scoped>
.modal {
    overflow-y: auto;
}
</style>

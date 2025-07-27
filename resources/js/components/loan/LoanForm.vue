<template>
    <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">{{ form.id_loan ? 'Edit Loan' : 'Create Loan' }}</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="id_member" class="form-label">Borrower</label>
                            <select id="id_member" class="form-control" v-model.number="form.id_member">
                                <option value="" disabled>Choose Member</option>
                                <option v-for="member in members" :key="member.id_member" :value="member.id_member">
                                    {{ member.name_member }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="id_book" class="form-label">Book</label>
                            <select id="id_book" class="form-control" v-model.number="form.id_book">
                                <option value="" disabled>Choose Member</option>
                                <option v-for="book in books" :key="book.id_book" :value="book.id_book">
                                    {{ book.name_book }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="loan_date" class="form-label">Loan Date</label>
                            <input type="date" class="form-control" v-model="form.loan_date" id="loan_date" required>

                        </div>

                        <div v-if="error" class="alert alert-danger">{{ error }}</div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ form.id_loan ? 'Update' : 'Create' }}
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

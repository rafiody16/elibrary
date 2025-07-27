<template>
    <section class="vh-100 bg-light">
        <div class="container py-5 h-100">
            <div class="row justify-content-left align-items-left h-100">
                <div class="col-12">
                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-header bg-primary text-white text-center" style="border-radius: 15px 15px 0 0;">
                            <h3 class="mb-0">Loans Data</h3>
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
                                        <th scope="col">Book</th>
                                        <th scope="col">Borrower</th>
                                        <th scope="col">Loan Date</th>
                                        <th scope="col">Due Date</th>
                                        <th scope="col">Return Date</th>
                                        <th scope="col">Status</th>
                                        <th scope="col">Fine</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(loan, index) in loans" :key="loan.id_loan">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ loan.book.name_book }}</td>
                                        <td>{{ loan.member.name_member }}</td>
                                        <td>{{ loan.loan_date }}</td>
                                        <td>{{ loan.due_date }}</td>
                                        <td>{{ loan.return_date ?? '-' }}</td>
                                        <td>{{ loan.status }}</td>
                                        <td>{{ loan.fine  ?? '-' }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-warning sm" @click="updateLoan(loan)">Edit</button>
                                                <button class="btn btn-danger sm" @click="deleteLoan(loan.id_loan)">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="loans.length === 0">
                                        <td colspan="9" class="text-center">No Loans found</td>
                                    </tr>
                                </tbody>
                            </table>
                            <LoanForm v-if="showCreateForm" :loan="currentLoan" @close="closeModal" @refreshLoans="getData" />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>
    import axios from 'axios';
    import LoanForm from './LoanForm.vue';

    export default {
        components: {
            LoanForm
        },
        data() {
            return {
                loans: [],
                error: null,
                success: null,
                showCreateForm: false,
                currentLoan: null,
            };
        },
        methods: {
            getData() {
                this.error = null;
                this.success = null;
                axios.get('api/loans')
                    .then(response => {
                        this.loans = response.data.loans;
                    })
                    .catch(error => {
                        this.error = 'Error fetching loans';
                    });
            },
            deleteLoan(loanId) {
                if (confirm('Are you sure you want to delete this loan?')) {
                    axios.delete(`api/loan/delete/${loanId}`)
                        .then(() => {
                            this.success = 'loan deleted successfully';
                            this.getData();
                    })
                    .catch(()=> {
                        this.error = 'Error deleting loan';
                    });
                }
            },
            addData() {
                console.log("Opening modal");
                this.showCreateForm = true;
            },
            closeModal() {
                this.showCreateForm = false;
                this.currentLoan = null;
            },
            updateLoan(loan) {
                this.currentLoan = loan;
                this.showCreateForm = true;
            },
        },
        mounted() {
            this.getData();
        }
    };
</script>
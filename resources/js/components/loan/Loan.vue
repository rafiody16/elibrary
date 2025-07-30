<template>
    <section class="h-min dark:bg-gray-900 py-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-x-auto">
                <!-- Header -->
                <div class="flex items-center justify-between px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">Members Data</h2>
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
                            <th class="px-6 py-3">Book</th>
                            <th class="px-6 py-3">Borrower</th>
                            <th class="px-6 py-3">Loan Date</th>
                            <th class="px-6 py-3">Due Date</th>
                            <th class="px-6 py-3">Return Date</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3">Fine</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(loan, index) in loans" :key="loan.id_loan"
                            class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <td class="px-6 py-3 text-center">{{ index + 1 }}</td>
                            <td class="px-6 py-3">{{ loan.book.name_book }}</td>
                            <td class="px-6 py-3">{{ loan.member.name_member }}</td>
                            <td class="px-6 py-3">{{ loan.loan_date }}</td>
                            <td class="px-6 py-3">{{ loan.due_date }}</td>
                            <td class="px-6 py-3">{{ loan.return_date ?? '-' }}</td>
                            <td class="px-6 py-3">{{ loan.status }}</td>
                            <td class="px-6 py-3">{{ loan.fine  ?? '-' }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm"
                                            @click="updateLoan(loan)">
                                        Edit
                                    </button>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                            @click="deleteLoan(loan.id_loan)">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="loans.length === 0">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No loans found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <LoanForm v-if="showCreateForm" :loan="currentLoan" @close="closeModal" @refreshLoans="getData" />
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
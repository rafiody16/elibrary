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
                            <th class="px-6 py-3">Photo</th>
                            <th class="px-6 py-3">Name</th>
                            <th class="px-6 py-3">Address</th>
                            <th class="px-6 py-3">Place & Date of Birth</th>
                            <th class="px-6 py-3">Phone Number</th>
                            <th class="px-6 py-3">Job</th>
                            <th class="px-6 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(member, index) in members" :key="member.id_member"
                            class="bg-white dark:bg-gray-800 hover:bg-gray-100 dark:hover:bg-gray-700 border-b border-gray-200 dark:border-gray-600">
                            <td class="px-6 py-3 text-center">{{ index + 1 }}</td>
                            <td class="px-6 py-3">
                                <img :src="`/storage/${member.photo_member}`" alt="Photo Member" class="w-20 h-auto rounded">
                            </td>
                            <td class="px-6 py-3">{{ member.name_member }}</td>
                            <td class="px-6 py-3">{{ member.address }}</td>
                            <td class="px-6 py-3">{{ member.place_of_birth }}, {{ member.date_of_birth }}</td>
                            <td class="px-6 py-3">{{ member.phone_number }}</td>
                            <td class="px-6 py-3">{{ member.job }}</td>
                            <td class="px-6 py-3 text-center">
                                <div class="flex justify-center gap-2">
                                    <button class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded text-sm"
                                            @click="updateMember(member)">
                                        Edit
                                    </button>
                                    <button class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm"
                                            @click="deleteMember(member.id_member)">
                                        Delete
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr v-if="members.length === 0">
                            <td colspan="8" class="px-6 py-4 text-center text-gray-500">No members found.</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Modal -->
            <MemberForm v-if="showCreateForm" :member="currentMember" @close="closeModal" @refreshMembers="getData" />
        </div>
    </section>
</template>
<script>
    import axios from 'axios';
    import MemberForm from './MemberForm.vue';

    export default {
        components: {
            MemberForm
        },
        data() {
            return {
                members: [],
                error: null,
                success: null,
                showCreateForm: false,
                currentMember: null,
            };
        },
        methods: {
            getData() {
                this.error = null;
                this.success = null;
                axios.get('api/members')
                    .then(response => {
                        this.members = response.data.members;
                    })
                    .catch(error => {
                        this.error = 'Error fetching members';
                    });
            },
            deleteMember(memberId) {
                if (confirm('Are you sure you want to delete this member?')) {
                    axios.delete(`api/member/delete/${memberId}`)
                        .then(() => {
                            this.success = 'member deleted successfully';
                            this.getData();
                    })
                    .catch(()=> {
                        this.error = 'Error deleting member';
                    });
                }
            },
            addData() {
                console.log("Opening modal");
                this.showCreateForm = true;
            },
            closeModal() {
                this.showCreateForm = false;
                this.currentMember= null;
            },
            updateMember(member) {
                this.currentMember = member;
                this.showCreateForm = true;
            },
        },
        mounted() {
            this.getData();
        }
    };
</script>
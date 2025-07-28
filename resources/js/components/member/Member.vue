<template>
    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row justify-content-left align-items-left h-100">
                <div class="col-12">
                    <div class="card shadow-lg" style="border-radius: 15px;">
                        <div class="card-header bg-primary text-white text-center" style="border-radius: 15px 15px 0 0;">
                            <h3 class="mb-0">Members Data</h3>
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
                                        <th scope="col">Photo</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Address</th>
                                        <th scope="col">Place & Date of Birth</th>
                                        <th scope="col">Phone Number</th>
                                        <th scope="col">Job</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(member, index) in members" :key="member.id_member">
                                        <td>{{ index + 1 }}</td>
                                        <td>
                                            <img :src="`/storage/${member.photo_member}`" alt="Photo Member" class="img-thumbnail" style="width: 100px; height: auto;">
                                        </td>
                                        <td>{{ member.name_member }}</td>
                                        <td>{{ member.address }}</td>
                                        <td>{{ member.place_of_birth }}, {{ member.date_of_birth }}</td>
                                        <td>{{ member.phone_number }}</td>
                                        <td>{{ member.job }}</td>
                                        <td>
                                            <div class="d-flex gap-2">
                                                <button class="btn btn-warning sm" @click="updateMember(member)">Edit</button>
                                                <button class="btn btn-danger sm" @click="deleteMember(member.id_member)">Delete</button>
                                            </div>
                                        </td>
                                    </tr>
                                    <tr v-if="members.length === 0">
                                        <td colspan="4" class="text-center">No members found</td>
                                    </tr>
                                </tbody>
                            </table>
                            <MemberForm v-if="showCreateForm" :member="currentMember" @close="closeModal" @refreshMembers="getData" />
                        </div>
                    </div>
                </div>
            </div>
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
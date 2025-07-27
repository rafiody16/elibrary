<template>
    <div class="modal fade show d-block" style="background-color: rgba(0,0,0,0.5);">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header">
                    <h5 class="modal-title">{{ form.id_member ? 'Edit Member' : 'Create Member' }}</h5>
                    <button type="button" class="btn-close" @click="closeModal"></button>
                </div>
                <div class="modal-body">
                    <form @submit.prevent="submitForm">
                        <div class="mb-3">
                            <label for="name_member" class="form-label">Fullname</label>
                            <input type="text" class="form-control" v-model="form.name_member" id="name_member" placeholder="Enter name member">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="place_of_birth" class="form-label">Place Of Birth</label>
                                <input type="text" class="form-control" v-model="form.place_of_birth" id="place_of_birth" placeholder="Enter Place of Birth">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="date_of_birth" class="form-label">Date Of Birth</label>
                                <input type="date" class="form-control" v-model="form.date_of_birth" id="date_of_birth">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" v-model="form.address" id="address" placeholder="Enter Address" required>
                        </div>

                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" v-model="form.phone_number" id="phone_number" placeholder="Enter Phone Number" required>
                        </div>

                        <div class="mb-3">
                            <label for="job" class="form-label">Job</label>
                            <input type="text" class="form-control" v-model="form.job" id="job" placeholder="Enter Job Name" required>
                        </div>

                        <div class="mb-3">
                            <label for="id_user" class="form-label">Account User</label>
                            <select id="id_user" class="form-control" v-model.number="form.id_user">
                                <option value="" disabled>Choose User</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label for="photo_member" class="form-label">Photo Member</label>
                            <input type="file" class="form-control" @change="handleFileUpload" id="photo_member">
                        </div>

                        <div v-if="error" class="alert alert-danger">{{ error }}</div>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="submit" class="btn btn-primary">
                                {{ form.id_member ? 'Update' : 'Create' }}
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
        member: {
            type: Object,
            default: () => null
        }
    },
    data() {
        return {
            form: {
                id_member: null,
                id_user: null,
                name_member: '',
                photo_member: null,
                address: '',
                place_of_birth: '',
                date_of_birth: null,
                phone_number: '',
                job: '',
            },
            error: null,
            users: [],
        };
    },
    watch: {
        member: {
            immediate: true,
            deep: true,
            handler(newVal) {
                if (newVal) {
                    this.form = {
                        id_member: newVal.id_member || null,
                        id_user: newVal.id_user || null,
                        name_member: newVal.name_member || '',
                        photo_member: null,
                        address: newVal.address || '',
                        place_of_birth: newVal.place_of_birth || '',
                        date_of_birth: newVal.date_of_birth || null,
                        phone_number: newVal.phone_number || '',
                        job: newVal.job || '',
                    };
                } else {
                    this.resetForm();
                }
            }
        },
    },
    mounted() {
        this.getUsers();
    },
    methods: {
        submitForm() {
            this.error = null;

            const formData = new FormData();
            formData.append('name_member', this.form.name_member);
            formData.append('address', this.form.address);
            formData.append('place_of_birth', this.form.place_of_birth);
            formData.append('date_of_birth', this.form.date_of_birth);
            formData.append('id_user', parseInt(this.form.id_user));
            formData.append('phone_number', this.form.phone_number);
            formData.append('job', this.form.job);
            if (this.form.photo_member) {
                formData.append('photo_member', this.form.photo_member);
            }

            let request;
            if (this.form.id_member) {
                // mode update: pakai POST dengan method override
                formData.append('_method', 'PUT');
                request = axios.post(`/api/member/update/${this.form.id_member}`, formData);
            } else {
                // mode create: langsung POST
                request = axios.post('/api/member/create', formData);
            }

            request.then(() => {
                this.$emit('refreshMembers');
                this.closeModal();
            }).catch(error => {
                this.error = error.response?.data?.message || 'An error occurred.';
            });
        },
        handleFileUpload(event) {
            this.form.photo_member = event.target.files[0];
        },
        closeModal() {
            this.resetForm();
            this.$emit('close');
        },
        resetForm() {
            this.form = {
                id_member: null,
                id_user: null,
                name_member: '',
                photo_member: null,
                address: '',
                place_of_birth: '',
                date_of_birth: null,
                phone_number: '',
                job: '',
            };
            this.error = null;
        },
        getUsers() {
            let params = {};
            if (this.form.id_user) {
                params.id_user = this.form.id_user;
            }

            axios.get('/api/userAvail', { params})
                .then(res => this.users = res.data.users || [])
                .catch(() => this.error = 'Failed to load users.');
        }
    }
};
</script>

<style scoped>
.modal {
    overflow-y: auto;
}
</style>

<template>
    <div class="fixed inset-0 z-50 flex pt-20 items-center justify-center bg-gray-200/75 bg-opacity-100 overflow-y-auto">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-3xl mx-4 my-10">
            <div class="px-6 py-4 border-b flex justify-between items-center">
                <h2 class="text-xl font-semibold">{{ form.id_member ? 'Edit Member' : 'Create Member' }}</h2>
                <button class="text-gray-500 hover:text-gray-800" @click="closeModal">&times;</button>
            </div>

            <div class="px-6 py-4">
                <form @submit.prevent="submitForm" class="space-y-4">
                    <div>
                        <label for="name_member" class="block text-sm font-medium text-gray-700 dark:text-white m-1.5">Fullname</label>
                        <input type="text" id="name_member" v-model="form.name_member"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Enter Your Fullname" required/>
                    </div>

                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="place_of_birth" class="block text-sm font-medium text-gray-700 m-1.5">Place Of Birth</label>
                            <input type="text" id="place_of_birth" v-model="form.place_of_birth"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                placeholder="Enter Your Place of Birth" required/>
                        </div>
                        <div>
                            <label for="date_of_birth" class="block text-sm font-medium text-gray-700 m-1.5">Date Of Birth</label>
                            <input type="date" id="date_of_birth" v-model="form.date_of_birth"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                                required/>
                        </div>
                    </div>

                    <div>
                        <label for="address" class="block text-sm font-medium text-gray-700 m-1.5">Address</label>
                        <input type="text" id="address" v-model="form.address"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Enter Your Address" required/>
                    </div>

                    <div>
                        <label for="phone_number" class="block text-sm font-medium text-gray-700 m-1.5">Phone Number</label>
                        <input type="text" id="phone_number" v-model="form.phone_number"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" 
                            placeholder="Enter Your Phone Number" required/>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="job" class="block text-sm font-medium text-gray-700 m-1.5">Job</label>
                            <input type="job" id="stock" v-model="form.job"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                        </div>
                        <div>
                            <label for="id_user" class="block text-sm font-medium text-gray-700 m-1.5">User Account</label>
                            <select id="id_user" v-model.number="form.id_user"
                                class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <option value="" disabled>Pilih Account</option>
                                <option v-for="user in users" :key="user.id" :value="user.id">
                                    {{ user.name }}
                                </option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label for="photo_member" class="block text-sm font-medium text-gray-700 m-1.5">Photo Member</label>
                        <input type="file" id="photo_member" @change="handleFileUpload"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-ful p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>

                    <div v-if="error" class="text-red-600">{{ error }}</div>

                    <div class="flex justify-end gap-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
                            {{ form.id_member ? 'Update' : 'Create' }}
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

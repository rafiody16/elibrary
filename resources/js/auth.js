import { reactive } from "vue";

export const auth = reactive({
    isAuthenticated: localStorage.getItem('isLoggedIn') === 'true',
    role: localStorage.getItem('userRole') || '',
});
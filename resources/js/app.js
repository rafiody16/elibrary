import './bootstrap';
import { createApp } from 'vue';
import App from './components/App.vue';
import router from './index';

const app = createApp(App);
app.use(router);
app.mount('#app');

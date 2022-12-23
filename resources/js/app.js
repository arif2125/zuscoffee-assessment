

import './bootstrap';
import router from "./routes.js";
import App from './App.vue'
import store from './store';
import { createApp } from 'vue';



const app = createApp(App);

import Vue3EasyDataTable from 'vue3-easy-data-table';
import 'vue3-easy-data-table/dist/style.css';
app.component('EasyDataTable', Vue3EasyDataTable);


app.use(router).use(store).mount('#app');

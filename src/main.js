import './assets/css/main.css'

import { createApp, } from 'vue'
import { createPinia } from 'pinia'
import 'vue-select/dist/vue-select.css';
import App from './App.vue'
import router from './router/index'
import $ from 'jquery'


import { 
  BNavbar, BNavbarNav, BNavbarBrand, BNavbarToggle, 
  BNavItem, BCollapse, BNavItemDropdown, BDropdown, BDropdownItem 
} from 'bootstrap-vue-next';

import 'bootstrap'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import DataTable from 'datatables.net-vue3';
import DataTablesCore from "datatables.net";
import Toaster from "@meforma/vue-toaster"
import 'sweetalert2/dist/sweetalert2.min.css';
import Datepicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css';
import 'vue-select/dist/vue-select.css';
import vSelect from 'vue-select'
import Api from './apis/Api'

// optionally import default styles
let timerId

function startLogoutTimer() {
    clearTimeout(timerId)
    timerId = setTimeout(() => {
        localStorage.removeItem("tokenTask")
        window.location.href = '/login'
    }, 30 * 60 * 1000) // 30 minutes en millisecondes
}


function resetLogoutTimer() {
    clearTimeout(timerId)
    startLogoutTimer()
}

Api.interceptors.request.use(config => {
    config.headers.common = {
        Authorization: `Bearer ${localStorage.getItem('tokenTask')}`,
        "Content-Type": "application/json",
        Accept: "application/json"
    }

    resetLogoutTimer()

    return config
})

if ('caches' in window) {
    caches.keys().then(names => {
        for (let name of names) {
            caches.delete(name);
        }
    });
}


Api.interceptors.response.use(
    response => {
        return response;
    },
    error => {
        if (error.response && error.response.status === 401) {
            localStorage.removeItem("tokenTask");
            window.location.href = '/login';
        }
        return Promise.reject(error);
    }
);

const app = createApp(App)
app.config.globalProperties.$ = $;

app.component('BNavbar', BNavbar);
app.component('BNavbarNav', BNavbarNav);
app.component('BNavbarBrand', BNavbarBrand);
app.component('BNavbarToggle', BNavbarToggle);
app.component('BNavItem', BNavItem);
app.component('BCollapse', BCollapse);
app.component('BNavItemDropdown', BNavItemDropdown);
app.component('BDropdown', BDropdown);
app.component('BDropdownItem', BDropdownItem);
app.use($)
app.use(createPinia())
app.use(router)
app.component('DatePicker', Datepicker)
app.use(Toaster)
app.mount('#app')
app.use(DataTable)
app.component('v-select', vSelect)
DataTable.use(DataTablesCore);

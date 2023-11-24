/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

import LoginComponent from "./components/LoginComponent.vue";

require("./bootstrap");
import VModal from "vue-js-modal";
require('./bootstrap');

import Vue from 'vue';
import FooterComponent from './components/FooterComponent.vue';
import HeaderComponent from "./components/HeaderComponent.vue";
import NavbarComponent from "./components/NavbarComponent.vue";
import RoomsListComponent from "./components/RoomsListComponent.vue";
import jobsComponent from "./components/JobsComponent.vue";
import loginComponent from "./components/LoginComponent.vue";
import registerComponent from "./components/RegisterComponent.vue";
import RegisterComponent from "./components/RegisterComponent.vue";

window.Vue = require("vue").default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExComponent.vue").default
);
Vue.use(VModal);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: "#app",
});

const footer = new Vue({
    el: 'footer',
    components: {
        'footer': FooterComponent,
    },
});
const header = new Vue({
    el: 'header',
    components: {
        'header': HeaderComponent,
    },
});
const navbar = new Vue({
    el: 'navbar',
    components: {
        'navbar': NavbarComponent,
    },
});
const roomsList = new Vue({
    el: 'rooms-list',
    components: {
        'rooms-list': RoomsListComponent,
    },
});
const jobs = new Vue({
    el: 'jobs',
    components: {
        'jobs': jobsComponent,
    },
});
const login = new Vue({
    el: 'login',
    components: {
        'login': LoginComponent,
    },
});
const register = new Vue({
    el: 'register',
    components: {
        'register': RegisterComponent,
    },
});

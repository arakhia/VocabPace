/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

import {router} from './router';
import crypto from 'crypto';

window.router =  router;
window._crypto = crypto;

window.Vue = require('vue');

import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';
import Cookies from 'js-cookie';

Vue.use(VueRouter);
Vue.use(BootstrapVue);
Vue.use(Cookies);

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('board-component', require('./components/BoardComponent.vue').default);
Vue.component('guests', require('./components/GuestsSideBarComponent.vue').default);
Vue.component('games-list', require('./components/GamesListComponent.vue').default);
Vue.component('new-game-card', require('./components/NewGameCardComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.mixin({
    methods: {
        getUserAvatarByEmail: function(email)
        {
            var userEmail = window._crypto.createHash('md5').update(email.toLowerCase().trim()).digest('hex');
            var iconURL = "https://www.gravatar.com/avatar/" + userEmail + "?s=180&d=identicon&r=g";
            return iconURL;
        }
    }
});

const app = new Vue({
    el: '#app',
    router,
},);
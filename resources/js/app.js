/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

//const { default: VueRouter } = require('vue-router');
import BoardComponent from './components/BoardComponent';
import GamesListComponent from './components/GamesListComponent';
import UserDashboardComponent from './components/UserDashboardComponent';
require('./bootstrap');



window.Vue = require('vue');

import VueRouter from 'vue-router';
import BootstrapVue from 'bootstrap-vue';

Vue.use(VueRouter);
Vue.use(BootstrapVue);

let routes = [
    {path: '/', component: GamesListComponent},
    {path: '/game/:id', name: 'game', component: BoardComponent},
    {path: '/profile/:username', name: 'profile', component: UserDashboardComponent}
];

window.router = new VueRouter({
    routes
})

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



const app = new Vue({
    el: '#app',
    router
});
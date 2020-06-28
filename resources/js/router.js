import Vue from 'vue';
import VueRouter from 'vue-router';
import ExampleComponent from './components/ExampleComponent';
import BoardComponent from './components/BoardComponent';
import GamesListComponent from './components/GamesListComponent';

Vue.use(VueRouter);


export default new VueRouter({
    routes: [{
        path: '/', component: ExampleComponent
        // path: '/game/12', component: BoardComponent,
        // path: '/list', component: GamesListComponent
    }],
    mode: 'history'
});
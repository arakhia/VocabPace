import Vue from 'vue';
import VueRouter from 'vue-router';
import BoardComponent from './components/BoardComponent';
import GamesListComponent from './components/GamesListComponent';
import UserDashboardComponent from './components/UserDashboardComponent';

Vue.use(VueRouter);

export const router = new VueRouter({
    routes: [
        {
            path: '/', 
            name: 'list', 
            component: GamesListComponent
        },
        {
            path: '/game/:id', 
            name: 'game', 
            component: BoardComponent
        },
        {
            path: '/profile/:username', 
            name: 'profile', 
            component: UserDashboardComponent,
            meta: {
                requiredAuth: true
            }
        },
        {
            path: '*', 
            redirect: {name: 'list'}
        }
    ],
    //mode: 'history'
});

router.beforeEach((to, from, next) => {
    if(to.meta.requiredAuth && window.loggedIn != true){
        window.location.href = 'login';
    } else {
        next();
    }
});
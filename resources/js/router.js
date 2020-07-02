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
            component: BoardComponent,
            meta: {
                requiredAuth: true
            }
        },
        {
            path: '/profile/:username', 
            name: 'profile', 
            component: UserDashboardComponent,
            meta: {
                requiredAuth: true
            }
        }
    ],
    mode: 'history'
});

router.beforeEach((to, from, next) => {
    if(to.meta.requiredAuth){
        window.location.href = 'login';
    } else {
        next();
    }
});
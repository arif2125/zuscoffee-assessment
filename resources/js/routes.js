import { createWebHistory, createRouter } from "vue-router";
import store from './store';
import LoginPage from './pages/auth/LoginPage.vue';
import DashboardPage from './pages/dashboard/DashboardPage.vue';
import UsersPage from './pages/users/UsersPage.vue';
import UsersListPage from './pages/users/UsersListPage.vue';
import UsersCreatePage from './pages/users/UsersCreatePage.vue';
import UsersEditPage from './pages/users/UsersEditPage.vue';
import NotFoundPage from './pages/errors/NotFoundPage.vue';





const routes = [
    {
        path : "/login",
        component: LoginPage,
        name:"login"
    },
    {
        path : "/dashboard",
        component: DashboardPage,
        name:"dashboard",
        alias: ['/home','/']
    },
    {
        path : "/users",
        component: UsersPage,
        name:"users",
        children : [
            {
                path: '',
                component: UsersListPage,
                name:"list.users"
              },
              {
                path: 'create',
                component: UsersCreatePage,
                name:"create.users"
              },
              {
                path: 'edit/:id(\\d+)',
                component: UsersEditPage,
                name:"edit.users"
              },
        ]
    },
    {
        path : "/:url(.*)",
        component: NotFoundPage,
        name:"not-found"
    },
];

const router = createRouter({
    history: createWebHistory(),
    routes, 
})

router.beforeEach((to, from, next) => {
 
        if (!store.state.auth.authenticated && to.name !== 'login') {
            next({ name: "login" });
        }else{
            next();
        }
     
       
});

export default router;
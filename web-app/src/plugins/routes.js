import Vue from 'vue'
import ProductSearchComponent from "../components/pages/ProductSearchComponent";
import SettingsComponent from "../components/pages/SettingsComponent";
import ProductDetailComponent from "../components/pages/ProductDetailComponent";
import LoginComponent from "../components/pages/LoginComponent";
import Router from "vue-router";
import store from './vuex-store.js'

Vue.use(Router)

const routes = [
    {
        path: '/',
        name: 'product_search',
        component: ProductSearchComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/settings',
        name: 'settings',
        component: SettingsComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/items/:slug',
        name: 'product_detail',
        component: ProductDetailComponent,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        name: 'login',
        component: LoginComponent,
        meta: {
            requiresVisitor: true,
        },
    },
]

const router = new Router({
    routes: routes
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (store.getters.isLoggedIn) {
            next()
            return
        }
        next('/login')
    } else if (to.matched.some(record => record.meta.requiresVisitor)) {
        if (store.getters.isLoggedIn) {
            next({name: 'product_search'});
        } else {
            next();
        }
    } else {
        next();
    }
});

export default router;
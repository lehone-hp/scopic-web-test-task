import Vue from 'vue'
import Router from 'vue-router'
import App from './App.vue'
import {library} from '@fortawesome/fontawesome-svg-core'
import {faFilter} from '@fortawesome/free-solid-svg-icons'
import {FontAwesomeIcon} from '@fortawesome/vue-fontawesome'
import {BootstrapVue} from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'jquery/src/jquery.js'
import 'bootstrap/dist/js/bootstrap.min.js'

// Import Bootstrap an BootstrapVue CSS files (order is important)
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'

import './assets/main.css'

import ProductSearchComponent from "./components/pages/ProductSearchComponent";
import ProductDetailComponent from "./components/pages/ProductDetailComponent";
import SettingsComponent from "./components/pages/SettingsComponent";

Vue.config.productionTip = false

Vue.use(Router)
Vue.use(BootstrapVue)

// Font Awesome
Vue.component('font-awesome-icon', FontAwesomeIcon)
library.add(faFilter)

// Util Components
Vue.component('modal', require('./components/utils/Modal').default);
Vue.component('button-spinner', require('./components/utils/ButtonSpinner').default);
Vue.component('empty-search', require('./components/utils/EmptySearchComponent').default);

const router = new Router({
    routes: [
        {
            path: '/', name: 'product_search', component: ProductSearchComponent,
        },
        {
            path: '/settings', name: 'settings', component: SettingsComponent,
        },
        {
            path: '/:slug', name: 'product_detail', component: ProductDetailComponent,
        }
    ]
});

new Vue({
    render: h => h(App),
    router,
}).$mount('#app')

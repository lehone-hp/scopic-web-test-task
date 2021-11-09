import Vue from 'vue'
import App from './App.vue'
import router from "./plugins/routes";
import store from "./plugins/vuex-store";
import Vuelidate from 'vuelidate'
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

// Main application styles
import './assets/main.css'

Vue.config.productionTip = false

Vue.use(BootstrapVue)
Vue.use(Vuelidate)

// Font Awesome
Vue.component('font-awesome-icon', FontAwesomeIcon)
library.add(faFilter)

// Util Components
Vue.component('modal', require('./components/utils/Modal').default);
Vue.component('button-spinner', require('./components/utils/ButtonSpinner').default);
Vue.component('empty-search', require('./components/utils/EmptySearchComponent').default);


new Vue({
    render: h => h(App),
    router,
    store: store,
}).$mount('#app')

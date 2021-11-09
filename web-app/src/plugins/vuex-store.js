import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex);
const store = new Vuex.Store({
    state: {
        user: localStorage.getItem('user') || null,
    },
    mutations: {
        setAuthUser(state, user) {
            state.user = user;
        },
        logout(state){
            state.user = null
        },
    },
    getters: {
        isLoggedIn(state) {
            return state.user !== null;
        },
        authUser(state) {
            return state.user ? JSON.parse(state.user) : null;
        }
    }
});

export default store;
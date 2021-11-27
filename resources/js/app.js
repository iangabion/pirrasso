
require('./bootstrap');
window.Vue = require('vue');

import Vuex from "vuex"
import vuetify from './vuetify';
import * as VeeValidate from 'vee-validate';
import App from './components/MainComponent' ;
import router from './router';
import global_mixin from './components/mixins/global';
import VueDraggable from 'vue-draggable';
import Vue from "vue";

Vue.use(Vuex);

const store = new Vuex.Store(
    {
        state: {
            authenticated: false
        },
        mutations: {
            setAuthentication(state, status) {
                state.authenticated = status;
            }
        }
    }
);

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
      // this route requires auth, check if logged in
      // if not, redirect to login page.
      if (store.state.authenticated == false) {
        next({ name: 'Login' })
      } else {
        next() // go to wherever I'm going
      }
    } else {
      next() // does not require auth, make sure to always call next()!
    }
  })





axios.interceptors.response.use( ( response ) => {
    // store.commit('HIDE_LOADER')
    return response;
}, ( error ) => {
    let message = ''

    switch (error.response.status) {
        case 404:
            message = 'we did not find this page'
            break;
        case 500:
                message = 'Internal server error. Please contact the developer to resolve this issue.'
                break;
        case 503:
                message = 'Service unavailable, please check your internet connection to continue..'
                break;
        case 401:
                message = 'Sorry, you\'re not authenticated to do this action.'
                break;
        case 422:
            for (var key in error.response.data.errors) {
                message += '* '+error.response.data.errors[key];
            }
            break;
        default:
            message = 'Opps, something went wrong with the processing of your application.'
            break;
    }

    window.scroll({ top: 0, left: 0, behavior: 'smooth' })

    alert(message)
    // store.commit('HIDE_LOADER')
    // store.commit('SHOW_BANNER', {visible:1, message:message, status:2})
    return Promise.reject( error );
});
Vue.use(VeeValidate);
Vue.component('app-confirm', require('./components/alerts/confirm.vue').default);
Vue.component('app-alert', require('./components/alerts/snackbar.vue').default);
Vue.mixin(global_mixin)
Vue.use(VueDraggable)



new Vue({
    el: '#app',
    router,
    store,
    vuetify,
    components:{
        'App' : App
    }
});

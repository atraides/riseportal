
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('babel-polyfill');

window.to = require('to-case');

window.Vue = require('vue');

Vue.prototype.authorize = function (handler) {
    // Additional admin privileges here.
    let user = window.App.user;

    return user ? handler(user) : false;
};

window.events = new Vue();

import Vuelidate from 'vuelidate';
Vue.use(Vuelidate);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('characters', require('./components/Characters.vue'));
Vue.component('userdetails', require('./components/UserDetails.vue'));
Vue.component('navbar', require('./components/NavBar.vue'));
Vue.component('rlpvote', require('./components/RLPVote.vue'));
Vue.component('login', require('./components/LoginWindow.vue'));

Vue.component(
    'passport-clients',
    require('./components/passport/Clients.vue')
);

Vue.component(
    'passport-authorized-clients',
    require('./components/passport/AuthorizedClients.vue')
);

Vue.component(
    'passport-personal-access-tokens',
    require('./components/passport/PersonalAccessTokens.vue')
);

const app = new Vue({
    el: '#app'
});

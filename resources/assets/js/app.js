
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.to = require('to-case');

window.Vue = require('vue');

Vue.prototype.authorize = function (handler) {
    // Additional admin privileges here.
    let user = window.App.user;

    return user ? handler(user) : false;
};

window.events = new Vue();

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('characters', require('./components/Characters.vue'));
Vue.component('usermenu', require('./components/UserMenu.vue'));

const app = new Vue({
    el: '#app'
});

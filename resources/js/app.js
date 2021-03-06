/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import BootstrapVue from 'bootstrap-vue';
import Vue from 'vue';

require('./bootstrap');

//window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))
Vue.use(BootstrapVue);
Vue.component('list-component', require('./components/ListComponent.vue').default);
Vue.component('add-component', require('./components/AddComponent.vue').default);
Vue.component('edit-component', require('./components/EditComponent.vue').default);
Vue.component('list-feedback-component', require('./components/Feedback/ListFeedbackComponent.vue').default);
Vue.component('add-feedback-component', require('./components/Feedback/AddFeedbackComponent.vue').default);
Vue.component('edit-feedback-component', require('./components/Feedback/EditFeedbackComponent.vue').default);
Vue.component('list-nachrichten-component', require('./components/Nachrichten/ListNachrichtenComponent.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app'
});

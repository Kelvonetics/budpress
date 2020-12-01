
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */


import VueRouter from 'vue-router'
import Routes from './route'
import jsPDF from 'jspdf'

// require('./bootstrap');




window.Vue = require('vue');

Vue.use (VueRouter);

const router = new VueRouter({
	routes: Routes,
    base: '/',
    mode: 'history',
    history: true
});




/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('home', require('./components/Home.vue').default);
Vue.component('users', require('./components/Users.vue').default);
Vue.component('departments', require('./components/Department.vue').default);
Vue.component('roles', require('./components/Roles.vue').default);
Vue.component('permissions', require('./components/Permissions.vue').default);
Vue.component('budgets', require('./components/Budgets.vue').default);
Vue.component('budget-details', require('./components/BudgetDetails.vue').default);
Vue.component('imprests', require('./components/Imprests.vue').default);
Vue.component('budget-imprest-expenses', require('./components/ImprestDetails.vue').default);
Vue.component('expenses', require('./components/Expenses.vue').default);

Vue.component('workflows', require('./components/Workflow.vue').default);
Vue.component('flows', require('./components/Flow.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue(
{
    el: '#app',
    router: router
});

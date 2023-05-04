/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import vuetify from './vuetify';
import home_admin from './components/admin/home.vue'
import member_list from './components/admin/MemberList.vue'
import budget_plan from './components/admin/BudgetPlan.vue'
import list_promo from './components/admin/ListPromo.vue'

import home_member from './components/member/home.vue'
import budget_plan_member from './components/member/BudgetPlan.vue'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('home-admin', home_admin);
Vue.component('member-list', member_list);
Vue.component('budget-plan', budget_plan);
Vue.component('list-promo', list_promo);

Vue.component('home-member', home_member);
Vue.component('budget-plan-member', budget_plan_member);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    vuetify
});

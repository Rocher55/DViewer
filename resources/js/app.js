
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import BootstrapVue from 'bootstrap-vue'

Vue.use(BootstrapVue)
/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('example-component', require('./components/ExampleComponent.vue').default);

//custom component

Vue.component('GeneListComponent', require('./components/GeneListComponent.vue').default);
Vue.component('select-protocol-component', require('./components/select-protocol-component.vue').default);
Vue.component('select-center-component', require('./components/select-center-component.vue').default);
Vue.component('select-cid-component', require('./components/select-CID-component.vue').default);
Vue.component('container-proto-center', require('./components/container-proto-center.vue').default);
Vue.component('main-import',require('./components/main-import').default);
Vue.component('upload-component',require('./components/upload-component.vue').default);
Vue.component('wrapper-upload-component-patient',require('./components/wrapper-upload-component-patient.vue').default);

Vue.component('child-test', require('./components/ChildTest.vue').default);
Vue.component('parent-test', require('./components/ParentTest.vue').default);

//downloaded component

Vue.component('multiselect', require('../../node_modules/vue-multiselect/src/Multiselect').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
const eventHub = new Vue()

export default eventHub; // Global event bus

const app = new Vue({
    el: '#app'
});



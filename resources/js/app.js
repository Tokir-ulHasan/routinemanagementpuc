import Vue from 'vue';
import router from './routes';
require('./bootstrap');
import $ from 'jquery'; 

import axios from 'axios'
// import VueAxios from 'vue-axios'

Vue.prototype.$http = axios;

new Vue.use($);

const app = new Vue({
    el: '#app',
    router
});
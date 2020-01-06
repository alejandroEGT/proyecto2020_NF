

// app.js

require('./bootstrap');

window.Vue = require('vue');

import Rutas from './rutas.js';
// import routes_alejandro from './routes/alejandro.js'
// import routes_bryanv from './routes/bryanv.js'
// import routes_empa from './routes/empa.js'
// import routes_sumbex from './routes/sumbex.js'

import VueRouter from 'vue-router';
Vue.use(VueRouter);

import axios from 'axios';
import VueAxios from 'vue-axios';

import App from './components/ExampleComponent.vue';
Vue.use(VueAxios, axios);

// import VueMaterial from 'vue-material'
// import 'vue-material/dist/vue-material.min.css'

import VueAuth from '@websanova/vue-auth'


import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
Vue.use(ElementUI);


const router = new VueRouter({
  routes: [
    ...Rutas,
    // ...routes_alejandro,
    // ...routes_bryanv,
    // ...routes_empa,
    // ...routes_sumbex
  ],
  // mode: 'history'
});
Vue.router = router;

App.router = Vue.router;



Vue.use(require('@websanova/vue-auth'), {
   auth: require('@websanova/vue-auth/drivers/auth/bearer.js'),
   http: require('@websanova/vue-auth/drivers/http/axios.1.x.js'),
   router: require('@websanova/vue-auth/drivers/router/vue-router.2.x.js'),
   rolesVar: 'type',//aqui va la columna rol de users
   loginData: {url: ' api/auth/login'},
   logoutData: {url: ' api/auth/logout'},
   fetchData: {url: ' api/auth/user'},
   refreshData: {enabled: false},
});

new Vue(App).$mount('#app');


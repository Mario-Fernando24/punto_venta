require('./bootstrap');

window.Vue = require('vue');

 const files = require.context('./', true, /\.vue$/i)
 
 files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('Categoria', require('./components/Categoria.vue').default);
Vue.component('Articulo', require('./components/Articulo.vue').default);
Vue.component('Cliente', require('./components/Cliente.vue').default);
Vue.component('Proveedor', require('./components/Proveedor.vue').default);
Vue.component('Roles', require('./components/Roles.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        menu: 0
    }
});

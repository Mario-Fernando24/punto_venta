require('./bootstrap');

window.Vue = require('vue');

 const files = require.context('./', true, /\.vue$/i)
 
 files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('Categoria', require('./components/Categoria.vue').default);
Vue.component('Articulo', require('./components/Articulo.vue').default);
Vue.component('Cliente', require('./components/Cliente.vue').default);
Vue.component('Proveedor', require('./components/Proveedor.vue').default);
Vue.component('Roles', require('./components/Roles.vue').default);
Vue.component('User', require('./components/User.vue').default);
Vue.component('Ingreso', require('./components/Ingreso.vue').default);
Vue.component('Venta', require('./components/Venta.vue').default);
Vue.component('Dashboard', require('./components/Dashboard.vue').default);
Vue.component('Caja', require('./components/Caja.vue').default);
Vue.component('Egreso', require('./components/DocumentoCaja/Egreso.vue').default);
Vue.component('Credito', require('./components/DocumentoCaja/Creditos.vue').default);
Vue.component('Anuladas', require('./components/Informes/FacturasAnuladas.vue').default);
Vue.component('Informes', require('./components/Informes/InformesComponenet.vue').default);
Vue.component('Ajusteinventario', require('./components/DocumentoCaja/AjusteInventario.vue').default);
Vue.component('Notificacion', require('./components/Notificacion.vue').default);
Vue.component('Caba', require('./components/Caba.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */


 import * as VueGoogleMaps from "vue2-google-maps";

 Vue.use(VueGoogleMaps, {
    load: {
      key: "AIzaSyDW_p10NjPm2ru42ZNu_Oj-UgdV1BVcZuc",
    },
    installComponents: true,
  });
  

const app = new Vue({
    el: '#app',
    data: {
        menu: 0,
       // notifications:'',
    }
});

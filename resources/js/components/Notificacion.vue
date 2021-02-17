<template>
    <li class="nav-item d-md-down-none">
                <a class="nav-link" href="#" data-toggle="dropdown">
                    <i class="icon-bell"></i>

                    <div v-if="compra.numero>0 || venta.numero>0">    
                       <span class="badge badge-pill badge-danger">.</span>
                    </div>

                    <div v-if="compra.numero>0 && venta.numero>0">  
                       <span class="badge badge-pill badge-danger"></span>
                    </div>  

                </a>
                <div class="dropdown-menu dropdown-menu-right">
                    <div class="dropdown-header text-center">
                        <strong>Notificaciones</strong>
                    </div>


                <div v-if="compra.numero>0 || venta.numero>0">    
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-envelope-o" style="color:black" v-text="compra.msj"></i>  
                        <span class="badge badge-success" v-text="compra.numero"></span>
                    </a>
                    <a class="dropdown-item" href="#">
                        <i class="fa fa-tasks" style="color:black" v-text="venta.msj"></i> 
                        <span class="badge badge-danger" v-text="venta.numero"></span>
                    </a>
                </div>  

                <div v-if="compra.numero==0 && venta.numero==0">    
                    <a>Ninguna notificación</a>
                </div>


                </div>
            </li>
</template>

<script>
    export default {
         data () {
    return {
      notificaciones: '',
      compra:'',
      venta:''
    }

        },

        computed :{},
        
         methods: {},

    async mounted () {
    const response = await fetch("showNotificacion")
    this.notificaciones  = await response.json()
            this.compra=this.notificaciones.arregloDatos.ingresos;
            this.venta=this.notificaciones.arregloDatos.ventas
  },

    }
</script>
